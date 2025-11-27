<?php


namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;


class RoleMiddleware
{
/**
* Handle an incoming request. Expect role(s) as parameter(s), e.g. 'role:admin' or 'role:admin,kasir'
*/
public function handle(Request $request, Closure $next, $roles = null)
{
$user = $request->user();


if (!$user) {
abort(403, 'Unauthorized');
}


if (!$roles) {
return $next($request);
}


$allowed = array_map('trim', explode(',', $roles));


// asumsi kolom role di users menyimpan string atau integer. Sesuaikan logika jika role numeric.
$userRole = $user->role;


// jika user role numeric (0/1) dan allowed berisi kata, kita boleh terjemahkan; contoh: 'admin' => 1, 'kasir' => 2
// Namun supaya generik, user harus menyamakan tipe role. Jika kamu pakai integer, bisa pass 'role:1,2'


if (in_array($userRole, $allowed) || in_array((string)$userRole, $allowed)) {
return $next($request);
}


abort(403, 'Akses ditolak');
}
}