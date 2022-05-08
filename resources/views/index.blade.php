@extends('layouts.app')

@section('content')
<div class="container bg-light">
    <div class="bg-dark p-4 rounded">
        <h1 class="text-light text-center">Pedidos</h1>
    </div>
    <form action="{{ route('index') }}" method="post" class="mt-2">
        @csrf
        <div class="form-group mb-2">
            Mesa
            <select name="mesa" id="" class="form-select">
                @foreach($mesas as $mesa)
                <option value="{{ $mesa->id }}" name="{{ $mesa->id }}">{{ ucfirst($mesa->name) }} </option>
                @endforeach
            </select>
        </div>

            Pedidos
        @foreach($produtos as $produto)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $produto->id }}" name="produtos[]">
                <label class="form-check-label" for="produto{{ $produto->id }}">{{ ucfirst($produto->name) }},  R${{ $produto->price }}</label>
            </div>
        @endforeach

        <div class="form-group mt-3">
            Quantas pessoas
            <select name="pessoas" class="form-select mb-2" id="">
                <option value="1">1 Pessoa</option>
                <option value="2">2 Pessoas</option>
                <option value="3">3 Pessoas</option>
                <option value="4">4 Pessoas</option>
            </select>
        </div>

        <div class="form-group mb-3">
            Forma de pagamento
            <select name="pagamento" id="" class="form-select">

                @foreach ($pagamentos as $pagamento)
                <option value="{{ $pagamento->id }}" name="{{ $pagamento->id }}">{{ ucfirst($pagamento->name) }} </option>
                @endforeach
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>
        <div class="align-items-center mt-2">
            <!--<button class="btn btn-success " ><a href="{{ route('caixa') }}" class="text-light">Fechar Caixa</a></button>-->
            <p class="weight">Valor total caixa: R${{ number_format($pedidosS, 2) }}</p>
        </div>

    <hr>

    <div id="contas">

        @if(empty($pedidos))
        <p>Sem contas</p>
        @else
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Nº Conta</th>
                    <th>Pessoas</th>
                    <th>Mesa</th>
                    <th>Valor total</th>
                    <th>Valor dividido</th>
                    <th>Forma pagamento</th>
                    <th>Opções</th>
                </tr>
            </thead>
        @foreach ( $pedidos as $key => $pedido )
            <tbody>
                <tr>
                    <td scope="row">{{ $pedido->id }}</td>
                    <td>{{ $pedido->pessoas }}</td>
                    <td>{{ $pedido->pedidosProdutos[0]->mesa_id}}</td>
                    <td>R${{ number_format($pedido->pedidosProdutos->sum('produto_preco'), 2)}}</td>
                    <td>R${{ number_format($pedido->pedidosProdutos->sum('produto_preco') / $pedido->pessoas, 2) }}</td>
                    <td>{{ ucfirst($pagamentos->find($pedido->pedidosProdutos[0]->pagamento_id)->name) }}</td>
                    <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pedidoModal" onclick="modalPedido({{ $pedido->id }})">Detalhes</button></td>
                </tr>
            </tbody>
        @endforeach
        </table>
        @endif

    </div>
</div>
<div class="modal fade" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="pedidoModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="pedidoBody">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('js')

<script>

function modalPedido(id){
    $.ajax({
        url: '/index/'+id,
        type: 'GET',
        success: function(data){
            $("#pedidoModalLabel").html('Conta Nº '+data[0].pedido_id)
            $("#pedidoBody").empty()
            for (i = 0; i < data.length; i++ ) {
                $("#pedidoBody").append(
                '<p>Consumidos: '+data[i].produto_nome.toUpperCase()+' <br> Preço: R$'+data[i].produto_preco+'</p>'
                )
            }
        }
    })
}

</script>

@endsection
