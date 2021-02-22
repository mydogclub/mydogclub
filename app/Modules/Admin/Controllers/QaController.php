<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Image;

use App\Qa_category;

use App\Question;

use App\Answer;

use Config;

class QaController extends Controller
{
public function categoryIndex(){
    $category = Qa_category::select('*')->get();
    return view('Admin::qa', compact('category'));
}
public function categoryUpdate(Request $request){
    if(empty($request->name)){return redirect()->back();}    
    if($request->id==0){
        $category = new Qa_category;
        $category->name = $request->name;
        $category->save();
    }else{
        $category = Qa_category::find($request->id);
        $category->name = $request->name;
        $category->save();
    }
    return redirect('/admin/qa');
}
public function categoryDelete($id){
        Qa_category::destroy($id);        
        return redirect('/admin/qa');
}
public function questionIndex(){
    $question = Question::orderBy('id', 'DESC')->with('answers')->paginate(20);
    return view('Admin::question', compact('question'));
}
public function answerIndex(Request $request){
    $cat = is_null($request->category)?0:$request->category;
    $query = Answer::select('*');
    $cat_name = 'Все ответы';
    if($cat){
        $query->where('question_id', $cat);
        $c = Question::where('id', $cat)->first();
        $cat_name = 'на вопрос <b>'.$c['title'].'</b>';
    }
    $answer = $query->orderBy('id', 'DESC')->paginate(20);
    return view('Admin::answer', compact('answer', 'cat_name'));
}
public function answerDel($id){
    $answer = Answer::where('id', $id)->get();
    $answer[0]->question->decrement('answers');
    $answer[0]->destroy($id);
    $newName = 'image'.DIRECTORY_SEPARATOR.'qa'.DIRECTORY_SEPARATOR.'answers'.DIRECTORY_SEPARATOR."my-dog-club-answer-".$id;
    $m = public_path($newName.'.jpg');
    $b = public_path($newName.'.b.jpg');
    if(is_file($m)){ unlink($m);
    }
    if(is_file($b)){ unlink($b);
    }        
}
public function answerDelete($id){
    $this->answerDel($id);
    return redirect('/admin/answer');
}
public function  questionDelete($id){
    $question = Question::where('id', $id)->get();
    $answers = $question[0]->answers()->get();
    foreach ($answers as $item){
    $this->answerDel($item->id);
    }
    $question[0]->destroy($id);
    $newName = 'image'.DIRECTORY_SEPARATOR.'qa'.DIRECTORY_SEPARATOR.'questions'.DIRECTORY_SEPARATOR."my-dog-club-question-".$id;
    $m = public_path($newName.'.jpg');
    $b = public_path($newName.'.b.jpg');
    if(is_file($m)){ unlink($m);
    }
    if(is_file($b)){ unlink($b);
    }    
    return redirect('/admin/question');
}
}