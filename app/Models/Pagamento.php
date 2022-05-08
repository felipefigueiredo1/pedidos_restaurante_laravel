<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    public function pedidosProdutos()
    {
        return $this->hasMany(PedidosProduto::class);
    }
}
