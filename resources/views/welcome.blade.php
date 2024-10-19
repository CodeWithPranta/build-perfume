<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laravel Progress Bar</title>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
       html, body {
            height: 100%;
            margin: 0;
            padding: 0;
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
            color: #333;
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
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
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

    <div class="container mx-auto py-5">
        <div class="progress-header">
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
            <div class="text-center pb-4">
                <h1 class="my-3 text-3xl text-gray-700 uppercase font-bold font-mono">First, we'll need answers from you.</h1>
            </div>
            <!-- Form with Questions -->
            <form id="form" action="#" method="POST">
                @csrf
                @foreach($questions as $question)
                    <div class="question-block">
                        <div class="question-title">{{ $question->title }}</div>
                        @php
                            $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                        @endphp
                        @if(is_array($options))
                            @foreach($options as $option)
                                <div class="option-block">
                                    <label>
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option['name'] }}">
                                        {{ $option['name'] }}
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <p>No options available for this question.</p>
                        @endif
                    </div>
                @endforeach

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('form');
        const progressBarFill = document.getElementById('progress-bar-fill');
        const progressPercent = document.getElementById('progress-percent');
        const circles = document.querySelectorAll('.circle');

        function updateProgressBar() {
            const totalQuestions = form.querySelectorAll('.question-block').length;
            const answeredQuestions = Array.from(form.querySelectorAll('input[type="radio"]')).filter(input => input.checked).length;

            const percentage = Math.round((answeredQuestions / totalQuestions) * 100);
            progressBarFill.style.width = percentage + '%';
            progressPercent.textContent = percentage + '%';

            // Update circle progress steps
            circles.forEach((circle, index) => {
                if (percentage >= (index + 1) * 33) {
                    circle.classList.add('active');
                } else {
                    circle.classList.remove('active');
                }
            });
        }

        form.addEventListener('input', updateProgressBar);
    </script>

</body>
</html>
