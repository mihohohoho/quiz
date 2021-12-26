<?php

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
Route::group(['middleware' => 'auth'], function(){

    Route::get('/index', 'QuizController@index');
    Route::get('/quizzes/{quiz}', 'QuizController@show');
    //URLがposts以外だと繋がらない。あとで要修正
    Route::get('/posts/create', 'QuizController@create');
    //store=フォームから送信されたデータのDB登録
    Route::post('/quizzes', 'QuizController@store');
    //編集データの取得
    Route::get('/quizzes/{quiz}/edit', 'QuizController@edit');
    //編集実行
    Route::put('/quizzes/{quiz}', 'QuizController@update');
    //削除
    Route::delete('/quizzes/{quiz}', 'QuizController@delete');
    //コメント機能
    Route::post('/quizzes/{quiz}/comments', 'CommentController@store');
    //クイズ回答画面のコメント機能
    Route::post('/quizzes/{quiz}/comments/answer', 'CommentController@store_answer');
    //いいね機能
    Route::get('/quizzes/{quiz}/like', 'LikeController@like')->name('like');
    Route::get('/quizzes/{quiz}/unlike', 'LikeController@unlike')->name('unlike');
    //クイズ回答機能
    Route::get('/quizzes/{quiz}/play', 'QuizController@play');
     //答え合わせ機能
    Route::post('/quizzes/{quiz}/answer', 'QuizController@answer');
    //タグ検索ページへ飛ぶ
    Route::get('/search', 'SearchController@search');
   //タグ検索機能
    Route::get('/search/tags', 'SearchController@searchtags');
    //タグ投稿一覧機能
    Route::get('/quizzes/tags/{tag}', 'SearchController@tags');
   //ランダムクイズ機能
    Route::get('/random', 'QuizController@random');
   //welcome画面
    Route::get('/', 'QuizController@welcome');
    
   //ユーザーページ
   Route::get('/user_page', 'QuizController@user_page');
   //いいね した問題一覧
   Route::get('/user_page/liked/{user}', 'QuizController@user_liked');
   //ユーザーが作った問題一覧
   Route::get('/user_page/created/{user}', 'QuizController@user_created');
   //ユーザーが作った問題一覧
   Route::get('/user_page/records/{user}', 'QuizController@user_records');
   
   //ジャンル・レベル選択画面
   Route::get('/select', 'QuizController@select');
   //ジャンル・レベルでクイズを選ぶ
   Route::post('/selected', 'SearchController@select_index');
});

    //ログイン機能(今はいらないけど残しとくべき？)
    Auth::routes();
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/user', 'UserController@index');
    
    // Controllerメソッドへのルート定義
    Route::get('/auth/redirect', 'GoogleLoginController@getGoogleAuth');
    Route::get('/login/google/callback', 'GoogleLoginController@authGoogleCallback');
    
    