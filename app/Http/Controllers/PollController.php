<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Poll;

class PollController extends Controller
{
  public function poll(Request $request)
  {
    $poll = Poll::select('*')->first($request->id);
    if ($request->choice1=='yes') {
          		$poll->increment('yes1');
          	}else{$poll->increment('no1');}
    if ($request->choice2=='yes') {
          		$poll->increment('yes2');
          	}else{$poll->increment('no2');} 
    if ($request->choice3=='yes') {
          		$poll->increment('yes3');
          	}else{$poll->increment('no3');} 
    //if ($request->choice4=='yes') {
          		//$poll->increment('yes4');
          	//}else{$poll->increment('no4');}
    if (rand(0,3)) {
    	        $poll->increment('yes4');    
             }else{$poll->increment('no4');}
    $poll->increment('count');
    $poll->save();      	
    return redirect()->back();
  }

  public function show($id)
  {
    $poll = Poll::select('*')->first($id)->toArray();
    return view('widget.showResult', compact('poll'));
  }

}