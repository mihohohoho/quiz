<?php

namespace App\Http\Controllers;

use App\Comment; 
use App\Quiz;
use App\Http\Requests\CommentRequest; 

class CommentController extends Controller
{
    //コメント投稿
    public function store(CommentRequest $request, Comment $comment, Quiz $quiz)
    {
        //commentをキーに持つリクエストパラメータを取得
        $input = $request['comment'];
        //user_idのキーにUserインスタンスのidプロパティを持たせ、inputに追加
        $input += ['user_id' => $request->user()->id];
         //quiz_idのキーにQuizインスタンスのidプロパティを持たせ、inputに追加
        $input += ['quiz_id' => $quiz->id];
        //quizテーブルにデータを入力（fill）、追加（save）＊$quiz->create($input)としても同じ挙動
        $comment->fill($input)->save();
        
        //処理が終わったら直ちに以下のURL(ブログ詳細画面に飛ぶ)に再接続
        return redirect('/quizzes/' . $quiz->id);
        
    }
    
    //コメント投稿
    public function store_answer(CommentRequest $request, Comment $comment, Quiz $quiz)
    {
        //commentをキーに持つリクエストパラメータを取得
        $input = $request['comment'];
        //user_idのキーにUserインスタンスのidプロパティを持たせ、inputに追加
        $input += ['user_id' => $request->user()->id];
         //quiz_idのキーにQuizインスタンスのidプロパティを持たせ、inputに追加
        $input += ['quiz_id' => $quiz->id];
        //quizテーブルにデータを入力（fill）、追加（save）＊$quiz->create($input)としても同じ挙動
        $comment->fill($input)->save();
        //処理が終わったら直ちに以下のURL(ブログ詳細画面に飛ぶ)に再接続
        return view('quizzes/answer',compact('quiz'));
        
    }
    
    
}
