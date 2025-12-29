<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FileIcon extends Component
{
    public $file;
    public $size;

    /**
     * Create a new component instance.
     */
    public function __construct($file, $size = 'medium')
    {
        $this->file = $file;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.file-icon');
    }
}