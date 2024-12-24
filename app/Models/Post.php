<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status']; // Tambahkan 'status'

    // Mutator untuk trimming white spaces
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = preg_replace('/\s+/', ' ', trim($value));
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = preg_replace('/\s+/', ' ', trim($value));
    }
}