@extends('layouts.app')
@section('titulo', 'Cadastro de sócio | Retrô FC')
@section('conteudo')
    @livewire('cadastro-component', ['plano' => $plano])
@endsection
