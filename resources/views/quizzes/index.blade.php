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
    <div class="container-fluid">
    <body>
        
        
        <!-- 投稿を表示する -->
        <div class="quizzes">
            
            <!-- URLがposts以外だと繋がらない。あとで/quizzes/createに要修正 -->
            <div class="text-center">
                <h1>クイズ一覧 　<a href='/posts/create'><button class='btn btn-info'>クイズを作る</button></a></h1>
            </div>
                <div class="row card-deck">
                    @foreach ($quizzes as $quiz)
                    <div class="col-lg-4 d-flex my-sm-2">
                        <div class="card" >
                            <div class="card-header">{{ $quiz->user->name }}</div>
                            <div class="card-body">
                                <p class="card-name">Q：{{ $quiz->title }}</p>
                                <a href="/quizzes/{{ $quiz->id }}/play"><button class='btn btn-danger'>クイズを解く</button></a>
                                <a href="/quizzes/{{ $quiz->id }}"><button class='btn btn-success'>詳細を見る</button></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                </div>
        </div>
        
        <div class="paginate my-sm-2">
        {{ $quizzes->links() }} 
        </div>
        
    </body>
</html>

 @endsection