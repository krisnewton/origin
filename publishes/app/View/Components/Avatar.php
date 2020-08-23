<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Avatar extends Component
{
	public $url;
	public $size;
	
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($url= '', $size = 128)
    {
        $this->url = $url;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.avatar');
    }
}
