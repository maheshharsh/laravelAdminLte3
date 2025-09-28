<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    @if (isset($article))
        <meta property="og:title" content="{{ $article->title }}" />
        <meta property="og:description" content="{{ $article->sub_content }}" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{ route('articles.show', $article->id) }}" />
        <meta property="og:image" content="{{ $article->image }}" />

        <meta name="title" content="{{ $article->title }}" />
        <meta name="description" content="{{ $article->sub_content }}">
        <link rel="image_src" href="{{ $article->image }}" />
    @else
        <meta property="og:title" content="Samachar House News">
        <meta property="og:description" content="Hindi news portal covering politics, climate, and local updates.">
        <meta property="og:image" content="https://samacharhouse.com/images/logo.jpeg">
        <meta property="og:url" content="https://samacharhouse.com/">
        <meta property="og:type" content="website">

        <meta name="title" content="Samachar House News">
        <meta name="description" content="Hindi news portal covering politics, climate, and local updates related to bikaner.">
        <link rel="image_src" href="https://samacharhouse.com/images/logo.jpeg">
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    @vite(['resources/js/app.tsx', 'resources/css/app.css'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
