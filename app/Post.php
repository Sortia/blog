<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    protected $table='posts';
    protected $fields= [
            'category_id',
            'user_id',
            'text',
            'path_image',
            'count_views',
            'search_text',
        ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comments::class)->with('user')->orderBy('id', 'desc');
    }
}
