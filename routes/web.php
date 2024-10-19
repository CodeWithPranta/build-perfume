<?php

use App\Mail\ProductSuggestions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionAnswer;
use App\Http\Controllers\QuestionAnswerController;

Route::get('/', [QuestionAnswerController::class, 'index']);
Route::post('/submit-answers', [QuestionAnswerController::class, 'store'])->name('answers.store');

// Route::get('/test-email', function () {
//     try {
//         $products = []; // Pass an empty array or some test data
//         Mail::to('recipient@example.com')->send(new ProductSuggestions($products));
//         return 'Email sent successfully!';
//     } catch (\Exception $e) {
//         return 'Failed to send email: ' . $e->getMessage();
//     }
// });
