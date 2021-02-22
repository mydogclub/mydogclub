<?php
Route::get('/clear-cache', function() {
Artisan::call('config:clear');
Artisan::call('cache:clear');
Artisan::call('route:clear');
Artisan::call('view:clear');
return "Cache is cleared";
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');    
});

Auth::routes();
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');
Route::get('/forgot', 'Auth\ForgotPasswordController@index');
Route::post('/forgot', 'Auth\ForgotPasswordController@restore');

Route::get('/home', function () {return view('home');})->name('home');
Route::get('/dogs', 'HomeController@dogsShow')->name('dogs');
Route::get('/contacts', function () {return view('contacts');})->name('contacts');
Route::post('/sendmsg', 'HomeController@sendMessage')->name('sendmsg');
Route::get('/tag/{tag}', 'HomeController@showTag')->name('homeShowTag');
//Route::get('/home', 'HomeController@index');

Route::get('/gallery', 'GalleryController@index')->name('gallery');
Route::get('/gallery/{alias}', 'GalleryController@show')->name('galleryShow');
Route::get('/gallery/user/{user_id}', 'GalleryController@showUser')->name('galleryShowUser');
Route::get('/gallery/title/{title}', 'GalleryController@showTitle')->name('galleryShowTitle');

Route::get('/blog', 'BlogController@index')->name('blog');
Route::get('/blog/{alias}', 'BlogController@show')->name('blogShow');
Route::get('/blog/user/{user_id}', 'BlogController@showUser')->name('blogShowUser');

Route::get('/news', 'NewsController@index')->name('news');
Route::get('/news/{alias}', 'NewsController@show')->name('newsShow');
Route::get('/news/user/{user_id}', 'NewsController@showUser')->name('newsShowUser');

Route::get('/developments', 'DevelopmentsController@index')->name('developments');
Route::get('/developments/{alias}', 'DevelopmentsController@show')->name('developmentsShow');
Route::get('/developments/user/{user_id}', 'DevelopmentsController@showUser')->name('developmentsShowUser');

Route::get('/breeds', 'BreedsController@index')->name('breeds');
Route::post('/breeds', 'BreedsController@listBreeds');
Route::get('/breeds/{alias}', 'BreedsController@show')->name('breedsShow');
Route::get('/breeds/user/{user_id}', 'BreedsController@showUser')->name('breedsShowUser');
Route::get('/breeds/tag/{tag}', 'BreedsController@showTag')->name('breedsShowTag');

Route::get('/diseases', 'DiseasesController@index')->name('diseases');
Route::get('/diseases/letter/{letter}', 'DiseasesController@listDiseases')->name('diseasesLetter');
Route::get('/diseases/{alias}', 'DiseasesController@show')->name('diseasesShow');
Route::get('/diseases/user/{user_id}', 'DiseasesController@showUser')->name('diseasesShowUser');

Route::get('/keeping', 'KeepingController@index')->name('keeping');
Route::get('/keeping/{alias}', 'KeepingController@show')->name('keepingShow');
Route::get('/keeping/user/{user_id}', 'KeepingController@showUser')->name('keepingShowUser');
Route::get('/keeping/tag/{tag}', 'KeepingController@showTag')->name('keepingShowTag');

Route::post('/comments', 'CommentController@showComments');
Route::post('/addComment', 'CommentController@addComment');
Route::delete('/comments/{id}', 'CommentController@destroy');

Route::post('/poll', 'PollController@poll');
Route::get('/poll/{id}', 'PollController@show');

Route::get('/profile/{id}', 'ProfileController@show');
Route::post('/profile', 'ProfileController@sendMessage');

Route::post('/gallery/upload', 'GalleryController@upload');

Route::post('/ajax', 'AjaxController@ajax');

Route::get('/qa', 'QaController@index')->name('qa');
Route::post('/qa/addQuestion', "QaController@addQuestion");

Route::get('/qa/answers/{id}', 'QaController@showAnswers');
Route::post('/qa/addAnswer', "QaController@addAnswer");

//Route::get('/keeping', function(){
    //return view('InWork');
//});