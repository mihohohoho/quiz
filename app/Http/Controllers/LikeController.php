<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    //
    public function like(Quiz $quiz, Request $request)
    {   
        $quiz->likes()->detach(Auth::id());
        $quiz->likes()->attach(Auth::id());
        return view('quizzes/answer',compact('quiz'));
    }
    
    public function unlike(Quiz $quiz, Request $request)
    {   $quiz->likes()->detach(Auth::id());
        return view('quizzes/answer',compact('quiz'));
    }
    
}
