<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Article;
use App\Gallery;
use App\Comment;
use App\Profile;
use App\Breed;
use App\User;


class AjaxController extends Controller
{
	public function ajax(Request $request){
      $input = $request->all();
      $action = $input['procedure'];      
      $res = self::$action($request);
      return response()->json($res);      
	}

	public static function validBlogTitle($request){
       return self::validTitle($request, 'articles');
	}  

  public static function validDevelopmentTitle($request){
       return self::validTitle($request, 'articles');
  }

  public static function validNewsTitle($request){
       return self::validTitle($request, 'articles');
  }

  public static function validBreedsTitle($request){
       return self::validTitle($request, 'breeds');
  }

  public static function validDiseasesTitle($request){
       return self::validTitle($request, 'diseases');
  }
  public static function validKeepingTitle($request){
       return self::validTitle($request, 'keepings');
  }


  public static function validTitle($request, $table){
       $validator = Validator::make($request->all(), [
        'title' => 'unique:'.$table,        
                                  ]);
       if ($validator->fails()) {
         if ($validator->errors()->has('title')) {
          return ['message'=>'Ошибка: название статьи не уникальное', 'error'=>1];
         }
       }
       $alias = str_slug($request->title, '_');       
         return [
               'message'=>'Название: уникально',
               'error'=>0,
               'alias'=>$alias,
                ];
  }
}