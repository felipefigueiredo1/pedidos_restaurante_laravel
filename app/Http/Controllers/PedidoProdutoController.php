<?php

namespace App\Http\Controllers;


use App\Models\Mesa;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use App\Models\PedidosProduto;

class PedidoProdutoController extends Controller
{
    /**
     * Método que retorna os dados para abrir a conta
     *
     * @return view|array
     */
    public function index()
    {
        $mesas      = Mesa::all();
        $produtos   = Produto::all();
        $pedidos    = Pedido::all();
        $pedidosS   = PedidosProduto::all();
        $pagamentos = Pagamento::all();
        return view('index', ['mesas' =>$mesas, 'produtos' => $produtos, 'pedidos' => $pedidos, 'pedidosS' => $pedidosS->sum('produto_preco'), 'pagamentos' => $pagamentos]);
    }

    /**
     * Método responsável por armazenar novos registros
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {

        

        $pedido = Pedido::create([
            'pessoas' => $request->pessoas
        ]);
        $pedido->save();

        $produtos = $request->produtos;

        foreach ($produtos as $key => $produto_valor) {
            $alimentos = Produto::find($produto_valor);
            $produtosS = PedidosProduto::create([
                'produto_id' => $produto_valor,
                'pedido_id' => $pedido->id,
                'produto_nome' => $alimentos->name,
                'produto_preco' => $alimentos->price,
                'mesa_id' => $request->mesa,
                'pagamento_id' => $request->pagamento,
            ]);

        }
        $produtosS->save();

        return back();
    }

    /**
     * Método responsável para mostrar as contas abertas no caixa
     *
     * @return void
     */
    public function show()
    {
        $pedidos = PedidosProduto::all();
        return view('caixa', ['pedidos' => $pedidos]);
    }

    public function find($id)
    {
        $pedidos = Pedido::find($id);
        return response()->json($pedidos->pedidosProdutos);
    }

    public function box()
    {


    }

}
