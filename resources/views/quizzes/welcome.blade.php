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
            
            <h1 class="text-center">ようこそ！{{Auth::user()->name}}さん</h1>

            <h3 class="text-center">楽しく知識を身につけましょう！</h3>
            
    <div class="p-sm-4">
        <div class="text-center">
            <a href="/random"><button class='btn btn-danger btn-lg'>ランダムクイズ</button></a>
            <a href="/select"><button class='btn btn-warning btn-lg'>ジャンル、レベルを選ぶ</button></a>
            <a href="/search"><button class='btn btn-success btn-lg'>タグでクイズを探す</button></a>
            <a href="/posts/create"><button class='btn btn-info btn-lg'>クイズを作る</button></a>
            <a href="/user_page"><button class='btn btn-dark btn-lg'>マイページ</button></a>
            
            <!-- ランクについてボタン -->
            <button type="button" class="btn btn-primary text-center btn-lg" data-toggle="modal" data-target="#demoNormalModal">
                正解数とランクを見る
            </button>
            
            <!-- モーダルダイアログ -->
            <div class="modal fade" id="demoNormalModal" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="demoModalTitle">ランクは正解数に応じてアップします！</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-left">
                            0~9個　赤ちゃん<br>
                            10個以上　一般人<br>
                            20個以上　ちょっと詳しい人<br>
                            30個以上　一人前のファン<br>
                            40個以上　専門家<br>
                            50個以上　マスター<br>
                        </div>
                        <div class="modal-body">
                            あなたの現在のランクは
                            <span style="color:red">{{$rank->rank_name}}</span>
                            です
                            <div>
                            あなたの現在の正解数は{{count(Auth::user()->records)}}個です
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            
        </div>
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
        </div>
    </body>
</html>

 @endsection