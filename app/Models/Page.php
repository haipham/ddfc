<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vinkla\Translator\Translatable;
use Vinkla\Translator\Contracts\Translatable as TranslatableContract;

class Page extends Model {

	use Translatable;

	protected $table = 'page';
	protected $fillable = ['title', 'slug', 'description', 'template_id', 'created_at'];
	protected $hidden = [];
	//translator
	protected $translatedAttributes = ['title', 'description'];
	protected $translator = 'App\Models\PageTranslation';
	//for Component page build
	protected $except = ['_token', 'title', 'slug', 'description', 'remove_image', 'meta_title', 'locale', 'meta_description', 'meta_keywords', 'facebook_title', 'facebook_description', 'twitter_title', 'twitter_description'];

	/**
	 * Template Relation
	 * @return type
	 */
	public function template()
	{
		return $this->belongsTo('App\Models\Template');
	}


	/**
	 * ComponentPage Relation
	 * @return type
	 */
	public function componentPages()
	{
		return $this->hasMany('App\Models\ComponentPage');
	}


	/**
	 * Morphing to Seo Model
	 * @return type
	 */
	public function seo()
	{
	    return $this->morphOne('App\Models\Seo', 'seoable');
	}


	/**
	 * Returns an array of Component ids with their values repsectively.
	 * Done in PageController@edit. 
	 * @param type $input 
	 * @return type
	 */
	public function retrieveComponentIds($input)
	{
		//get the components ids from inputs and update their values
		$componentIds = array_except($input, $this->except);
		$array = [];

		if(is_array($componentIds) && count($componentIds))
		{
			foreach($componentIds as $key => $val)
			{
				$id = (int)str_replace("cp_", "", $key);
			 	(is_array($val))?$value = implode(",", $val):$value=$val; //in case of checkbox type, implode the array to string
			 	$array[$id] = ['value' => $value];
			}
		}

		return $array;
	}


	/**
     * Return the media collection name
     * @return type
     */
    public function getMediaCollectionName()
    {
    	return "collection-".$this->id;
    }


    /**
	 * Front Related: Get All Metas
	 * @return type
	 */
	public function getMetas()
	{
		$metas = [];
		foreach($this->componentPages as $componentPage)
		{
			$key = $componentPage->component->unique_id;
			if($componentPage->component->component_type_id == 3) //image
			{

				$mediaItems = MediaLibrary::getCollection($componentPage, $componentPage->getMediaCollectionName(), []);
				(count($mediaItems))?$url = $mediaItems[0]->getURL():$url = null;
				$metas[$key] = $url;
			}	 
			else
				$metas[$key] = $componentPage->value;
		}

		return $metas;
	}


	public function getMeta($id)
	{
		$metas = $this->getMetas();
		
		if(isset($metas[$id]))
			return $metas[$id];

		return null;
	}

}