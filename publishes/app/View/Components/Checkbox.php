<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Str;

class Checkbox extends Component
{
	public $label;
	public $id;
	public $isChecked;
	public $name;
	public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label = '', $id = '', $isChecked = false, $name = '', $value = '')
    {
        $this->label = $label;
        $this->id = Str::camel(str_replace('.', '_', $id));
        $this->isChecked = $isChecked;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checkbox');
    }
}
