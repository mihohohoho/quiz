<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    // 削除実行時、update扱いにし、論理削除を可能にする
    use SoftDeletes;
    
    protected $table = 'comments';
    
    // 割り当て許可
    protected $fillable = [
        'body',
        'user_id',
        'quiz_id',
    ];
    
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    public function quizzes()   
    {
        return $this->belongsTo('App\Quiz');  
    }
    
}
