

@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')

<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>クイズ作成</title>
    </head>
    <body>
        <div class="p-md-3">
            <div class="card">
                    <div class="card-header">
                        <h5>クイズ制作画面</h5>
                    </div>
                <div class="p-md-3">
                    <form action="/quizzes/{{ $quiz->id }}" method="POST" enctype='multipart/form-data' class="form-inline">
                        @csrf
                        @method('PUT')
                        <div class="title p-md-3">
                            <p class="font-weight-bold">問題文</p>
                            <textarea class="form-control" name="quiz[title]" rows="4" cols="40" placeholder="問題を入力してください" >{{ $quiz->title }}</textarea>
                            <p class="font-weight-bold" class="title__error" style="color:red">{{ $errors->first('quiz.title') }}</p>
                        </div>
                        <div class="choice p-md-3">
                            <p class="font-weight-bold">選択肢</p>
                            選択肢1：<input class="form-control" type="text" name="quiz[choice1]" id="choice1" placeholder="選択肢1" value="{{ $quiz->choice1 }}"/>
                            <p class="font-weight-bold" class="title__error" style="color:red">{{ $errors->first('quiz.choice1') }}</p>
                            選択肢2：<input class="form-control" type="text" name="quiz[choice2]" id="choice2" placeholder="選択肢2" value="{{ $quiz->choice2 }}"/>
                            <p class="font-weight-bold" class="title__error" style="color:red">{{ $errors->first('quiz.choice2') }}</p>
                            選択肢3：<input class="form-control" type="text" name="quiz[choice3]" id="choice3" placeholder="選択肢3" value="{{ $quiz->choice3 }}"/>
                            <p class="font-weight-bold" class="title__error" style="color:red">{{ $errors->first('quiz.choice3') }}</p>
                            <p class="font-weight-bold" style="color:red">＊正解は必ず選択肢1に入力してください</p>
                        </div>
                        
                        <div class="explanation p-md-3">
                            <p class="font-weight-bold">解説</p>
                            <textarea class="form-control" name="quiz[explanation]" rows="4" cols="40" placeholder="解説を入力してください">{{ $quiz->explanation }}</textarea>
                            <p class="font-weight-bold" class="title__error" style="color:red">{{ $errors->first('quiz.explanation') }}</p>
                        </div>
                        <div class="category p-md-3">
                            <p class="font-weight-bold">ジャンル選択</p>
                                <select class="form-select" name="quiz[category_id]">
                                    <option value="" selected="selected">＊選択してください</option>
                                    <option value="1">K-POP</option>
                                    <option value="2">韓国ドラマ</option>
                                    <option value="3">その他</option>
                                </select>
                            <p class="font-weight-bold" class="title__error" style="color:red">{{ $errors->first('quiz.category_id') }}</p>
                        </div>
                        <div class="level p-md-3">
                            <p class="font-weight-bold">レベル選択</p>
                            <select class="form-select" name="quiz[level_id]">
                                    <option value="" selected="selected">＊選択してください</option>
                                    <option value="1">かんたん</option>
                                    <option value="2">ふつう</option>
                                    <option value="3">むずかしい</option>
                                </select>
                            <p class="font-weight-bold" class="title__error" style="color:red">{{ $errors->first('quiz.level_id') }}</p>
                        </div>
                        <div class="p-md-3">
                            <p class="font-weight-bold">画像</p>
                            <p class="font-weight-bold" style="color:red">＊必要な場合のみ画像をアップロードしてください</p>
                            @if($quiz->image)
                            <img src="{{ $quiz->image }}">
                            @endif
                            <input type="file" name="quiz[image]">
                            <p class="font-weight-bold" class="comment__error" style="color:red">{{ $errors->first('quiz.image') }}</p>
                        </div>
                        
                        <!-- タグフォーム -->
                        <div class="tag_create p-md-3">
                            <p class="font-weight-bold">タグ</p>
                            <textarea class="form-control" name="tags" class="tags">
                                @foreach ($quiz->tags as $tag){{ $tag->name }}@endforeach
                                </textarea>
                            <p class="font-weight-bold" class="comment__error" style="color:red">{{ $errors->first('tags') }}</p>
                        </div>
                    <div>
                        <input class='btn btn-info btn-lg' type="submit" value="クイズを作成"/>
                    </div>
                    </form>
                    <div class=p-md-3>
                    <a href="/"><button class='btn btn-success'>トップ画面へ</button></a>
                    </div>
            </div>
        </div>
    </body>
</html>
@endsection