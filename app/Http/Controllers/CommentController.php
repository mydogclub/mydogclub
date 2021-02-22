<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;

use App\User;

use App\Censoret;

use Config;


class CommentController extends Controller
{
    //
    public function showComments(Request $request){
    	$type = $request->input('type');
    	$source_id = $request->input('source_id');
        $displayed_comments = $request->input('displayed_comments');
        $commentCount = $request->input('commentCount');
        $p = Config::get('settings.comment_page_size');
        if ($commentCount>($displayed_comments+$p) ) {
            $o = ($displayed_comments);
        }
        else{
            $o = ($displayed_comments);
            $p = ($commentCount - $displayed_comments);
        }
    	$comments = Comment::select('*')        
    	->where('type', $type)
    	->where('source_id', $source_id)
    	->orderBy('id', 'desc')
    	->offset($o)
        ->limit($p)
        ->get(); 
        $displayed_comments += $p;    	
        $view_comment = view('commentContent', compact('comments'))->render();
        return \Response::json(['success' => TRUE,'comment'=>$view_comment,'displayed_comments'=>$displayed_comments]);
    	
    }

    public function addComment(Request $request){

    	$validator = \Validator::make($request->all(), [
        'text' => 'string|required|max:500',        
                                  ]);
        if($validator->fails()) {
            return \Response::json(['error'=>'Ошибка при написании комментария']);
        }
    	$input = $request->all();
    	$comment = new Comment;
    	$comment->source_id = $input['source_id'];
    	$comment->user_id = $input['user_id'];
    	$comment->type = $input['type'];
        $text = strip_tags(trim($input['text']));
    	$comment->text = Censoret::getFiltered($text);
    	$comment->save();        

    	$comments = Comment::select('*')        
        ->where('type', $input['type'])
        ->where('source_id', $input['source_id'])
        ->orderBy('id', 'desc')
        ->offset(0)
        ->limit(Config::get('settings.comment_page_size'))
        ->get();

        $commentCount = Comment::select('id')
        ->where('type', $input['type'])
        ->where('source_id', $input['source_id'])        
        ->count(); 
        
        $view_comment = view('commentContent', compact('comments'))->render();   	

    	return \Response::json(['success' => TRUE,'comment'=>$view_comment, 'commentCount'=>$commentCount]);
    }

    public function destroy($id)
    {        
        Comment::FindOrFail($id)->delete();
        return redirect()->back();
    }
    
}
