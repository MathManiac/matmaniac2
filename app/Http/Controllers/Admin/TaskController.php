<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Opgaver\TaskRepository\Resolver;
use App\Opgaver\TaskResolver;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller {

    private $allowedFunctions = ['rand', 'pow', 'sqrt'];

    public function __construct()
    {
        $this->middleware('admin.chain')->only('create', 'inputs', 'validation', 'final');
    }

    private function getForbiddenFunctions($variables)
    {
        $functions = [];
        foreach (preg_split("/((\r?\n)|(\r\n?))/", $variables) as $line)
        {
            $line = preg_replace('/\s+/', '', $line);
            if ( ! preg_match('#([A-Za-z0-9_]+)\((.*)\)#', $line))
                continue;
            preg_match_all('#([A-Za-z0-9_]+)\(#', $line, $matches);
            $functions = array_merge($matches[1], $functions);
        }
        $functions = array_unique($functions);
        $forbiddenFunctions = array_diff($functions, array_intersect($functions, $this->allowedFunctions));

        return $forbiddenFunctions;
    }

    private function getErrors($variables, Task $task)
    {
        if ( ! is_null($task->chained_to))
            $variables = $this->getChainCode($task) . $variables;
        $line = preg_replace('/\s+/', '', $variables);
        $run = "php " . app_path() . "\\code-validation.php " . addslashes($line);
        $run = exec($run);

        return $run;
    }

    public function getChainCode(Task $task)
    {
        $taskResolver = app()->make(Resolver::class);
        $parents = $taskResolver->chain($task);
        $code = '';
        foreach ($parents as $parentTask)
            $code .= $parentTask->generator . $parentTask->validator;

        return $code;
    }

    public function create($task = null)
    {
        return view('admin.tasks.create', compact('task', 'genOptions'));
    }

    public function doCreate($task = null)
    {
        if (is_null($task))
        {
            $task = new Task();
            if (request()->has('previous'))
                $task->chained_to = request('previous');
            $task->options = [];
        }
        $forbiddenFunctions = $this->getForbiddenFunctions(request('variables'));
        if (count($forbiddenFunctions) > 0)
            return redirect()->route('admin.tasks.create', $task)
                ->withInput()
                ->withError('The following functions are not allowed: ' . implode(', ', $forbiddenFunctions));

        if (request('variables') != '')
        {
            $codeErrors = $this->getErrors(request('variables'), $task);
            if ($codeErrors != "")
                return redirect()->route('admin.tasks.create', $task)
                    ->withInput()
                    ->withError($codeErrors);
        }
        $options = $task->options;
        $options['text'] = request('question');
        $options['value'] = request('math-question');
        if ( ! array_key_exists('input', $options))
            $options['input'] = [];
        $task->generator = request('variables');
        $task->options = $options;
        $task->status = 'unfinished';
        $task->sub_exercise_id = 999;
        if (is_null($task->validator))
            $task->validator = '';
        $task->save();

        return redirect()->route('admin.tasks.create', $task->id)->withInput()->withSuccess('The task was updated.');
    }

    public function inputs(Task $task)
    {
        $inputs = $task->options['input'];

        return view('admin.tasks.inputs', compact('task', 'inputs'));
    }

    public function addInput()
    {
        return redirect()->back()->withNewInput(request('type'));
    }

    public function saveInput(Task $task)
    {
        $taskOptions = $task->options;
        $currentInput = $taskOptions['input'];
        $newInput = [
            'type'   => request('new.type'),
            'format' => request('new.format'),
            'text'   => request('new.text'),
            'name'   => request('new.name')
        ];
        $currentInput[] = $newInput;
        $taskOptions['input'] = $currentInput;
        $task->update(['options' => $taskOptions]);

        return redirect()->route('admin.tasks.inputs', [$task->id]);
    }

    public function updateInputs(Task $task)
    {
        $taskOptions = $task->options;
        $currentInput = $taskOptions['input'];
        $newInput = request('input');
        for ($i = 0; $i < count($newInput); $i ++)
        {
            $currentInput[$i]['text'] = $newInput[$i]['text'];
            $currentInput[$i]['name'] = $newInput[$i]['name'];
            $currentInput[$i]['format'] = $newInput[$i]['format'];
        }
        $taskOptions['input'] = $currentInput;
        $task->update(['options' => $taskOptions]);

        return redirect()->route('admin.tasks.inputs', [$task->id])->withSuccess('The inputs were updated.');;
    }

    public function inputAction(Task $task)
    {
        $options = $task->options;
        $inputs = $options['input'];
        if (request('action') == 'delete')
            unset($inputs[request('id')]);
        if (request('action') == 'move-up' || request('action') == 'move-down')
        {
            $upOrDown = request('action') == 'move-up' ? - 1 : + 1;
            $temp = $inputs[request('id')];
            $inputs[request('id')] = $inputs[request('id') + $upOrDown];
            $inputs[request('id') + $upOrDown] = $temp;
        }
        $inputs = array_values($inputs);
        $options['input'] = $inputs;
        $task->update(['options' => $options]);

        return redirect()->route('admin.tasks.inputs', [$task->id]);
    }

    public function validation(Task $task)
    {
        $taskResolver = app()->make(Resolver::class);
        $variables = $taskResolver->getGeneratorVariables($task);
        if (session()->has('chain.shared'))
        {
            $chainVariables = [];
            foreach (session('chain.shared') as $cVar => $cVarContent)
                $chainVariables[] = '$' . $cVar;
            $variables = array_merge($variables, $chainVariables);
        }
        $variables = array_unique($variables);
        sort($variables);
        $requiredVariables = $taskResolver->getInputVariables($task);
        array_walk($requiredVariables, function (&$value, $key)
        {
            $value = '<b>$answer' . studly_case($value) . '</b>';
        });
        $isAnswered = $taskResolver->allInputsAnswered($task);

        return view('admin.tasks.validation', compact('task', 'variables', 'requiredVariables', 'isAnswered'));
    }

    public function saveValidation(Task $task)
    {
        $variables = $task->generator . request('variables');
        $forbiddenFunctions = $this->getForbiddenFunctions(request('variables'));
        if (count($forbiddenFunctions) > 0)
            return redirect()->route('admin.tasks.validation', $task)
                ->withInput()
                ->withError('The following functions are not allowed: ' . implode(', ', $forbiddenFunctions));
        $codeErrors = $this->getErrors($variables, $task);
        if ($codeErrors != "")
            return redirect()->route('admin.tasks.validation', $task)
                ->withInput()
                ->withError($codeErrors);
        $task->update(['validator' => request('variables')]);

        return redirect()->route('admin.tasks.validation', $task)->withSuccess('The task was updated.');
    }

    public function final(Task $task)
    {
        return view('admin.tasks.final', compact('task'));
    }

    public function runTests(Task $task)
    {
        $questions = [];
        foreach (range(1, 20) as $try)
        {
            usleep(100000); //0.1 seconds
            $questions[] = $task->getQuestion(true);
        }

        return view('admin.tasks.runTests', compact('task', 'questions'));
    }

    public function updateStatus(Task $task)
    {
        $task->update(['status' => request('status')]);

        return redirect()->route('admin.tasks.final', $task)->withSuccess('The status was changed.');
    }
}