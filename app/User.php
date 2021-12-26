<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    //クイズとの連携（一人のユーザーはクイズを多数投稿できるので1対多）
    public function quizzes()   
    {
        return $this->hasMany('App\Quiz');  
    }
    
    //コメントとの連携（一人のユーザーはコメントを多数投稿できるので1対多）
    public function comments()   
    {
        return $this->hasMany('App\Comment');  
    }
    
    //いいねとの連携（一人のユーザーはいいねを多数できるので多対多）
    public function likes() {
        return $this->belongsToMany('App\Quiz','likes');
    }
    
    //クイズとの連携（閲覧履歴、多対多）
    public function records() {
        return $this->belongsToMany('App\Quiz','records');
    }
    
    //pointsとの連携（閲覧履歴、多対多）
    public function points() {
        return $this->belongsToMany('App\Quiz','points');
    }
    
    //自分の投稿一覧を見ることができる
    public function getOwnPaginateByLimit(int $limit_count = 5)
    {   
        //idからクイズ一覧を引っ張り出し、並べてページネイトする
        return $this::with('quizzes')->find(Auth::id())->quizzes()->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
    
}
