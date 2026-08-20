<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ClienteController extends Controller {
    public function index(): View {
        try {
            return view('clientes.index');
        } catch (\Throwable) {
            abort(404);
        }
    }

    /**
     * Fonte de dados AJAX (server-side) para o DataTable de clientes.
     */
    public function all(): JsonResponse {
        $clientes = Cliente::query()->select(['id', 'name', 'email', 'phone', 'photo_path']);

        return DataTables::of($clientes)
            ->addColumn('foto', fn (Cliente $cliente) => view('clientes.datatable._foto_column', compact('cliente'))->render())
            ->addColumn('acoes', fn (Cliente $cliente) => view('clientes.datatable._acoes_column', compact('cliente'))->render())
            ->rawColumns(['foto', 'acoes'])
            ->make(true);
    }

    public function create(): View|RedirectResponse {
        try {
            return view('clientes.create');
        } catch (\Throwable $th) {
            return redirect()->route('clientes.index')->with('error', 'Não foi possível abrir o formulário: ' . $th->getMessage());
        }
    }

    /**
     * Store cliente form
     * @param StoreClienteRequest $request
     * @return RedirectResponse
     */
    public function store(StoreClienteRequest $request): RedirectResponse {
        // return validated data from request
        $validated = $request->validated();
        $photoPath = null;
        try {
            // set the photo path
            $photoPath = $request->hasFile('photo')
                ? Cliente::storeUploadedPhoto($request->file('photo'))
                : null;
            $validated['photo_path'] = $photoPath;
            // initialize transaction
            beginTransaction();
            // create the cliente
            $cliente = Cliente::create($validated);
            // Commit cliente
            commit();
            // Redirect the user to index with a success message
            return redirect()->route('clientes.index')->with('success', "Cliente \"{$cliente->name}\" criado com sucesso.");
        } catch (\Throwable $th) {
            rollback();
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            return back()->withInput()->with('error', 'Não foi possível criar o cliente: ' . $th->getMessage());
        }
    }

    public function edit(Cliente $cliente): View|RedirectResponse {
        try {
            return view('clientes.edit', compact('cliente'));
        } catch (\Throwable $th) {
            return redirect()->route('clientes.index')->with('error', 'Não foi possível abrir o formulário: ' . $th->getMessage());
        }
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente): RedirectResponse {
        $validated = $request->validated();
        $newPhotoPath = null;

        try {
            if ($request->hasFile('photo')) {
                $validated['photo_path'] = $newPhotoPath = Cliente::storeUploadedPhoto($request->file('photo'), $cliente->photo_path);
            }

            beginTransaction();
            $cliente->update($validated);
            commit();
        } catch (\Throwable $th) {
            rollback();
            if ($newPhotoPath) {
                Storage::disk('public')->delete($newPhotoPath);
            }

            return back()->withInput()->with('error', 'Não foi possível atualizar o cliente: ' . $th->getMessage());
        }

        return redirect()->route('clientes.index')->with('success', "Cliente \"{$cliente->name}\" atualizado com sucesso.");
    }

    /**
     * Dados do cliente para popular o modal de confirmação de exclusão.
     */
    public function confirmarExclusao(Cliente $cliente): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => 'Dados carregados para confirmação de exclusão.',
            'data' => [
                'id' => $cliente->id,
                'name' => $cliente->name,
                'email' => $cliente->email,
                'phone' => $cliente->phone,
                'photo_url' => $cliente->photo_url,
            ],
        ]);
    }

    public function destroy(Cliente $cliente): JsonResponse {
        try {
            beginTransaction();
            $cliente->delete();
            commit();
        } catch (\Throwable $th) {
            rollback();
            return response()->json([
                'success' => false,
                'message' => 'Não foi possível excluir o cliente: ' . $th->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cliente excluído com sucesso.',
        ]);
    }
}
