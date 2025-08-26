<!-- resources/views/importar-livros.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Importar Livros</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
</head>

<body>
    <div class="container mx-auto p-6">
        <h1 class="text-blue-700 text-4xl mb-10">Importar Livros e Gerar CSV</h1>

        @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('importar.livros') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label class="block text-blue-700 font-medium mb-2">CSV de Livros (contem: nome, id_autor,
                    id_editora)</label>
                <input type="file" name="livros" required class="w-md px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-blue-700 font-medium mb-2">CSV de Autores (contem: nome do autor, id)</label>
                <input type="file" name="autores" required class="w-md px-3 py-2 border rounded-lg">
            </div>
            <div>
                <label class="block text-blue-700 font-medium mb-2">CSV de Editoras (contem: nome da editora,
                    id)</label>
                <input type="file" name="editoras" required class="w-md px-3 py-2 border rounded-lg">
            </div>
            <button type="submit"
                class="bg-blue-700 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition mt-4">Gerar CSV
                Final</button>
            <a href="/" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                Voltar  
            </a>
        </form>
    </div>

</body>

</html>
