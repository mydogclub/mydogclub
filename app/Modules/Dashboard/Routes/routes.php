<?php 
Route::group( [ 'namespace' => 'App\Modules\Dashboard\Controllers',
'as' => 'dashboard.',
'middleware' => ['web','auth'],
], function()
{        
Route::get('/dashboard', 'IndexController@index');
Route::post('/dashboard/personalEdit', 'IndexController@edit');
Route::post('/dashboard/avatarUpdate', 'IndexController@avatarUpdate');

Route::get('/dashboard/contacts', 'IndexController@contactsShow');
Route::post('/dashboard/contactsEdit', 'IndexController@contactsEdit');

Route::get('/dashboard/changePassword', 'IndexController@changePasswordShow');
Route::post('/dashboard/changePasswordEdit', 'IndexController@changePasswordEdit');

Route::get('/dashboard/privateMessages', 'IndexController@privateMessagesShow');
Route::get('/dashboard/privateMessagesUser/{id}', 'IndexController@privateMessagesUser');
Route::post('/dashboard/privateMessages', 'IndexController@privateMessagesSend');

});