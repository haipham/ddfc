<?php namespace Gaia\Repositories; 

use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{
	
	/**
	 * Get all the categories
	 * @return type
	 */
	public function getAll()
	{	
		return Category::all();
	}

	public function find($id)
	{
		return Category::find($id);
	}

	/**
	 * Get Categories that are roots
	 * @return type
	 */
	public function getRoots()
	{
		return Category::defaultOrder()->whereParentId(null)->get();
	}


	/**
	 * Get Descandants of a certain category
	 * @param type $category 
	 * @param type $order 
	 * @return type
	 */
	public function getDescendants($category, $order = "title")
	{
		return $category->descendants()->orderBy($order)->get();
	}


	/**
	 * Get Category tree hierarchy
	 * @param type $category 
	 * @param type $order 
	 * @return type
	 */
	public function getCategoryTree($category, $order = "title")
	{
		return $category->descendants()->orderBy($order)->lists('title', 'id'); 
	}


	/**
	 * Gets a Category by its slug
	 * @param type $slug 
	 * @return type
	 */
	public function getCategoryBySlug($slug)
	{
		return Category::where('slug', '=', $slug)->first();
	}
}
?>