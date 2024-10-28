<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'photos',
        'description',
        'question_answers',
    ];

    // Define which attributes should be translatable
    public $translatable = ['name', 'description', 'question_answers'];

    // Cast `photos` and `question_answers` to arrays (since they are stored as JSON)
    protected $casts = [
        'photos' => 'array',
        'question_answers' => 'array',
    ];

    public function getQuestionAnswersAttribute($value)
    {
        $translatedValues = $this->getTranslations('question_answers');
        return $translatedValues[app()->getLocale()] ?? [];
    }
}
