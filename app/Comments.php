<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    use SoftDeletes;

    protected $fields = [
        'id',
        'text',
        'user_id',
        'post_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'id',
        'text',
        'user_id',
        'post_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->select('*');
    }
}
