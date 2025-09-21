<!DOCTYPE html>
<html>
<head>
    <title>Bestel een boeket</title>
</head>
<body>
    <h1>Kies je boeket</h1>
    <form action="{{ route('checkout') }}" method="POST">
        @csrf
        <label for="product">Boeket:</label>
        <select name="product_id" id="product">
            @foreach ($products as $product)
                <option value="{{ $product['id'] }}">
                    {{ $product['name'] }} - €{{ number_format($product['price']/100, 2) }}
                </option>
            @endforeach
        </select>

        <label for="quantity">Aantal:</label>
        <input type="number" id="quantity" name="quantity" value="1" min="1">

        <input type="submit" value="betaal"></input>
    </form>
</body>
</html>