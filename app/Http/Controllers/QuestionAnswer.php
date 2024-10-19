<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionAnswer extends Controller
{
    public function index(){
        $questions = Question::all();

        return view('welcome', compact('questions'));
    }
}
