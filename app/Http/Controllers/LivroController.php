<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LivroController extends Controller
{
    public function showForm()
    {
        return view('importar-livros');
    }

    public function processarForm(Request $request)
    {
        $request->validate([
            'livros' => 'required|file|mimes:csv,txt',
            'autores' => 'required|file|mimes:csv,txt',
            'editoras' => 'required|file|mimes:csv,txt',
        ]);

        function lerCsv($arquivo, $chave = null)
        {
            $dados = [];
            if (($handle = fopen($arquivo, "r")) !== false) {
                $cabecalho = fgetcsv($handle, 1000, ","); // primeira linha = cabeçalho
                while (($linha = fgetcsv($handle, 1000, ",")) !== false) {
                    $registro = array_combine($cabecalho, $linha);
                    if ($chave) {
                        $dados[$registro[$chave]] = $registro;
                    } else {
                        $dados[] = $registro;
                    }
                }
                fclose($handle);
            }
            return $dados;
        }

        $autores  = lerCsv($request->file('autores')->getRealPath(), 'id_autor');
        $editoras = lerCsv($request->file('editoras')->getRealPath(), 'id_editora');
        $livros   = lerCsv($request->file('livros')->getRealPath());

        // Definir caminho dentro de storage/app
        $nomeArquivo = 'livros_completo.csv';
        $caminho     = storage_path("app/$nomeArquivo");

        // Criar CSV final
        $arquivoSaida = fopen($caminho, 'w');
        fputcsv($arquivoSaida, ['Livro', 'Autor', 'Editora']);


        foreach ($livros as $livro) {
            $autor   = $autores[$livro['id_autor']]['nome']   ?? 'Sem autor';
            $editora = $editoras[$livro['id_editora']]['nome'] ?? 'Sem editora';
            fputcsv($arquivoSaida, [$livro['nome'], $autor, $editora]);
        }

        fclose($arquivoSaida);
        // Forçar download do arquivo gerado
        return response()->download($caminho)->deleteFileAfterSend(true);
    }
}
