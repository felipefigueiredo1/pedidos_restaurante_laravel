<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidosProduto extends Model
{
    use HasFactory;

    protected $fillable = [
        "mesa_id",
        "produto_id",
        "pedido_id",
        "pessoas",
        "produto_nome",
        "produto_preco",
        "pagamento_id",
    ];

    public function pedidos()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function pagamentos()
    {
        return $this->hasMany(Pagamento::class);
    }

}
