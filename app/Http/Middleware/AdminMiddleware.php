<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Nếu đã login với quyền admin thì ta sẽ cho qua
		// Ngược lại thì sẽ bắt đăng nhập (/admin/login)
        $check = Auth::guard('admin')->check();
        if($check) {
            return $next($request);
        } else {
            return redirect('/admin/login');
        }
    }
}
