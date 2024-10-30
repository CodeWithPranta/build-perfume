<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> Perfume Builder </title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style> /* Basic Styling */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
            color: #333;
        }

        /* Bubble Animation Styling */
        .bubble {
            position: absolute;
            bottom: -50px;
            background-color: rgba(255, 192, 203, 0.5); /* Light pink for perfume effect */
            border-radius: 50%;
            opacity: 0.7;
            animation: rise 10s infinite ease-in-out;
            filter: blur(1px);
        }

        /* Keyframes for rising bubbles */
        @keyframes rise {
            0% {
                transform: translateY(0) scale(0.8);
                opacity: 0.4;
            }
            50% {
                opacity: 0.8;
            }
            100% {
                transform: translateY(-100vh) scale(1.2);
                opacity: 0;
            }
        }
        .progress-header {
            padding: 10px 0; /* Adjust padding as needed */
        }

        .progress-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .progress-bar {
            position: relative;
            width: 100%;
            height: 10px;
            background-color: #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background-color: #4CAF50;
            transition: width 0.3s ease;
        }

        .progress-percent {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
        }
        body {
            background-color: #f8fafc;
            color: #333;
            font-family: 'Figtree', sans-serif;
        }

        .progress-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 0; /* Adjust padding as needed */
            position: fixed; /* Fixed positioning */
            background-color: #fce7f3;
            top: 0; /* Position from the top */
            left: 0;
            right: 0;
            z-index: 50; /* Ensure it stays on top */
        }

        .progress-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 5px;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            flex: 1;
        }

        .circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .circle.active {
            background-color: #f59e0b; /* Change to yellow */
        }

        .progress-bar {
            position: relative;
            width: 100%;
            height: 10px;
            background-color: #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background-color: #4CAF50;
            transition: width 0.3s ease;
        }

        .progress-percent {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #4CAF50;
        }

        .form-container {
            max-width: 600px;
            margin: 110px auto 0; /* Add 20px top margin */
            padding: 10px;
            background: linear-gradient(to bottom, #fce7f3, #f1ebef, #ffffff); /* Multi-color gradient */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }


        label {
            font-size: 14px;
            color: #555;
        }

        .question-block {
            margin-bottom: 20px;
        }

        .question-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }

        .option-block {
            margin-bottom: 10px;
        }

        .option-block label {
            display: flex;
            align-items: center;
        }

        .option-block label img {
            margin-left: 10px;
            width: 50px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        input[type="radio"]:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 150, 0, 0.1);
        }

        button {
            width: 100%;
            padding: 12px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .styled-select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: #555;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            margin-top: 10px;
            cursor: pointer;
            appearance: none; /* Remove default browser styling */
        }

        .styled-select:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 150, 0, 0.2);
        }

        /* Adjust the layout for smaller devices */
        @media screen and (max-width: 768px) {
            .progress-container {
                display: flex;
                flex-direction: row;
                margin-bottom: 2px;
            }

            .step {
                flex: 1;
                margin: 0 10px;
            }

            .form-container {
                width: 100%;
                padding: 15px;
            }
        }

        @media screen and (max-width: 576px) {
            .progress-container {
                flex-direction: row;
                margin-bottom: 2px;
            }

            .step {
                flex: none;
                margin: 10px 0;
            }
        }
    </style>
</head>
<body class="bg-pink-100">

    <!-- Bubble Container -->
    <div id="bubble-container"></div>


    <div class="container py-5 mx-auto">
        <div class="mx-2 progress-header md:mx-6">
            <div class="progress-container">
                <div class="step">
                    <div class="circle" id="step1">1</div>
                </div>
                <div class="step">
                    <div class="circle" id="step2">2</div>
                </div>
                <div class="step">
                    <div class="circle" id="step3">3</div>
                </div>
            </div>

            <div class="progress-bar">
                <div class="progress-bar-fill" id="progress-bar-fill" style="width: 0%;"></div>
            </div>
            <div class="progress-percent" id="progress-percent">0%</div>
        </div>

        <div class="form-container">
            <div class="switch pt-10">
                @include('components.language-switch')
            </div>
            @if(session('success'))
                <div class="flex items-center justify-between p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                    <span class="font-medium">{{ session('success') }}</span>
                    <button type="button" class="ml-2 -mx-1.5 text-green-500 hover:text-green-700" aria-label="Close" onclick="this.parentElement.remove()">
                        <span class="sr-only">Close</span>
                        &times;
                    </button>
                </div>
            @endif
            <div class="pb-4 text-center">
                <h1 class="my-3 font-mono text-3xl font-bold text-gray-700 uppercase">
                  @if (session('language') === 'alb')
                      Së pari, ne do të kemi nevojë për përgjigje nga ju.
                  @else
                      First, we'll need answers from you.
                  @endif
                </h1>
            </div>
           <!-- Form with Questions -->
<form id="form" action="{{ route('answers.store') }}" method="POST">
    @csrf
    <div class="question-block mb-6">
        <label for="gender" class="uppercase question-title block mb-2 font-semibold">
            @if (session('language') === 'alb')
                Cila është gjinia juaj?
            @else
                What is your gender?
            @endif
        </label>
        <select name="gender" id="gender" class="styled-select p-2 border rounded w-full" required>
            <option value="" disabled selected>
                @if (session('language') === 'alb')
                    Zgjidhni gjininë tuaj
                @else
                    Select your gender
                @endif
            </option>
            <option value="male">
                @if (session('language') === 'alb')
                    Mashkull
                @else
                    Male
                @endif
            </option>
            <option value="female">
                @if (session('language') === 'alb')
                    Femër
                @else
                    Female
                @endif
            </option>
            <option value="other">
                @if (session('language') === 'alb')
                    Të tjera
                @else
                    Other
                @endif
            </option>
        </select>
    </div>

    @foreach($questions as $question)
        <div class="question-block mb-6">
            <div class="question-title font-semibold mb-2">
                @if (session('language') === 'alb')
                    {{ $question->alb_title }}
                @else
                    {{ $question->title }}
                @endif
            </div>
            @php
                $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
            @endphp
            @if(is_array($options))
                <div class="flex flex-wrap gap-4">
                    @foreach($options as $option)
                        <div class="option-block flex items-center gap-2">
                            <img src="{{ asset('storage/'.$option['image']) }}" alt="" class="w-10 h-10">
                            <label class="flex items-center space-x-2">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option['name'] }}" required>
                                <span>
                                    @if (session('language') === 'alb')
                                        {{ $option['alb_name'] }}
                                    @else
                                        {{ $option['name'] }}
                                    @endif
                                </span>
                            </label>
                        </div>
                    @endforeach
                </div>
            @else
                <p>No options available for this question.</p>
            @endif
        </div>
    @endforeach

    <!-- Separator -->
    <hr class="my-6 border-gray-300">

    <!-- Email Field -->
    <div class="question-block mb-6">
        <label for="email" class="question-title block mb-2 font-semibold">
            @if (session('language') === 'alb')
                Shkruani emailin tuaj për të marrë parfumin tuaj të sugjeruar:
            @else
                Enter your email to receive your suggested perfume:
            @endif
        </label>
        <input type="email" name="email" id="email" required placeholder="your-email@example.com" class="w-full p-3 border rounded" required>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="text-lg uppercase bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
        @if (session('language') === 'alb')
            Paraqisni
        @else
            Submit
        @endif
    </button>
</form>


        </div>
    </div>

    <script>
         // Generate bubbles with varying sizes and animation durations
         function createBubble() {
            const bubble = document.createElement("div");
            bubble.classList.add("bubble");

            // Random size between 20px and 80px
            const size = Math.random() * 60 + 20;
            bubble.style.width = `${size}px`;
            bubble.style.height = `${size}px`;

            // Random horizontal position
            bubble.style.left = `${Math.random() * 100}vw`;

            // Random animation duration between 6 and 12 seconds
            bubble.style.animationDuration = `${Math.random() * 6 + 6}s`;

            // Append bubble to container
            document.getElementById("bubble-container").appendChild(bubble);

            // Remove bubble after animation completes
            bubble.addEventListener("animationend", () => {
                bubble.remove();
            });
        }

        // Continuously create bubbles at intervals
        setInterval(createBubble, 500);

        const form = document.getElementById('form');
        const progressBarFill = document.getElementById('progress-bar-fill');
        const progressPercent = document.getElementById('progress-percent');
        const circles = document.querySelectorAll('.circle');

        function updateProgressBar() {
            // Get the total number of question blocks (including the email field as +1)
            const totalQuestions = form.querySelectorAll('.question-block').length; // This includes the email field since it's part of the form
            const answeredQuestions = Array.from(form.querySelectorAll('input[type="radio"]')).filter(input => input.checked).length;

            // Check if the email field is filled
            const emailFilled = form.querySelector('input[type="email"]').value.trim() !== '';

            // Check if the gender field has a selected value
            const genderSelected = form.querySelector('select[name="gender"]').value.trim() !== '';

            // Increment the answeredQuestions if email and gender are filled
            const completedSteps = answeredQuestions + (emailFilled ? 1 : 0) + (genderSelected ? 1 : 0);

            // Calculate the percentage of completed steps
            const percentage = Math.round((completedSteps / totalQuestions) * 100);

            // Update the progress bar width and the percentage text
            progressBarFill.style.width = percentage + '%';
            progressPercent.textContent = percentage + '%';

            // Update the progress circle steps based on the calculated percentage
            const stepPercentage = 100 / circles.length;
            circles.forEach((circle, index) => {
                if (percentage >= (index + 1) * stepPercentage) {
                    circle.classList.add('active');
                } else {
                    circle.classList.remove('active');
                }
            });
        }

        // Listen for changes in the form to update the progress bar
        form.addEventListener('input', updateProgressBar);

        // Also listen for changes specifically on the select dropdown
        form.querySelector('select[name="gender"]').addEventListener('change', updateProgressBar);

    </script>

</body>
</html>
