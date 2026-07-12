<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ImageQuotaMiddleware
{
    /**
     * Block the request if the authenticated user has created more than
     * 10 posts in the last hour, returning a 429 (Too Many Requests).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user) {
            $recentPosts = $user->posts()
                ->where('created_at', '>=', now()->subHour())
                ->count();

            if ($recentPosts > 10) {
                return response('Post limit reached. You can create at most 10 posts per hour.', 429);
            }
        }

        return $next($request);
    }
}
