<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AccordionItem extends Component
{
    /**
     * Create a new component instance.
     */
    public int $uniqueId = 0;
    public function __construct(
        public string $title = ""
    ) {
        $this->uniqueId = rand(1, 99999);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.accordionitem', ['uniqueId' => $this->uniqueId, 'title' => $this->title]);
    }
}
