@extends('layouts.template')

@section('title', config('app.name').' - Mostrar Agendamento')
@section('pagina', 'Mostrar Agendamento')
@section('pagina2', 'Mostrar Agendamento')
@section('content')
<script>
    $('.alert').alert();
</script>
<div class="form-row">
    <div class="form-group col-md-12">
        <fieldset>
            <label for="nome" class="required">Nome: </label>
            <input readonly autofocus list="usuarios" type="text" onkeydown="up()" class="form-control" required name="nome" id="nome" value="{{$agendamento->usuario->nome}} - CPF: {{$agendamento->usuario->cpf}} - RG: {{$agendamento->usuario->rg}} - TITULO: {{$agendamento->usuario->titulo}} - COD={{$agendamento->usuario->id}}" placeholder="Clique ou digite o nome do usuario, caso ao clicar e selecionar um usuario os campos abaixo não aparecer atualize a pagina ou clique fora.">
            <a href="{{route('usuario.show', $agendamento->usuario->id)}}">Consultar Usuario</a>
            <datalist id="usuarios">
                @foreach($usuarios as $usuario)

                <option value="{{$usuario->nome}} - CPF: {{$usuario->cpf}} - RG: {{$usuario->rg}} - TITULO: {{$usuario->titulo}} - COD={{$usuario->id}}">

                    @endforeach
            </datalist>
        </fieldset>
    </div>
</div>
<form action="{{route('agendamento.store')}}" method="post">
    @csrf

    <input type="hidden" class="form-control" name="user_id" id="user_id">
    <input type="hidden" class="form-control" name="usuario_id" id="usuario_id">

    <div id="corpo">
        <div class="form-row">
            <div class="form-group col-md-3">
                <label readonly for="obs">Qual a data do agendamento? </label>
                <input readonly class="form-control" value="{{ \Carbon\Carbon::parse($agendamento->data)->format('d/m/Y')}}">
            </div>
            <div class="form-group col-md-4">
                <label readonly for="obs">Qual a hora do agendamento? </label>
                <input readonly class="form-control" value="{{ \Carbon\Carbon::parse($agendamento->hora)->format('H:i:s')}}">
            </div>

        </div>


        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="obs">Descrição</label>
                <textarea rows="5" readonly class="form-control" name="descricao" id="descricao">{{$agendamento->descricao}}</textarea>
            </div>
        </div>

    </div>
</form>
<h6>Agendamento registrado por: {{$agendamento->user->name}} em {{ \Carbon\Carbon::parse($agendamento->created_at)->format('d/m/Y - H:i:s')}}</h6>
<script>
    function qs(query, context) {
        return (context || document).querySelector(query);
    }

    function qsa(query, context) {
        return (context || document).querySelectorAll(query);
    }

    qs("#nome").addEventListener('change', function(e) {

        var options = qsa('#' + e.target.getAttribute('list') + ' > option'),
            values = [];

        [].forEach.call(options, function(option) {
            values.push(option.value)
        });

        var currentValue = e.target.value;
        var currentValue2 = e.target.value;

        if (values.indexOf(currentValue) !== -1) {

            // document.getElementById('localdestino').value = e.target.value.slice(e.target.value.indexOf('-') + 2, e.target.value.length);
            // document.getElementById('cargodestino').value = e.target.value.slice(e.target.value.indexOf(',') + 2, e.target.value.indexOf('-') - 1);
            // document.getElementById('destinatario').value = e.target.value.slice(e.target.value.indexOf(':') + 2, e.target.value.indexOf(','));
            // document.getElementById('tratamento').value = currentValue2.slice(0, currentValue2.indexOf(':'));

            // document.getElementById('localdestino').style = "background-color: #ccc";
            // document.getElementById('cargodestino').style = "background-color: #ccc";
            // document.getElementById('destinatario').style = "background-color: #ccc";
            // document.getElementById('tratamento').style = "background-color: #ccc";

            document.getElementById('usuario_id').value = currentValue2.slice(currentValue2.indexOf('=') + 1, e.target.value.length);
            console.log('evento "change" %s', currentValue2.slice(currentValue2.indexOf('=') + 1, e.target.value.length));

        }

    });
</script>

@stop