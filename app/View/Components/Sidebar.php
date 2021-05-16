<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\User;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @var string
     */
    public $subscriptions;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    
    public function __construct($subscriptions)
    {
        $this->subscriptions = $subscriptions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.sidebar');
    }
}
