<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ __('smtp.test_email.title') }}</title>
</head>
<body>
    <h1>{{ __('smtp.test_email.heading') }}</h1>
    <p>{{ __('smtp.test_email.content') }}</p>
    <p>{{ __('smtp.test_email.time', ['time' => now()]) }}</p>
</body>
</html>
