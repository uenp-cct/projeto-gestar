<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre o Projeto - Gestar</title>
    @vite('resources/css/app.css') <!-- Importa o Tailwind -->
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
<div class="bg-white p-6 shadow-lg rounded-lg max-w-2xl w-full">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 text-center">Sobre o Projeto</h1>
    <p class="text-gray-600 mt-4 text-justify">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent a metus ut justo laoreet gravida.
        Donec tristique libero nec arcu faucibus, nec tincidunt massa consequat. Sed varius, metus ac facilisis
        varius, lectus odio tincidunt mauris, vel elementum sapien ipsum in leo.
    </p>
    <p class="text-gray-600 mt-4 text-justify">
        Fusce non lectus id velit consectetur viverra at nec orci. Integer accumsan orci in lacus dignissim,
        a auctor lorem egestas. Mauris fermentum urna non lorem scelerisque, sed varius orci laoreet.
    </p>

    <!-- Botão Voltar -->
    <div class="mt-6 text-center">
        <a href="{{ url('/') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
            Voltar
        </a>
    </div>
</div>
</body>
</html>
