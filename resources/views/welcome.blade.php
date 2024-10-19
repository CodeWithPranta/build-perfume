<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

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
            background-color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }


        label {
            font-size: 14px;
            color: #555;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 6px;
            margin-bottom: 12px;
            font-size: 14px;
            color: #333;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #4CAF50;
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
<body class="font-sans antialiased dark:bg-pink-100 dark:text-white/50">
    <div class="container mx-auto py-5">
        <div class="progress-header mx-2">
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

            <!-- Progress bar -->
            <div class="progress-bar">
                <div class="progress-bar-fill" id="progress-bar-fill" style="width: 0%;"></div>
            </div>
            <div class="progress-percent" id="progress-percent">0%</div>
        </div>


        <div class="form-container">
            <!-- Contact Form -->
            <div class="text-center">
                <h1 class="my-3 text-3xl font-semibold text-gray-700">Contact Us</h1>
                <p class="text-gray-400">Fill up the form below to send us a message.</p>
            </div>

            <form id="form">
                <div>
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" placeholder="John Doe" required />
                </div>
                <div>
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="you@company.com" required />
                </div>
                <div>
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" placeholder="+1 (555) 1234-567" required />
                </div>
                <div>
                    <label for="country">Country</label>
                    <select name="country" id="country" required>
                        <option></option>
                        <option>Ireland</option>
                        <option>USA</option>
                        <option>Canada</option>
                    </select>
                </div>
                <div>
                    <label for="message">Your Message</label>
                    <textarea name="message" id="message" placeholder="Your Message" rows="5" required></textarea>
                </div>
                <div>
                    <label>Agree to Privacy Policy</label>
                    <input type="checkbox" id="checkbox" name="checkbox" required />
                </div>
                <div>
                    <label>Are you happy?</label>
                    <div>
                        <label>
                            <input type="radio" name="happy" value="yes" required />
                            Yes
                        </label>
                        <label>
                            <input type="radio" name="happy" value="no" required />
                            No
                        </label>
                    </div>
                </div>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </div>

    <script>
        const form = document.getElementById('form');
        const progressBarFill = document.getElementById('progress-bar-fill');
        const progressPercent = document.getElementById('progress-percent');
        const circles = document.querySelectorAll('.circle');
        const totalFields = form.querySelectorAll('input[required], select[required], textarea[required]').length;

        function updateProgressBar() {
            const filledFields = Array.from(form.elements).filter(el =>
                (el.type !== 'radio' && el.type !== 'checkbox' && el.value.trim()) ||
                (el.type === 'checkbox' && el.checked) ||
                (el.type === 'radio' && document.querySelector(`input[name="${el.name}"]:checked`))
            ).length;

            const percentage = Math.round((filledFields / totalFields) * 100);
            progressBarFill.style.width = percentage + '%';
            progressPercent.textContent = percentage + '%';

            // Update step circles
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
