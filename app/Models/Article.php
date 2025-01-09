<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'image',
        'author',
        'start_date',
        'end_date',
        'tags',
        'meta_tags',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'author', 'name');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
    public function getMetaTagsAttribute($value)
    {
        return json_decode($value, true);
    }
    public function setMetaTagsAttribute($value)
    {
        $this->attributes['meta_tags'] = json_encode($value);
    }
}
