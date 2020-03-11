<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table= 'images';
    protected $fillable = [
        'user_id','image_path','description',
    ];
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('id','desc');
    }
    public function commentsLimit($limit)
    {
        return $this->hasMany('App\Comment')->orderBy('id','desc')->limit($limit);
    }
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
