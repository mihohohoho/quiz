@extends('layouts.app')

@section('content')




    <div class="own_quizzes">
        @foreach($own_quizzes as $quiz)
            <div>
                <h4><a href="/quizzes/{{ $quiz->id }}">{{ $quiz->title }}</a></h4>
                <small>{{ $quiz->user->name }}</small>
                <p>{{ $quiz->answer }}</p>
            </div>
        @endforeach
   
        <div class='paginate'>
            {{ $own_quizzes->links() }}
        </div>
    </div>

@endsection