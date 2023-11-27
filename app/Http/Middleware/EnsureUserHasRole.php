<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response; // Use Illuminate\Http\Response instead of Symfony\Component\HttpFoundation\Response

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $position
     * @return \Illuminate\Http\Response  // Use \Illuminate\Http\Response instead of Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $position)
    {
        // Assuming your 'position' column contains the user's position
        $userPosition = $request->user()->position;

        if ($userPosition !== $position) {
            dd(url()->current());
            return redirect('/logout');
        }

        return $next($request);
    }
}
