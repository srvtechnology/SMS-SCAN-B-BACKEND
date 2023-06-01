<?php

namespace App\Http\Middleware;

use App\Models\Permission as ModelsPermission;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        foreach (ModelsPermission::all() as $key => $permission) {
            $id = $permission->id;
            Gate::define($permission->name, function () use ($id) {
                $permissions = Auth::user()->role->permissions->pluck('id')->toArray();
                return in_array($id, $permissions);
            });
        }

        return $next($request);
    }
}
