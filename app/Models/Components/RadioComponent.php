<?php namespace App\Models\Components;

use App\Models\Component;
use View;

class RadioComponent extends Component {


	protected $component;

	
	public function setComponent($component)
	{
		$this->component = $component;
	}

	/**
	 * Renders the component in the template builder
	 * @return type
	 */
	public function render()
	{
		$view = View::make('admin.templates.components._radio', ['component' => $this->component]);
		return $view->render();
	}



	/**
	 * Render the component form row in the page create
	 * @return type
	 */
	public function renderFormRow($pageId)
	{
		$options = $this->component->optionsToArray();
		$component_page = $this->component->getPivot($pageId);
		
		if(isset($component_page)) 
		{
			$value  = explode(",",$component_page->pivot->value);
			$params = $component_page->pivot->params;
		}
		else
		{
			$value = [];
			$params = [];
		}

		$view = View::make('admin.templates.components._radio_form_row', ['component' => $this->component, 'options' => $options, 'value' => $value]);
		return $view->render();
	} 

}