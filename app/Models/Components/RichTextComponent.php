<?php namespace App\Models\Components;

use App\Models\Component;
use View;

class RichTextComponent extends Component {

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
		$view = View::make('admin.templates.components._richtext', ['component' => $this->component]);
		return $view->render();
	}


	/**
	 * Render the component form row in the page or post create
	 * @param type $type 
	 * @param type $id post_id or page_id, can be null for create case
	 * @return type
	 */
	public function renderFormRow($type = 'page', $id = null)
	{
		//cp can be ComponentPage or ComponentPost objects
		if($type == 'post')
			$cp = $this->component->getComponentPost($id);
		else 
			$cp = $this->component->getComponentPage($id);

		if(isset($cp)) 
		{
			$value  = $cp->value;
			$params = $cp->params;
		}
		else
		{
			$value = "";
			$params = [];
		}

		$view = View::make('admin.templates.components._richtext_form_row', ['component' => $this->component, 'value' => $value]);
		return $view->render();

	} 

}