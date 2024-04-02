<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Accordion extends Component
{
    /**
     * Create a new component instance.
     */
    private int $uniqueId = 0;
    public function __construct()
    {
        $this->uniqueId = rand(1, 99999);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.accordion', ['uniqueId' => $this->uniqueId]);
    }
}
