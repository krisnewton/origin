<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FormGroupSelect extends Component
{
	public $label;
	public $name;
	public $id;
	public $value;
	public $invalid;
	public $message;
	public $options;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = 'Field Name', $name = '', $id = '', $value = '', $message = '', $options = [])
    {
    	$this->label 	= $label;
        $this->name 	= $name;
		$this->id 		= $id;
		$this->value 	= $value;
        $this->message 	= $message;
        $this->options 	= $options;

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
        return view('components.form-group-select');
    }
}
