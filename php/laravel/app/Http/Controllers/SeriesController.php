<?php

namespace App\Http\Controllers;

use App\Episodio;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesFormRequest;
use App\Serie;
use App\Services\CriadorDeSerie;
use App\Services\RemovedorDeSerie;
use App\Temporada;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $serie = new Serie();
        $series = $serie->query()
            ->orderBy('nome')
            ->get();

        $mensagem = $request->session()->get('mensagem');
    
        return view('series.index', [
            'series' => $series,
            'mensagem' => $mensagem
        ]);
    }

    public function create(Request $request)
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request, CriadorDeSerie $criadorDeSerie)
    {
        $serie = $criadorDeSerie->criarSerie($request->nome, $request->qtd_temporadas, $request->ep_por_temporada);

        $request->session()->flash('mensagem', 'Série ' . $serie->id . ' e suas temporadas e episódios criados com sucesso ' . $serie->nome);

        return redirect(route('listar_series'));
    }
    
    public function destroy(Request $request, RemovedorDeSerie $removedorDeSerie)
    {
        $nomeSerie = $removedorDeSerie->removerSerie($request->id);
        
        // Serie::destroy($request->id);
        $request->session()->flash(
            'mensagem',
            'Serie ' . $nomeSerie . ' removida com sucesso'
        );

        return redirect(route('listar_series'));
    }

    public function editaNome(int $id, Request $request) {
        $novoNome = $request->nome;

        $serie = Serie::find($id);
        $serie->nome = $novoNome;

        $serie->save();
    }
}
