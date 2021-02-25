<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Reference\Reference;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        $emp = User::all();
        if ($emp->isNotEmpty()) {
            foreach ($emp as $t) {
                if ($t->email == $request->email && $t->password == $request->password && $t->status == 1) {
                    session([
                        'name' => $t->name,
                        'user_id' => $t->user_id,
                        'type' => $t->type,
                    ]);
                    if ($t->type == 1) {
                        return redirect()->route('admin');
                    } elseif ($t->type == 2) {
                        return redirect()->route('user');
                    }
                    else {
                        return redirect()->route('login')->with('msg','<div class="alert alert-warning" id="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Sorry! </strong> Something is wrong!
                        </div>');
                    }

                } elseif ($t->email == $request->email && $t->password != $request->password && $t->status == 1) {
                    return redirect()->route('login')->with('msg','<div class="alert alert-warning" id="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Sorry! </strong> Mismatch password!
                        </div>');
                } elseif ((($t->user_id == $request->email) || ($t->email == $request->email)) && $t->password == $request->password && $t->status == 0) {
                    return redirect()->route('login')->with('msg','<div class="alert alert-danger" id="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Sorry! </strong> Your account is disabled!
                        </div>');
                }
            }
            return redirect()->route('login')->with('msg','<div class="alert alert-danger" id="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Sorry! </strong> Your are not an user!
                        </div>');
        } else {
            return redirect()->route('login')->with('msg','<div class="alert alert-danger" id="alert">
                            <button type="button" class="close" data-dismiss="alert">x</button>
                            <strong>Sorry! </strong> Your are not an user!
                        </div>');
        }
    }
}
