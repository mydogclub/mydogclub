<?php 
Route::group( [ 'namespace' => 'App\Modules\Admin\Controllers',
                'as' => 'admin.',
                'middleware' => ['web', 'auth', 'moderator'],
], function(){
			Route::group(
				['middleware' => ['admin']],
				function(){
			Route::get('/admin', function(){     
			        return redirect("/admin/user");		
			                                });      
			Route::get('/admin/user', 'IndexController@index');
			Route::post('/admin/user/role', 'IndexController@setRole');
			Route::post('/admin/user/ban', 'IndexController@setBan');
			Route::post('/admin/user/verified', 'IndexController@setVerified');
			Route::post('/admin/user/deleteUser', 'IndexController@deleteUser');                                                       
                                                          Route::get('/admin/user/edit/{id}', 'IndexController@edit');
                                                          Route::post('/admin/user/update', 'IndexController@update');
                                                          Route::post('/admin/user/avatarUpdate', 'IndexController@avatarUpdate');

			Route::get('/admin/gallery', 'GalleryController@index');
			Route::get('/admin/gallery/destroy/{id}', 'GalleryController@destroy');
			Route::post('/admin/gallery/update', 'GalleryController@update');
			Route::post('/admin/gallery/upload', 'GalleryController@upload');

			Route::get('/admin/breeds', 'BreedsController@index');
			Route::get('/admin/breeds/destroy/{id}', 'BreedsController@destroy');
			Route::get('/admin/breeds/show/{id}', 'BreedsController@show');
			Route::get('/admin/breeds/create', 'BreedsController@create');
			Route::post('/admin/breeds/update', 'BreedsController@update');
			Route::post('/admin/breeds/upload', 'BreedsController@upload');
			Route::post('/admin/breeds/create', 'BreedsController@create');
                        Route::post('/admin/breeds/delImage', 'BreedsController@deleteImage');
                        
                        Route::get('/admin/diseases', 'DiseasesController@index');
			Route::get('/admin/diseases/destroy/{id}', 'DiseasesController@destroy');
			Route::get('/admin/diseases/show/{id}', 'DiseasesController@show');
			Route::get('/admin/diseases/create', 'DiseasesController@create');
			Route::post('/admin/diseases/update', 'DiseasesController@update');
			Route::post('/admin/diseases/upload', 'DiseasesController@upload');
			Route::post('/admin/diseases/create', 'DiseasesController@create');
                        Route::post('/admin/diseases/delImage', 'DiseasesController@deleteImage');
                        
                        Route::get('/admin/keeping', 'KeepingController@index');
			Route::get('/admin/keeping/destroy/{id}', 'KeepingController@destroy');
			Route::get('/admin/keeping/show/{id}', 'KeepingController@show');
			Route::get('/admin/keeping/create', 'KeepingController@create');
			Route::post('/admin/keeping/update', 'KeepingController@update');
			Route::post('/admin/keeping/upload', 'KeepingController@upload');
			Route::post('/admin/keeping/create', 'KeepingController@create');
                        Route::post('/admin/keeping/delImage', 'KeepingController@deleteImage');

			Route::get('/admin/comment', 'CommentController@index');
			Route::get('/admin/comment/destroy/{id}', 'CommentController@destroy');
			});
Route::get('/admin/blog', 'BlogController@index');
Route::get('/admin/blog/destroy/{id}', 'BlogController@destroy');
Route::get('/admin/blog/show/{id}', 'BlogController@show');
Route::get('/admin/blog/create', 'BlogController@create');
Route::post('/admin/blog/update', 'BlogController@update');
Route::post('/admin/blog/upload', 'BlogController@upload');
Route::post('/admin/blog/create', 'BlogController@create');
Route::post('/admin/blog/delImage', 'BlogController@deleteImage');


Route::get('/admin/news', 'NewsController@index');
Route::get('/admin/news/destroy/{id}', 'NewsController@destroy');
Route::get('/admin/news/show/{id}', 'NewsController@show');
Route::get('/admin/news/create', 'NewsController@create');
Route::post('/admin/news/update', 'NewsController@update');
Route::post('/admin/news/upload', 'NewsController@upload');
Route::post('/admin/news/create', 'NewsController@create');


Route::get('/admin/developments', 'DevelopmentsController@index');
Route::get('/admin/developments/destroy/{id}', 'DevelopmentsController@destroy');
Route::get('/admin/developments/show/{id}', 'DevelopmentsController@show');
Route::get('/admin/developments/create', 'DevelopmentsController@create');
Route::post('/admin/developments/update', 'DevelopmentsController@update');
Route::post('/admin/developments/upload', 'DevelopmentsController@upload');
Route::post('/admin/developments/create', 'DevelopmentsController@create');

Route::get('/admin/diseases', 'DiseasesController@index');
Route::get('/admin/keeping', 'KeepingController@index');

Route::get('/admin/qa', 'QaController@categoryIndex');
Route::post('/admin/qa/categoryUpdate', 'QaController@categoryUpdate');
Route::get('/admin/qa/categoryDelete/{id}', 'QaController@categoryDelete');
Route::get('/admin/qa/answerDelete/{id}', 'QaController@answerDelete');
Route::get('/admin/question', 'QaController@questionIndex');
Route::get('/admin/answer', 'QaController@answerIndex');
Route::get('/admin/qa/questionDelete/{id}', 'QaController@questionDelete');
    });

