<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
     // Define the fillable fields for mass assignment
     protected $fillable = [
        'email',  // Email field to store user email
        'gender',
        'answers' // JSON field to store the user's answers
    ];

    // Define the casts for model attributes
    protected $casts = [
        'answers' => 'array', // Cast answers to array
    ];
}
