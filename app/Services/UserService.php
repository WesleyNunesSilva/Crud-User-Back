<?php

namespace App\Services;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;


class UserService
{
    public function getPaginated(array $filters = []): LengthAwarePaginator
    {
        $query = User::query()
            ->whereNull('deleted_at')
            ->with('permissions')
            ->when($filters['search'] ?? null, fn ($query, $search) =>
                $query->where('name', 'ilike', "%{$search}%")
                      ->orWhere('email', 'ilike', "%{$search}%")
                      ->orWhere('phone', 'ilike', "%{$search}%")
            )
            ->orderBy($filters['sort_by'] ?? 'created_at', $filters['sort_direction'] ?? 'desc');

            return $query->paginate($filters['per_page'] ?? 15);
    }

    public function getById(int $id): User
    {
        try {
            return User::with('permissions')->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(
                response()->json(['message' => 'Usuário não encontrado.'], 404)
            );
        }
    }

    public function create(StoreUserRequest $request): User
    {
        DB::beginTransaction();

        try {
            $user = User::create($request->validated());

            if($request->filled('permissions')) {
                $user->permissions()->sync($request->permissions);
            }

            DB::commit();

            return $user;

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Erro ao criar usuário', ['error' => $e->getMessage()]);
                throw $e;
        }
    }

    public function update (UpdateUserRequest $request, int $id): User
    {
        DB::beginTransaction();

        try {

            $user = User::findOrFail($id);
            $user->update($request->validated());

            if($request->filled('permissions')) {
                $user->permissions()->sync($request->permissions);
            }

            DB::commit();

            return $user;

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Erro ao atualizar usuário', ['error' => $e->getMessage()]);
                throw $e;
        }
    }

    public function delete(int $id): void
    {
        try {
            User::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            throw new HttpResponseException(
                response()->json(['message' => 'Usuário não encontrado.'], 404)
            );
        }
    }
}