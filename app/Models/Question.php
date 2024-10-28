<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'title',
        'options',
        'questions_for',
        'alb_title',
    ];

    // Cast `options` to an array (since it is stored as JSON)
    protected $casts = [
        'options' => 'array',
    ];

}
