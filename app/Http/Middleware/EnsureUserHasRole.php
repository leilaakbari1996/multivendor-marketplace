<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserType;
use App\Support\AuthUser;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * @param  string  ...$roles   'admin', 'vendor'
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = AuthUser::user();

        if ($user === null) {
            return redirect()->route('login');
        }

        $allowedRoles = array_map(
            fn (string $role): UserType => UserType::from($role),
            $roles,
        );

        if (! in_array($user->type, $allowedRoles, true)) {
            abort(403);
        }

        return $next($request);
    }
}
