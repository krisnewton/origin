<?php

namespace App\View\Components;

use Illuminate\View\Component;

class File extends Component
{
	public $id;
	public $name;
	public $invalid;
	public $message;
    public $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($id = '', $name = '', $message = '', $label = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->message = $message;
        $this->label = $label;

        if (empty($message)) {
        	$this->invalid = false;
        }
        else {
        	$this->invalid = true;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.file');
    }
}
