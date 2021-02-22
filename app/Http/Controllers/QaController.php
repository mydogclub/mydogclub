<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Image;

use App\Qa_category;

use App\Question;

use App\Answer;

use App\Censoret;

use App\User;

use Config;

class QaController extends Controller
{
public function index(Request $request){
    $cat = is_null($request->category)?0:$request->category;
    $page = is_null($request->page)?'all':$request->page;
    $category = Qa_category::select('*')->get();
    $query = Question::select('*');
    if($cat){
        $query->where('qa_category_id', $cat);
    }
    switch ($page){
        case 'all':$query->orderBy('id', 'desc'); break;
        case 'with_answers':$query->where('answers', '<>',0)->orderBy('id', 'desc'); break;
        case 'no_answers':$query->where('answers', 0)->orderBy('id', 'desc'); break;
        case 'popular':$query->orderBy('views', 'desc'); break;
    }
    $questions = $query->paginate(Config::get('settings.questions_page_size'));    
    return view('qa.questions', compact('category', 'questions', 'cat', 'page'));
}
public function addQuestion(Request $request){
    $categories = Qa_category::select('id')->get();
    $c = Array();
    foreach ($categories as $key){
        $c[] = $key->id;
    }
    $validator = \Validator::make($request->all(), [
        'title' => 'string|required|max:250|min:4',
        'content' => 'string|required|max:2000|min:4',        
        'qa_category_id' => 'required|in:' . implode(',', $c),
        'image' => 'image|mimes:jpeg,png,jpg,gif',
                                  ]);
        if($validator->fails()) {
            return redirect()->back()->with(['qa_error'=>'Ошибка при написании вопроса']);           
        }
        $question = new Question;
        $input = $request->all();
        $question->qa_category_id = $input['qa_category_id'];
        $text = strip_tags(trim($input['title']));
        $question->title = Censoret::getFiltered($text);
        $text = strip_tags(trim($input['content']));        
        $question->content = Censoret::getFiltered($text);
        $question->user_id = Auth::id();
        if($question->save()){
            $file = $request->file('image');
            if(!is_null($file)){
            $input = $request->all();           
            $destinationPath = 'uploads';
            $file->move($destinationPath,$file->getClientOriginalName());
            // 1024 x 768; 200 x 150; 60 x 45            
            $oldName = public_path($destinationPath.DIRECTORY_SEPARATOR.$file->getClientOriginalName()); 
            $t = $question->id;
            $newName = 'image'.DIRECTORY_SEPARATOR.'qa'.DIRECTORY_SEPARATOR.'questions'.DIRECTORY_SEPARATOR."my-dog-club-question-".$t;
            $m = public_path($newName.'.jpg');
            $b = public_path($newName.'.b.jpg');
            Image::img_resize($oldName,$m,250,200,'',0x222222);
            Image::img_resize($oldName,$b,1024,768,'',0x222222);
            unlink($oldName);
            }            
        }
        return redirect('/qa');        
}
public function showAnswers($id){                
        $question = Question::where('id', $id)->first();
        if(!$question){           
            return view('qa.qaerror', ['cat'=>0]);
        }
        Question::where('id', $id)->increment('views');
        $answers = Answer::where('question_id', $id)->get();
        $user = User::where('id', $question['user_id'])->get();
        $cat = $question['qa_category_id'];
        return view('qa.answers', compact('answers', 'question', 'user', 'cat'));
        
}
public function addAnswer(Request $request){
    $questions = Question::select('id')->get();
    $c = Array();
    foreach ($questions as $key){
        $c[] = $key->id;
    }    
    $validator = \Validator::make($request->all(), [        
        'content' => 'string|required|max:2000|min:4',        
        'question_id' => 'required|in:' . implode(',', $c),
        'image' => 'image|mimes:jpeg,png,jpg,gif',
                                  ]);
        if($validator->fails()) {
            return redirect()->back()->with(['qa_error'=>'Ошибка при написании ответа']);           
        }
        $answer = new Answer;
        $input = $request->all();
        $answer->question_id = $input['question_id'];       
        $text = strip_tags(trim($input['content']));        
        $answer->body = Censoret::getFiltered($text);
        $answer->user_id = Auth::id();                 
        if($answer->save()){
           Question::where('id', $input['question_id'])->increment('answers');
           $file = $request->file('image');
            if(!is_null($file)){
            $input = $request->all();           
            $destinationPath = 'uploads';
            $file->move($destinationPath,$file->getClientOriginalName());
            // 1024 x 768; 200 x 150; 60 x 45            
            $oldName = public_path($destinationPath.DIRECTORY_SEPARATOR.$file->getClientOriginalName()); 
            $t = $answer->id;
            $newName = 'image'.DIRECTORY_SEPARATOR.'qa'.DIRECTORY_SEPARATOR.'answers'.DIRECTORY_SEPARATOR."my-dog-club-answer-".$t;
            $m = public_path($newName.'.jpg');
            $b = public_path($newName.'.b.jpg');
            Image::img_resize($oldName,$m,250,200,'',0x222222);
            Image::img_resize($oldName,$b,1024,768,'',0x222222);
            unlink($oldName);            
            }   
        }            
        return redirect()->back();
}

}