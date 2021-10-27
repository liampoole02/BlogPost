<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{

    use SoftDeletes;
    use HasFactory;

    protected $fillable=['user_id', 'content'];

    public function blogPost()
    {
        return $this->belongsTo('App\Models\BlogPost');
    }

    public function user(){
        return $this->belongsTo('App\Models\BlogPost');
    }

    // public function comments(){
    //     return $this->belongsTo('App\Models\User');
    // }

    public function scopeLatest(Builder $query){
        return $query->orderBy(static::CREATED_AT, 'desc');
    }

    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScope);
        static::deleting(function (BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });

        static::creating(function (Comment $comment) {
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->blog_post_id}");
        });

        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
