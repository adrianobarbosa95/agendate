@extends('layouts.template')

@section('title', config('app.name').' - Cadastrar Requisição')
@section('pagina', 'Cadastrar Requisição')
@section('pagina2', 'Cadastrar Requisição')
@section('content')
<script>
    $('.alert').alert();
</script>
<div class="form-row">
    <div class="form-group col-md-12">
        <fieldset>
            <label for="nome" class="required">Nome: </label>
            <input autofocus list="usuarios" type="teext" onkeypress="up(event)" class="form-control" required name="nome" id="nome" value="@if(!is_null($usuarios->find(Request::query('usuario')))){{$usuarios->find(Request::query('usuario'))->nome}} - CPF: {{$usuarios->find(Request::query('usuario'))->cpf}} - RG: {{$usuarios->find(Request::query('usuario'))->rg}} - TITULO: {{$usuarios->find(Request::query('usuario'))->titulo}} - COD={{$usuarios->find(Request::query('usuario'))->id}}@endif" placeholder="Clique ou digite o nome do usuario, caso ao clicar e selecionar um usuario os campos abaixo não aparecer atualize a pagina ou clique fora.">
            <h6 style="color: #1acc8d; margin-top: 12px;">Digite o nome do usuario para filtrar a lista. Cajo não encontre, clique no botão "Cadastre novo usuario".</h6>
            <a id="btnnovo" style="width: 100%;" class="btn btn-primary" href="{{route('usuario.create')}}?url=requisicao.create">Cadastre novo usuario</a>

            <datalist id="usuarios">
                @foreach($usuarios as $usuario)

                <option value="{{$usuario->nome}} - CPF: {{$usuario->cpf}} - RG: {{$usuario->rg}} - TITULO: {{$usuario->titulo}} - COD={{$usuario->id}}">

                    @endforeach
            </datalist>
        </fieldset>
    </div>
</div>
<form action="{{route('requisicao.store')}}" method="post">
    @csrf

    <input type="hidden" class="form-control" name="user_id" id="user_id">
    <input type="hidden" class="form-control" name="usuario_id" id="usuario_id" value="{{Request::query('usuario')}}">

    <div id="corpo">
        <div class="form-row">
            <div class="form-group col-md-2">
                <label for="datarecebido" class="required">Recebemos em</label>
                <input type="date" required name="datarecebido" class="form-control" id="datarecebido" value="{{date('Y-m-d')}}">
            </div>
            


            <div class="form-group col-md-5">
                <label for="indicacao">Indicação</label>
                <input type="text" class="form-control" id="indicacao" name="indicacao" placeholder="Indicação/Motivo">
            </div>
            <div class="form-group col-md-5">
                <label for="procedimento" class="required">Procedimento</label>
                <input type="text" list="procedimentos" id="procedimento" name="procedimento" required class="form-control">
                <datalist id="procedimentos">
                    @foreach($procedimentos as $item)

                    <option value="{{$item->procedimento}}">
                        @endforeach


                </datalist>
            </div>
        </div>


        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="obs">Descrição</label>
                <textarea rows="5" class="form-control" name="obs" id="obs"></textarea>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Cadastrar requisição</button>
    </div>
</form>

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
            document.getElementById('corpo').style = "display: block";
            document.getElementById('btnnovo').style = "display: none";
            document.getElementById('usuario_id').value = currentValue2.slice(currentValue2.indexOf('=') + 1, e.target.value.length);
            console.log('evento "change" %s', currentValue2.slice(currentValue2.indexOf('=') + 1, e.target.value.length));

        }

    });
    document.getElementById('corpo').style.display = 'none';

    function up(event) {
        document.getElementById('corpo').style.display = 'none';
        var btn = document.getElementById('btnnovo');
        btn.style = "display: block";
        btn.href = "{{route('usuario.create')}}?url=requisicao.create&usuarioid=" + document.getElementById('nome').value + String.fromCharCode(event.keyCode);

    }


    const urlParams = new URLSearchParams(window.location.search);
    const products = urlParams.get("usuario");
    if (!products.length == 0) {
        document.getElementById('corpo').style = 'display: block';
        document.getElementById('btnnovo').style = "display: none";
    }
</script>
<script>

</script>
@stop