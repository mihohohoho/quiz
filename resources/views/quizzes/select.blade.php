@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>welcome</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    
    <body>
    <div class="p-md-4">
        <div class="pb-sm-8">
        <h1 class="text-center pb-sm-8">ジャンル・レベルを選んでください</h1>
        
        <div class="text-center pb-sm-8">
            <form action="/selected" method="POST">
                @csrf
                <select class="form-select form-select-lg mb-3 py-sm-2" name="category" aria-label=".form-select-lg example">
                    <option selected>ジャンルを選択してください</option>
                    <option value="1">K-POP</option>
                    <option value="2">韓国ドラマ</option>
                    <option value="3">その他</option>
                </select>
                <select class="form-select form-select-lg mb-3 py-sm-2" name="level" aria-label=".form-select-lg example">
                    <option selected>レベルを選択してください</option>
                    <option value="1">かんたん</option>
                    <option value="2">ふつう</option>
                    <option value="3">むずかしい</option>
                </select>
                <input class='btn btn-info btn-lg' type="submit" value="絞り込む"/>
            </form>
        </div>
        
            @if(isset($quizzes))
                <div class="row card-deck">
                    @foreach ($quizzes as $quiz)
                    <div class="col-lg-4 d-flex my-sm-2">
                        <div class="card" >
                            <div class="card-header">{{ $quiz->user->name }}</div>
                            <div class="card-body">
                                <p class="card-name">Q：{{ $quiz->title }}</p>
                                <p class="card-name">回答人数：{{count($quiz->records)}}人</p>
                                @if($quiz->points->where('id',Auth::id())->count()==1)
                                <p class="card-name" style="color:red;">あなたはこのクイズに正解しています</p>
                                @endif
                                <a href="/quizzes/{{ $quiz->id }}/play"><button class='btn btn-danger'>クイズを解く</button></a>
                                <a href="/quizzes/{{ $quiz->id }}"><button class='btn btn-success'>詳細を見る</button></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        
        <div class="paginate my-sm-2">
        @if(isset($quizzes))
        {{ $quizzes->links() }}
        @endif
        </div>
        
        <div class="card">
        <div　class='p-md-4'>
        <p class="font-weight-bold">今話題の韓国ニュース</p>
        @foreach($articles as $article)
            <div>
                <a href= {{$article['url']}}>
                ・{{ $article['title'] }}
                </a>
            </div>
        @endforeach
        </div>
            <div class="p-md-3">
                <a href="/"><button class='btn btn-success'>トップ画面へ</button></a>
            </div>
        </div>
    </body>
</html>

 @endsection