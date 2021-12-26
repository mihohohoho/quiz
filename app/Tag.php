<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    
    
    protected $table = 'tags';
    
    //保存、編集、上書きできる項目を設定
    protected $fillable = [
    'name',
    ];
    
    
    //quiz_tagテーブルと連携
    public function quizzes() {
        return $this->belongsToMany('App\Quiz');
    }
}
