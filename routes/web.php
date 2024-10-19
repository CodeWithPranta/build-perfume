<?php

use App\Http\Controllers\QuestionAnswer;
use Illuminate\Support\Facades\Route;

Route::get('/', [QuestionAnswer::class, 'index']);
