@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
<!DOCTYPE HTML>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>答え</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div class="p-md-4">
            <div class="card">
                
                <div class="card-header p-md-4">
                        <p>
                        作った人：{{ $quiz->user->name }}
                        </p>
                    
                        <div class="category">
                            @if ($quiz->category_id==1)
                            <p>ジャンル：K-POP</p>
                            @elseif ($quiz->category_id==2)
                            <p>ジャンル：韓国ドラマ</p>
                            @elseif ($quiz->category_id==3)
                            <p>ジャンル：その他</p>
                            @endif
                        </div>
                        
                        <div class="level">
                            @if ($quiz->level_id==1)
                            <p>レベル：かんたん</p>
                            @elseif ($quiz->level_id==2)
                            <p>レベル：ふつう</p>
                            @elseif ($quiz->level_id==3)
                            <p>レベル：むずかしい</p>
                            @endif
                        </div>
                        <p class="">回答人数：{{count($quiz->records)}}人</p>
                        <div class="title">
                            <p>問題：{{ $quiz->title }}</p>
                        </div>
                </div>
                
                <div class="p-md-4">
                    <div class="">    
                        
                        @if(isset($_POST['answer']))
                        @if($quiz->choice1==$_POST['answer'])    
                        <h1 class="text-center my-sm-3" style="color:red">正解！！</h1>
                        @else
                        <h1 class="text-center my-sm-3" style="color:blue">残念…</h1>
                        @endif
                        @endif
                        
                        
                        <div class="answer">
                            <h3 class="text-center my-sm-3">正解は{{ $quiz->choice1 }}でした！</h3>    
                        </div>
                        
                        <div class="text-center">
                            @if($quiz->image)
                            <img  src="{{ $quiz->image }}">
                            @endif
                        </div>
                        
                        
                            <div class="explanation my-sm-3">
                                <h3 class="text-center">{{ $quiz->explanation }}</h3>    
                            </div>
                           
                           <div class="tag_index my-sm-3">
                            <p>タグ一覧：</p>
                            @foreach ($quiz->tags as $tag)
                                        <a href='/quizzes/tags/{{ $tag->id }}'>#{{ $tag->name }}</a>
                            @endforeach
                            </div>
                    </div>
                    </div>
                    
                    <div class="card ">
                        <div class="p-md-4">   
                            <!-- いいね -->
                            <span>
                            <!-- もし$niceがあれば＝ユーザーが「いいね」をしていたら -->
                            @if($quiz->likes->where('id',Auth::id())->count()==1)
                            <!-- 「いいね」取消用ボタンを表示 -->
                            	<a href="{{ route('unlike', $quiz) }}" class="like_button">
                            		❤️️　いいねを取り消す
                            		<!-- 「いいね」の数を表示 -->
                            		<span class="badge">
                            			@if(isset($quiz->likes))
                            			{{ $quiz->likes->count() }}
                            			@endif
                            		</span>
                            	</a>
                            @else
                            <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
                            	<a href="{{ route('like', $quiz) }}" class="unlike_button">
                            		♡　いいねする
                            		<!-- 「いいね」の数を表示 -->
                            		<span class="badge">
                            			@if(isset($quiz->likes))
                            			{{ $quiz->likes->count() }}
                            			@endif
                            		</span>
                            	</a>
                            @endif
                            </span>
                             
                            <!-- コメントフォーム -->
                            <form action="/quizzes/{{ $quiz->id }}/comments/answer" method="POST" >
                                @csrf
                                <div class="comment_create">
                                    <textarea name="comment[body] " class="comment_body form-control" placeholder="コメントを入力してください">{{ old('comment.body') }}</textarea>
                                    <p class="comment__error" style="color:red">{{ $errors->first('comment.body') }}</p>
                                <input class='btn btn-info' type="submit" value="コメント投稿する"/>
                                
                                </div>
                            </form>
                        
                        <!--コメント一覧-->
                                <p class="font-weight-bold">コメント一覧</p>
                                @foreach ($quiz->comments as $comment)
                                        <div class="p-md-1">
                                            <div class="comment_index card p-md-4">
                                                    <p class="card-name ">名前：{{ $comment->user->name }}</p>
                                                    <p class="card-body ">{{ $comment->body }}</p>
                                            </div>
                                        </div>
                                @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                            <a href="/"><button class='btn btn-success'>トップ画面へ</button></a>
                            <a href="/user_page"><button class='btn btn-dark '>マイページ</button></a>
                            <a href="/random"><button class='btn btn-danger'>次の問題へ</button></a>
                </div>
            </div>
        </body>
</html>
@endsection