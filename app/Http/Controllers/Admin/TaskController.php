<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Opgaver\TaskResolver;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller {

    private $allowedFunctions = ['rand'];


    public function create($task = null)
    {
        /*$test = "php " . app_path() . "\\code-validation.php " . escapeshellcmd('$s2=rand(1,1);');
        $test = exec($test);
        dd($test);*/
        $json = [];
        $json['text'] = "some question";
        $json['value'] = 'A($a ; $b) \\\\; B($c ; $d)';
        $json['input'] = [];

        return view('admin.tasks.create', compact('task', 'genOptions'));
    }

    public function doCreate($task = null)
    {
        //region check for forbidden functions
        $functions = [];
        foreach (preg_split("/((\r?\n)|(\r\n?))/", request('variables')) as $line)
        {
            $line = preg_replace('/\s+/', '', $line);
            if ( ! preg_match('#([A-Za-z0-9_]+)\((.*)\)#', $line))
                continue;
            preg_match_all('#([A-Za-z0-9_]+)\(#', $line, $matches);
            $functions = array_merge($matches[1], $functions);
        }
        $functions = array_unique($functions);
        $forbiddenFunctions = array_diff($functions, array_intersect($functions, $this->allowedFunctions));
        if (count($forbiddenFunctions) > 0)
            return redirect()->route('admin.tasks.create', $task)
                ->withInput()
                ->withError('The following functions are not allowed: ' . implode(', ', $forbiddenFunctions));
        //endregion
        //region Check code for syntax errors
        $line = preg_replace('/\s+/', '', request('variables'));
        $run = "php " . app_path() . "\\code-validation.php " . addslashes($line);
        $run = exec($run);
        if ($run != "")
            return redirect()->route('admin.tasks.create', $task)
                ->withInput()
                ->withError($run);
        //endregion
        $options['text'] = request('question');
        $options['value'] = request('math-question');
        $options['input'] = [];
        if (is_null($task))
        {
            $task = Task::create([
                'generator'       => request('variables'),
                'options'         => $options,
                'status'          => 'unfinished',
                'sub_exercise_id' => 999,
                'validator'       => ''
            ]);

            return redirect()->route('admin.tasks.create', $task)->withSuccess('The task was created.');
        }
        $task->update([
            'generator'       => request('variables'),
            'options'         => $options,
            'status'          => 'unfinished',
            'sub_exercise_id' => 999,
        ]);

        return redirect()->route('admin.tasks.create', $task)->withInput()->withSuccess('The task was updated.');
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
            'type' => request('new.type'),
            'format' => request('new.format'),
            'text' => request('new.text'),
            'name' => request('new.name')
        ];
        $currentInput[] = $newInput;
        $taskOptions['input'] = $currentInput;
        $task->update(['options' => $taskOptions]);
        return redirect()->route('admin.tasks.inputs');
    }
}
