<?php

use App\Http\Controllers\LanguageController;
use App\Mail\ProductSuggestions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionAnswer;
use App\Http\Controllers\QuestionAnswerController;

Route::get('/', [QuestionAnswerController::class, 'index']);
Route::get('/suggested-products', [QuestionAnswerController::class, 'suggestedProducts'])->name('suggested.products');

Route::post('/submit-answers', [QuestionAnswerController::class, 'store'])->name('answers.store');

Route::post('/language-switch', [LanguageController::class, 'languageSwitch'])->name('language.switch');

// Route::get('/test-email', function () {
//     try {
//         $products = []; // Pass an empty array or some test data
//         Mail::to('recipient@example.com')->send(new ProductSuggestions($products));
//         return 'Email sent successfully!';
//     } catch (\Exception $e) {
//         return 'Failed to send email: ' . $e->getMessage();
//     }
// });

Route::get('/get-email', function() {
    return response()->json(['user_email' => session('user_email')]);
});

