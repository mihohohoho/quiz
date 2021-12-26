@extends('layouts.app')　　　　　　　　　　　　　　　　　　

@section('content')
<!DOCTYPE HTML>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>クイズ詳細</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="/css/app.css">
    </head>
    <body>
        <div class="p-md-4">
            <div class="card">
                
                <div class="card-header p-md-4">
                    <small>作った人：{{ $quiz->user->name }}</small><br>
                    
                    <?php if ($quiz->category_id==1) : ?>
                    <small>ジャンル:K-POP</small>
                    <?php elseif ($quiz->category_id==2) : ?>
                    <small>ジャンル:韓国ドラマ</small>
                    <?php elseif ($quiz->category_id==3) : ?>
                    <small>ジャンル:その他</small>
                    <?php endif; ?>
                
                    <div class="level">
                        <?php if ($quiz->level_id==1) : ?>
                        <small>レベル:かんたん</small>
                        <?php elseif ($quiz->level_id==2) : ?>
                        <small>レベル:ふつう</small>
                        <?php elseif ($quiz->level_id==3) : ?>
                        <small>レベル:むずかしい</small>
                        <?php endif; ?>    
                    </div>
                </div>
            
                <div class="title card-body p-md-4 text-center">
                    <h5>Q: {{ $quiz->title }}</h5>
                </div>
            
            
                <div class="p-md-4 text-center ">
                    @if($quiz->image)
                        <div class="">
                            <img src="{{ $quiz->image }}">
                        </div>
                    @endif
                </div>
            
            <!-- 選択肢 -->
                <div class="p-md-4 text-center">
                    <form method="post" action="/quizzes/{{ $quiz->id }}/answer">
                            @csrf
                            <?php
                            $choices = array();
                            $choices = array($quiz->choice1,$quiz->choice2,$quiz->choice3);
                            shuffle($choices);
                            ?>
                            <input type="radio" name="answer" value="<?php echo $choices[0]; ?>" /> <?php echo $choices[0]; ?>
                            <input type="radio" name="answer" value="<?php echo $choices[1]; ?>" /> <?php echo $choices[1]; ?>
                            <input type="radio" name="answer" value="<?php echo $choices[2]; ?>" /> <?php echo $choices[2]; ?>
                            <input type="submit" class="btn btn-info" value="回答する">
                            
                            <!--エラーが出ない…-->
                            @if(isset($error))
                            <p style="color:red;">選択してください</p>
                            @endif
                    </form>
            
                </div>
            </div>
        </div>
        <div class=p-md-4>
            <a href="/"><button class='btn btn-success'>トップ画面へ</button></a>
        </div>
    </body>
</html>
@endsection