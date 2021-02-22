<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use App\Comment;

use App\User;

use Config;

class CommentController extends Controller

{

public function index()

{	
	$comments = Comment::select('*')->orderBy('id', 'desc')->paginate(Config::get('settings.comment_page_size_admin'));


    return view('Admin::comment', compact('comments'));

}

public function destroy($id)
{	
	$comment = Comment::find($id);
	$comment->delete();
	return redirect('/admin/comment');
}

}