<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'published_year',
        'genre',
        'admin_id',
    ];

    public function admin()
{
    return $this->belongsTo(User::class, 'admin_id');
}

public function reviews()
{
    return $this->hasMany(Review::class);
}


}
