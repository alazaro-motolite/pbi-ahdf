<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visitor;
use Carbon\Carbon;

class CountVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $count = Visitor::whereDate('visit_date', '=', Carbon::now()->format('Y-m-d'))->where('ip_address', '=', $request->ip())->count();

        if($count >= 0) :
            Visitor::create([
                'ip_address' => $request->ip(),
                'visit_date' => Carbon::now()
            ]);
        endif;

        return $next($request);
    }
}
