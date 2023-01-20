<?php

namespace App\Http\Controllers;

use App\Models\doacao as ModelsDoacao;

class ListaDoacaoController extends Controller
{
    public function index()
    {
        $doacoes = ModelsDoacao::orderBy('dtcadastro', 'desc')->get();

        return response()->json(['doacoes' => $doacoes], 200);
    }
}
