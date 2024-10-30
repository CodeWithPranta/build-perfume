<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'photos',
        'description',
        'question_answers',
        'products_for',
    ];

    // Cast `photos` and `question_answers` to arrays (since they are stored as JSON)
    protected $casts = [
        'photos' => 'array',
        'question_answers' => 'array',
    ];
}
