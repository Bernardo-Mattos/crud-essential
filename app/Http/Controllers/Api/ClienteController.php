<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Http\Resources\ClienteResource;
use App\Models\Cliente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ClienteController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return ClienteResource::collection(Cliente::latest()->paginate(15));
    }

    public function store(StoreClienteRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $photoPath = null;

        try {
            $photoPath = $request->hasFile('photo')
                ? Cliente::storeUploadedPhoto($request->file('photo'))
                : null;
            $validated['photo_path'] = $photoPath;

            beginTransaction();
            $cliente = Cliente::create($validated);
            commit();
        } catch (\Throwable $th) {
            rollback();
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }

            throw $th;
        }

        return (new ClienteResource($cliente))->response()->setStatusCode(JsonResponse::HTTP_CREATED);
    }

    public function show(Cliente $cliente): ClienteResource
    {
        return new ClienteResource($cliente);
    }

    public function update(UpdateClienteRequest $request, Cliente $cliente): ClienteResource
    {
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

            throw $th;
        }

        return new ClienteResource($cliente->fresh());
    }

    public function destroy(Cliente $cliente): Response
    {
        beginTransaction();
        $cliente->delete();
        commit();

        return response()->noContent();
    }
}
