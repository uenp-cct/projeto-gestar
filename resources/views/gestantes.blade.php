@extends('layouts.app') 

@section('content')
<div class="container">
    <h2>Cadastro de Gestante</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('gestantes.store') }}">
        @csrf

        {{-- I - Dados cadastrais --}}
        <h4>I - Dados Cadastrais</h4>
        <div>
            <label>Nome:</label>
            <input type="text" name="nome" required>
        </div>

        <div>
            <label>Data de Nascimento:</label>
            <input type="date" name="data_nascimento">
        </div>

        <div>
            <label>Endereço:</label>
            <input type="text" name="endereco">
        </div>

        <div>
            <label>Número:</label>
            <input type="text" name="numero">
        </div>

        <div>
            <label>Bairro:</label>
            <input type="text" name="bairro">
        </div>

        <div>
            <label>Telefone:</label>
            <input type="text" name="fone">
        </div>

        <div>
            <label>Email:</label>
            <input type="email" name="email">
        </div>

        <hr>

        {{-- II - Dados sociodemográficos --}}
        <h4>II - Dados Sociodemográficos</h4>

        <div>
            <label>Idade:</label>
            <input type="number" name="idade">
        </div>

        <div>
            <label>Cor:</label>
            <select name="cor">
                <option value="1">Branca</option>
                <option value="2">Preta</option>
                <option value="3">Parda</option>
            </select>
        </div>

        <div>
            <label>Estado Conjugal:</label>
            <select name="estado_conjugal">
                <option value="1">Solteira</option>
                <option value="2">Casada / União Consensual</option>
                <option value="3">Viúva</option>
                <option value="4">Separada / Divorciada</option>
            </select>
        </div>

        <div>
            <label>Número de Filhos:</label>
            <select name="numero_filhos">
                <option value="1">0</option>
                <option value="2">1 a 3</option>
                <option value="3">Mais de 3</option>
            </select>
        </div>

        <div>
            <label>Escolaridade:</label>
            <select name="escolaridade">
                <option value="1">&lt; 9 anos</option>
                <option value="2">9 a 12 anos</option>
                <option value="3">&gt; 12 anos</option>
            </select>
        </div>

        <div>
            <label>Ocupação (descrição):</label>
            <input type="text" name="ocupacao">
        </div>

        <div>
            <label>Situação Ocupacional:</label>
            <select name="situacao_ocupacional">
                <option value="1">Ativa</option>
                <option value="2">Aposentada</option>
                <option value="3">Atividades do lar</option>
                <option value="4">Desempregada</option>
                <option value="5">Auxílio-doença</option>
            </select>
        </div>

        <div>
            <label>Número de pessoas na residência:</label>
            <input type="number" name="pessoas_residencia">
        </div>

        <div>
            <label>Renda Familiar (R$):</label>
            <input type="number" step="0.01" name="renda_familiar">
        </div>

        <div>
            <label>Renda Per Capita (R$):</label>
            <input type="number" step="0.01" name="renda_per_capita">
        </div>

        <hr>

        {{-- Botão de envio --}}
        <div>
            <button type="submit">Enviar formulário</button>
        </div>
    </form>
</div>
@endsection
