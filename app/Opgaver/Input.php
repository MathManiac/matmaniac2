<?php

namespace App\Opgaver;

class Input
{

    /**
     * Input constructor.
     * @param string $title
     * @param $name
     */
    public function __construct($name, $title = 'Dit svar', $placeholder = '')
    {
        $this->title = $title;
        $this->name = $name;
        $this->placeholder = $placeholder;
    }

    public $title;

    public $name;

    public $placeholder;
}