<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
	public $links;
	public $size;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($links = [], $size = 'sm')
    {
        $this->links = $links;

        switch ($size) {
        	case 'sm':
        		$this->size = setting('style.small_class');
        		break;
        	case 'md':
        		$this->size = setting('style.medium_class');
        		break;
        	case 'lg':
        		$this->size = setting('style.large_class');
        		break;
        	default:
        		$this->size = setting('style.large_class');
        		break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
