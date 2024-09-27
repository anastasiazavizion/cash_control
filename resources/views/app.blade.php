<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
    @routes()
    @vite(['resources/js/app.js', 'resources/scss/app.scss', 'resources/css/app.css'])
</head>
<body>
<div id="app">
</div>
<script type="text/javascript">
    window.Laravel = {
        jsPermissions: {!! auth()->check() ? auth()->user()->jsPermissions() : 0!!},
        storageUrl: '{{ Storage::temporaryUrl('/logo/logo.png') }}',
    }
</script>
</body>
</html>
