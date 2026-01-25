@props([
    'title'
])

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Plataforma de Cursos {{ $title ?? '' }}</title>
</head>
<body>
<!-- Header -->
<x-menu/>

{{-- Seção opcional full-width para a largura total caso precise--}}
@if(isset($fullWidth))
    {{$fullWidth}}
@endif


<!-- Conteúdo centralizado -->
<main class="max-w-6xl mx-auto py-10 px-4 grid gap-6 md:grid-cols-3">
    {{$slot}}
</main>

<!-- Footer -->
<x-footer/>
</body>
</html>
