<h1>{{ config('app.name') }}</h1>

<h2>Invoice #{{ $id }}</h2>

<p><b>Item: {{ $description }}</b></p>

<p>We hereby charge you {{ $currency }} {{ $amount }}. Thank's a lot!</p>

<p>Your Marqant Team!</p>

