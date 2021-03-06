<?php

use App\Models\Category;
use App\Models\PostType;
use App\Models\Post;
use App\Models\Page;
use App\Models\News;



//Route::group(['middleware' => 'auth'], function () {


    /*
    |--------------------------------------------------------------------------
    | Search ROUTES
    |--------------------------------------------------------------------------
    */
    Route::post('/search/', ['as' => 'search.index', 'uses' => 'SearchController@index']);
    Route::get('/search/', function(){
        return redirect()->route('homepage');
    });
    Route::post('/newsletter/', ['as' => 'search.newsletter', 'uses' => 'SearchController@newsletter']);

    /*
    |--------------------------------------------------------------------------
    | NEWS ROUTES
    |--------------------------------------------------------------------------
    */
    Route::bind('newsslug', function($value)
    {
        return News::where('slug', '=', $value)->first();
    });

    Route::get('/news/', ['as' => 'news.index', 'uses' => 'NewsController@index']);
    Route::get('/news/{newsslug}/', ['as' => 'news.show', 'uses' => 'NewsController@show']);
    Route::get('/news/category/{id}/', ['as' => 'news.category', 'uses' => 'NewsController@category']);


    Route::get('/galleries/', ['as' => 'galleries.list', 'uses' => 'NewsController@listGalleries']);
    Route::get('/galleries/{id}/', ['as' => 'galleries.view', 'uses' => 'NewsController@viewGallery']);

    /*
    |--------------------------------------------------------------------------
    | PAGES ROUTES
    |--------------------------------------------------------------------------
    */
    Route::bind('pageslug', function($value)
    {
        return Page::where('slug', '=', $value)->first();
    });

    Route::get('/page/{pageslug}/', ['as' => 'pages.show', 'uses' => 'PageController@show']);
    Route::post('/page/contact/', ['as' => 'pages.contact', 'uses' => 'PageController@contact']);

    /*
    |--------------------------------------------------------------------------
    | POSTS ROUTES
    |--------------------------------------------------------------------------
    */
    Route::bind('posttypeslug', function($value)
    {
        return PostType::where('slug', '=', $value)->first();
    });

    Route::bind('postslug', function($value)
    {
        return Post::where('slug', '=', $value)->first();
    });

    Route::bind('categorySlug', function($value)
    {
        //get the post type from the url param
    	/*$routeParamters = Route::current()->parameters();
    	$postTypeId = $routeParamters['posttypeid'];
    	$this->postType = $this->postTypeRepos->find($postTypeId);*/
    	//TO DO: check parent_id (in case category slug exists under different parent)

        return Category::where('slug', '=', $value)->first();
    });

    Route::get('/posts/{posttypeslug}/', ['as' => 'posts.list', 'uses' => 'PostController@index']);
    Route::get('/posts/{posttypeslug}/category/{categorySlug}', ['as' => 'posts.category.list', 'uses' => 'PostController@category']);
    Route::get('/posts/{posttypeslug}/{postslug}', ['as' => 'posts.show', 'uses' => 'PostController@show']);



    /*
    |--------------------------------------------------------------------------
    | Admin Subscriber Routs
    |--------------------------------------------------------------------------
    */
    Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function()
    {
       Route::get('/subscribers', ['as' => 'admin.subscribers.list', 'uses' => 'SubscriberController@index']);
       Route::post('/subscribers/{id}/delete', ['as' => 'admin.subscribers.delete', 'uses' => 'SubscriberController@destroy']);
       Route::get('/subscribers/{id}/show', ['as' => 'admin.subscribers.show', 'uses' => 'SubscriberController@show']);
       Route::get('/subscribers/export', ['as' => 'admin.subscribers.export', 'uses' => 'SubscriberController@export']);


       Route::get('/galleries', ['as' => 'admin.galleries.list', 'uses' => 'GalleryController@index']);
       Route::get('/galleries/create', ['as' => 'admin.galleries.create', 'uses' => 'GalleryController@create']);
       Route::get('/galleries/{galleries}/edit', ['as' => 'admin.galleries.edit', 'uses' => 'GalleryController@edit']);
       Route::post('/galleries/store', ['as' => 'admin.galleries.store', 'uses' => 'GalleryController@store']);
       Route::post('/galleries/{galleries}/update', ['as' => 'admin.galleries.update', 'uses' => 'GalleryController@update']);
       Route::post('/galleries/{galleries}/delete', ['as' => 'admin.galleries.delete', 'uses' => 'GalleryController@destroy']);

       Route::post('/upload-gallery-photo', [ 'as' => 'galleries.upload', 'uses' => 'GalleryController@upload']);


    });


//});




Route::get('/rsvp/', ['as' => 'pages.rsvp', 'uses' => 'PageController@rsvp']);
Route::post('/page/forum-store/', ['as' => 'pages.forum', 'uses' => 'PageController@forum']);




Route::get('/', [ 'uses' => 'WelcomeController@index', 'as' => 'homepage']);
Route::get('home', 'HomeController@index');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


//upload route:
Route::post('/upload', [
    'as' => 'media.upload',
    'uses' => 'MediaController@upload',
    'middleware' => 'auth',
]);


