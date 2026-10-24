<?php 

namespace App\Services\Auth;

use App\Exceptions\ApiException;
use App\Http\Resources\User\UserResource;
use App\Models\TwoAuthCode;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function register(array $data): User
    {
        return DB::transaction(function() use ($data) {
            $user = User::create($data);
            $user->assignRole('client');
            return $user;
        });
    }

    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password)) 
        {
            throw new ApiException("Invalid credentials!");
        }

        // Verify if 2fa is active
        if($this->verifyIsActive2fa($user))
        {
            // Use challenge_id for validate 2fa code on 2fa route
            return [
                'requires_2fa' => true,
                'challenge_id' => $this->createTwoAuthCode($user),
            ];
        }

        return $this->tokenResponse($user);
    }

    public function login2fa(array $data): array
    {
        $twoAuthCode = TwoAuthCode::find($data['two_auth_id']);

        if(!$twoAuthCode || 
            $twoAuthCode->expires_at->isPast() || // expires_at casts return Carbon date
            !hash_equals($twoAuthCode->code, $data['code']) // Validate two string with constant time
        ) {
            throw new ApiException('Invalid or expired code!');
        }

        $user = $twoAuthCode->user;
        $twoAuthCode->delete();
        return $this->tokenResponse($user);
    }

    public function toggle2fa(array $data): User 
    {
        $user = User::findOrFail($data['id']);

        return DB::transaction(function() use ($data, $user) {
            $user->update($data);
            $user->refresh();
            return $user;
        });
    }

    public function me(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function logout(): void
    {
        auth()->logout();
    }

    public function refresh(): array
    {
        return [
            'token' => auth()->refresh(),
            'expires_in' => Config::get('jwt.ttl') * 60,
        ];
    }

    protected function verifyIsActive2fa(User $user): bool
    {
        if ($user->requires_2fa)
        {
            return true;
        }

        return false;
    }

    protected function tokenResponse(User $user): array
    {
        return [
            'user' => new UserResource($user),
            'token' => JWTAuth::fromUser($user),
            'expires_in' => Config::get('jwt.ttl') * 60,
            'refresh_in' => Config::get('jwt.refresh_ttl') * 60,
        ];
    }

    protected function createTwoAuthCode(User $user): string
    {
        // Dispatch email
        $twoAuth = TwoAuthCode::create([
            'expires_at' => now()->addMinutes(10)->toDateTimeLocalString(),
            // Case create number with minus than 6 digits complete with 0 on the left
            'code' => str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT), 
            'user_id' => $user->id
        ]);
        
        return $twoAuth->id;
    }
}