<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ServerImage extends Component
{
    public function __construct(
        public $style = "",
        public $class = "",
        public $value = "",
        public $name = "",
        public $label = ""
    )
    {
    }

    public function render()
    {
        return view('components.server-image');
    }
}
