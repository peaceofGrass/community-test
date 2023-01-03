<?php

namespace App;

use App\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use Searchable;

    // 定义索引里面的type
    public function searchableAs() {
        return 'post';
    }

    // 那些字段需要搜索
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content
        ];
    }

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function comments() {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

    public function likes() {
        return $this->hasMany('App\Like');
    }

    public function like($user_id) {
        return $this->hasOne('App\Like')->where('user_id', $user_id);
    }

    public function search($query) {
        return $this->where('title', 'like', '%' . $query . '%')
        ->orWhere('content', 'like', '%' . $query . '%')
        ->paginate(10);
    }

    public function scopeBelongsToUser($query, $user_id) {
        return $query->where('user_id', $user_id);
    }

    public function postTopics() {
        return $this->hasMany('\App\PostTopic', 'post_id', 'id');
    }

//    public function scopeNotBelongsToTopic(Builder $query, $topic_id) {
    public function scopeNotBelongsToTopic($query, $topic_id) {
        return $query->doesntHave('postTopics', 'and', function($q) use($topic_id) {
            $q->where('topic_id', $topic_id);
        });
    }

    // 全局scope的方式
    protected static function boot() {
        parent::boot();
        // 아래 두가지 다 됨.
//        static::addGlobalScope('available', function(Builder $builder) {
        static::addGlobalScope('available', function($builder) {
            $builder->whereIn('status', [0,1]);
        });
    }
}
