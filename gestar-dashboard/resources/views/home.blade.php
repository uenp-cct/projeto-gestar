<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Gestar - UENP</title>
    @vite('resources/css/app.css') <!-- Importa o Tailwind -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
<div class="text-center bg-white p-8 shadow-lg rounded-lg w-full max-w-md">
    <img src="https://uenp.edu.br/images/institucional/logo/logo-uenp.jpg"
         alt="Logo UENP"
         class="mx-auto mb-4 w-32 sm:w-48">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Projeto Gestar</h1>
    <h2 class="text-lg sm:text-xl text-gray-600 mt-2">UENP</h2>

    <!-- Links -->
    <div class="mt-6 flex flex-col gap-3">
        <a href="{{ url('/about') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            Sobre o Projeto
        </a>
        <a href="{{ url('/admin') }}" class="bg-gray-700 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
            Dashboard
        </a>
    </div>
</div>
</body>
</html>
