@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>クイズ</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <div class="p-md-4">
            <!-- タグ付き投稿一覧を表示する -->
            <form action="/search/tags" method="GET">
            <label for="">タグで検索</label>
            <input type="text"  name="keyword">
            <input type="submit" value="検索"  class="btn-primary">
            </form>
            <!-- 投稿を表示する -->
            <div class='quizzes'>
                @if(isset($keyword))
                    <div class="text-center">
                    <h1>#{{$keyword}} の検索結果:{{ $quizzes->count() }}件</h1>
                    @foreach ($quizzes as $quiz)
                        <div class="row card-deck">
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
                                        <a href="/quizzes/{{ $quiz->id }}"><button class='btn btn-info'>詳細を見る</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
                
            <div class="paginate my-sm-2">
                @if(isset($quizzes))
                <?php dd($quizzes); ?>
                {{ $quizzes->links() }}
                @endif
            </div>
                
                
            </div>
            <a href="/"><button class='btn btn-success'>トップ画面へ</button></a>
        </div>
    </body>
</html>

 @endsection
 
 
 
                