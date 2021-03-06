<?php 
	namespace Gaia\Repositories;

	interface CategoryRepositoryInterface
	{
		public function getAll();
		public function getRoots();
		public function getDescendants($category);
		public function getCategoryTree($category);
		public function getCategoryBySlug($slug);
		public function find($id);
	}
?>