<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ServerImage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $style = "",
        public $class = "",
        public $value = "",
        public $name = ""
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.server-image');
    }
}
