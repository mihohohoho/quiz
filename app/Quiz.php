<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    // update扱いにし、論理削除を可能にする
    use SoftDeletes;
    
    public function getPaginateByLimit(int $limit_count = 6)
    {
        // userの情報を足して、順番に並べて、ページネイトする
        return $this::with('user')->orderBy('updated_at', 'DESC')->paginate($limit_count);
    }
    
    //保存、編集、上書きできる項目を設定
    protected $fillable = [
    'title',
    'choice1',
    'choice2',
    'choice3',
    'explanation',
    'category_id',
    'level_id',
    'user_id',
    ];
    
    //userテーブルと連携
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    
    //テーブルと連携（閲覧履歴、多対多）
    public function records()
    {
        return $this->belongsToMany('App\User','records');
    }
    
    //commentテーブルと連携
    public function comments() 
    {
      return $this->hasMany('App\Comment');
    }
    
    //いいねテーブルと連携
    public function likes() {
        return $this->belongsToMany('App\User','likes');
    }
    
    //pointsテーブルと連携
    public function points() {
        return $this->belongsToMany('App\User','points');
    }
    
    //quiz_tagテーブルと連携
    public function tags() {
        return $this->belongsToMany('App\Tag');
    }
}
