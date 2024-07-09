<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class IssueTable extends Component
{
    public $userAccessToken;
    /**
     * Create a new component instance.
     */
    public function __construct($userAccessToken)
    {
        $this->userAccessToken = $userAccessToken;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.issue-table');
    }
}
