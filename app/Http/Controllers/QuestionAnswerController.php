<?php

namespace App\Http\Controllers;

use Log;
use App\Models\Product;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\QuestionAnswer;
use App\Mail\ProductSuggestions;
use Illuminate\Support\Facades\Mail;

class QuestionAnswerController extends Controller
{
    public function index(){
        $questions = Question::all();

        return view('front', compact('questions'));
    }

    public function store(Request $request)
{
    // Validate input data
    $validatedData = $request->validate([
        'email' => 'required|email',
        'answers' => 'required|array',
        'gender' => 'required',
    ]);

    // Store email in session
    session(['user_email' => $validatedData['email']]);


    // Store data in the database
    $questionAnswer = QuestionAnswer::create([
        'email' => $validatedData['email'],
        'gender' => $validatedData['gender'],
        'answers' => json_encode($validatedData['answers']),  // Convert answers array to JSON
    ]);

    // Now compare answers and suggest products
    $userAnswers = json_decode($questionAnswer->answers, true);
    //dd($userAnswers); // Step 1: Check the decoded answers from the user

    // Fetch all products
    $products = Product::all();
    //dd($products); // Step 2: Check if products are being fetched properly

    // Check if products are empty
    if ($products->isEmpty()) {
        return redirect()->back()->with('success', 'No products found for suggestions.');
    }

    $suggestedProducts = [];
    $similarityScores = []; // To store similarity scores for products

    foreach ($products as $product) {
        // Decode product's questions
        $productQuestions = is_string($product->question_answers)
                    ? json_decode($product->question_answers, true)
                    : $product->question_answers;
        // dd($productQuestions); // Step 3: Check if the product questions are being decoded properly

        // Check if productQuestions is an array
        if (!is_array($productQuestions) || is_null($productQuestions)) {
            continue; // Skip if questions are not properly formatted
        }

        // Flatten the product questions (assumes only one set of questions)
        $productQuestions = $productQuestions[0]; // Get the first (and assumed only) associative array

        // Initialize matches counter
        $matches = 0;

        // Debugging - check contents
        //dd($productQuestions, $userAnswers);

        // Calculate similarity
        foreach ($productQuestions as $key => $value) {
            // Get the index from the question key
            $index = str_replace('question_', '', $key); // Extract index from the question key

            // Check if userAnswers has the corresponding index
            if (isset($userAnswers[$index]) && trim(strtolower($userAnswers[$index])) === trim(strtolower($value))) {
                $matches++;
            }
        }

        // Output the number of matches
        // dd($matches);

        // Calculate percentage similarity
        $totalQuestions = count($productQuestions);
        $similarityPercentage = ($totalQuestions > 0) ? ($matches / $totalQuestions) * 100 : 0;
        // dd($similarityPercentage); // Step 5: Check similarity percentage for each product

        // Store similarity scores for later use
        $similarityScores[$product->id] = $similarityPercentage;

        // If 100% match, add to suggested products immediately
        if ($similarityPercentage === 100) {
            $suggestedProducts[] = $product;
        }
    }

    // Check if there are any 100% matches
    //dd($suggestedProducts); // Step 6: Check if any suggested products were found

    if (!empty($suggestedProducts)) {
        // Send email with 100% similar products
        Mail::to($validatedData['email'])->send(new ProductSuggestions($suggestedProducts));
        //dd('Email sent with 100% match products'); // Step 7: Confirm email sending step
    } else {
        // No 100% matches, find the most similar products
        if (!empty($similarityScores)) {
            // Get the maximum similarity percentage
            $maxSimilarity = max($similarityScores);
            //dd($maxSimilarity); // Step 8: Check max similarity percentage

            // Find products with the maximum similarity percentage
            $mostSimilarProducts = array_filter($similarityScores, function ($score) use ($maxSimilarity) {
                return $score === $maxSimilarity;
            });

            // Fetch the products that are most similar
            foreach ($mostSimilarProducts as $productId => $score) {
                $product = Product::find($productId);
                if ($product) {
                    $suggestedProducts[] = $product;
                }
            }
           // dd($suggestedProducts); // Step 9: Check suggested products with max similarity

            // Send email with most similar products
            if (!empty($suggestedProducts)) {
                Mail::to($validatedData['email'])->send(new ProductSuggestions($suggestedProducts));
                // dd('Email sent with most similar products'); // Step 10: Confirm email sending step
            }
        }
    }

    return redirect()->route('suggested.products')->with('success', 'Your answers have been submitted and suggestions sent via email!');

}


public function suggestedProducts(Request $request)
{
    // Retrieve the user's email from the session
    $email = $request->session()->get('user_email');

    //dd($email);

    // Get the question answer record for that email
    $questionAnswer = QuestionAnswer::where('email', $email)->first();

    // If no record found, redirect with an error message
    if (!$questionAnswer) {
        return redirect()->back()->with('error', 'No answers found for this user.');
    }

    // Decode the user's answers
    $userAnswers = json_decode($questionAnswer->answers, true);

    // Fetch all products
    $products = Product::all();

    // Initialize an array for suggested products
    $suggestedProducts = [];
    $similarityScores = []; // To store similarity scores for products

    foreach ($products as $product) {
        // Decode product's questions
        $productQuestions = is_string($product->question_answers)
                    ? json_decode($product->question_answers, true)
                    : $product->question_answers;

        // Check if productQuestions is an array
        if (!is_array($productQuestions) || is_null($productQuestions)) {
            continue; // Skip if questions are not properly formatted
        }

        // Flatten the product questions (assumes only one set of questions)
        $productQuestions = $productQuestions[0]; // Get the first (and assumed only) associative array

        // Initialize matches counter
        $matches = 0;

        // Calculate similarity
        foreach ($productQuestions as $key => $value) {
            // Get the index from the question key
            $index = str_replace('question_', '', $key); // Extract index from the question key

            // Check if userAnswers has the corresponding index
            if (isset($userAnswers[$index]) && trim(strtolower($userAnswers[$index])) === trim(strtolower($value))) {
                $matches++;
            }
        }

        // Calculate percentage similarity
        $totalQuestions = count($productQuestions);
        $similarityPercentage = ($totalQuestions > 0) ? ($matches / $totalQuestions) * 100 : 0;

        // Store similarity scores for later use
        $similarityScores[$product->id] = $similarityPercentage;

        // If 100% match, add to suggested products immediately
        if ($similarityPercentage === 100) {
            $suggestedProducts[] = $product;
        }
    }

    // If no 100% matches, find the most similar products
    if (empty($suggestedProducts) && !empty($similarityScores)) {
        // Get the maximum similarity percentage
        $maxSimilarity = max($similarityScores);

        // Find products with the maximum similarity percentage
        $mostSimilarProducts = array_filter($similarityScores, function ($score) use ($maxSimilarity) {
            return $score === $maxSimilarity;
        });

        // Fetch the products that are most similar
        foreach ($mostSimilarProducts as $productId => $score) {
            $product = Product::find($productId);
            if ($product) {
                $suggestedProducts[] = $product;
            }
        }

    }

     //dd($suggestedProducts);
    // Pass the suggested products to the view
    return view('suggested-products', compact('suggestedProducts'));

}


}
