<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suggested Products</title>
</head>
<body>
    <h1>Suggested Products for You</h1>
    <p>Based on your answers, we have some product suggestions:</p>
    <ul>
        @foreach ($products as $product) <!-- Loop through each product in the products array -->
            <li>
                <h2>{{ $product->name }}</h2> <!-- Display the product name -->

                <!-- Check if photos is an array and contains at least one image -->
                @if(is_array($product->photos) && count($product->photos) > 0)
                    <!-- Display the first product image -->
                    <img src="{{ asset('storage/' . $product->photos[0]) }}" alt="{{ $product->name }}" style="width: 100px; height: auto;">
                @else
                    <p>No images available for this product.</p> <!-- Fallback message -->
                @endif

                <p>{!! $product->description !!}</p> <!-- Display the product description -->
            </li>
        @endforeach
    </ul>
    <p>Thank you for participating!</p>
</body>
</html>
