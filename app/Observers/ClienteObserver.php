<?php

namespace App\Observers;

use App\Models\Cliente;
use Illuminate\Support\Facades\Storage;

class ClienteObserver
{
    /**
     * Remove a foto do disco antes de excluir o cliente.
     */
    public function deleting(Cliente $cliente): void
    {
        if ($cliente->photo_path) {
            Storage::disk('public')->delete($cliente->photo_path);
        }
    }
}
