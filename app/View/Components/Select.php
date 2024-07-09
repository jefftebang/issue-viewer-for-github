<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    public $selectNoValue;
    public $arrToMap;
    public $opts;
    public $selId;
    /**
     * Create a new component instance.
     */
    public function __construct($selectNoValue, $arrToMap, $opts, $selId)
    {
        $this->arrToMap = $arrToMap;
        $this->selectNoValue = $selectNoValue;
        $this->opts = $opts;
        $this->selId = $selId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}
