<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'content',
        'category_id',
        'tag_id',
        'user_id',
    ];

    // public function categorie()
    // {
    //     return $this->belongsTo(Category::class);
    // }
    // public function tags(){
    //     return $this->belongsToMany(Tag::class);
    // }
    // public function user(){
    //     return $this->hasOne(User::class);
    // }

    // public function comments(){
    //     return $this->hasMany(Comment::class);
    // }
}
