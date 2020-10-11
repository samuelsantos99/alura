@extends('layout')

@section('cabecalho')
    Episódios - {{ $temporadaNome }}
@endsection

@section('conteudo')

    @includeWhen(empty($mensagem), 'mensagem', ['mensagem' => $mensagem])

    <form action="/temporadas/{{ $temporadaId }}/episodios/assistir" method="POST">
        @csrf
        <ul class="list-group">
            @foreach ($episodios as $episodio)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Episódio {{ $episodio->numero }}
                    <input type="checkbox" name="episodios[]" value="{{ $episodio->id }}"
                        {{ $episodio->assistido ? 'checked' : '' }}>
                </li>
            @endforeach
        </ul>

        <button class="btn btn-primary mt-2 mb-2 float-right">Salvar</button>
    </form>
@endsection
