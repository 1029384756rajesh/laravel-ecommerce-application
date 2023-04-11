<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormControl extends Component
{
    public function __construct(
        public $type = "",
        public $id = "",
        public $name = "",
        public $label = "",
        public $value = ""
    ) {

    }
 
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form-control');
    }
}
