<?php 

namespace App\Services\User;

use App\Exceptions\ApiException;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserService
{
    public function store(array $data): UserResource
    {
        Gate::authorize('create', User::class);

        return DB::transaction(function() use ($data) {
            $user = User::create($data);

            if(!empty($data['role']))
            {
                $user->syncRoles($data['role']);
            }

            return new UserResource($user);
        });
    }

    public function index(array $data): UserCollection
    {
        Gate::authorize('viewAny', User::class);

        $user = User::paginate($data['perPage'], ['*'], 'page', $data['page']);
        return new UserCollection($user);
    }

    public function show(array $data): UserResource
    {
        $user = User::findOrFail($data['id']);
        Gate::authorize('view', $user);

        return new UserResource($user);
    }

    public function update(array $data): UserResource
    {
        $user = User::findOrFail($data['id']);
        Gate::authorize('update', $user);

        return DB::transaction(function() use ($data, $user) { 
            $user->update($data);

            if(!empty($data['role']))
            {
                $role = Role::findById($data['role'], 'api');

                if ($user->hasRole('admin') && $role->name !== 'admin' && User::role('admin')->count() === 1) {
                    throw new ApiException('Cannot remove the last admin!', 422);
                }

                $user->syncRoles($role);
            }

            return new UserResource($user->refresh());
        });
    }

    public function delete(array $data): void
    {
        $user = User::findOrFail($data['id']);
        Gate::authorize('delete', $user);

        if ($user->hasRole('admin') && User::role('admin')->count() === 1) {
            throw new ApiException('Cannot remove the last admin!', 422);
        }

        DB::transaction(fn () => $user->delete());
    }

}