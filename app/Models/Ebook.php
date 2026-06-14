<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    protected $fillable = [
        'title',
        'author',
        'category',
        'description',
        'cover_image',
        'pdf_file'
    ];
}
