<?php 

namespace App\Services\User;

use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserService
{
    public function store(array $data): UserResource
    {
        Gate::authorize('create', User::class);

        return DB::transaction(fn () => new UserResource(User::create($data)));
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

        DB::transaction(fn () => $user->update($data));

        return new UserResource($user->refresh());
    }

   public function delete(array $data): void
    {
        $user = User::findOrFail($data['id']);
        Gate::authorize('delete', $user);

        DB::transaction(fn () => $user->delete());
    }

}