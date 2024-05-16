<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Modules\Auth\Responsible\Models\Responsible;
use \Illuminate\Support\Facades\Hash;
use \Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', function (Request $request) {
    $responsible = Responsible::Where('phone', $request->phone)->where('active', 1)->first();
    if ($responsible && Hash::check($request->password, $responsible->password)) {
//        foreach ($responsible->tokens as $token) {
//            $token->revoke();
//        }
        if ($responsible->role) {
            $objToken = $responsible->createToken('MyApp', [$responsible->role->name]);
        } else {
            $objToken = $responsible->createToken('MyApp', ['mobile']);
        }
        unset($responsible->role);
        $strToken = $objToken->accessToken;
        $expiration = $objToken->token->expires_at->diffInSeconds(Carbon::now());
        $responsible->login_times = $responsible->login_times + 1;
        $responsible->update();
        $responsible->login_times = $responsible->login_times - 1;
        return response()->json(["token_type" => "Bearer", "expires_in" => $expiration, "access_token" => $strToken, 'info' => $responsible], 200);
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }
});

Route::post('user/info', function () {
    $responsible = \Illuminate\Support\Facades\Auth::guard('api')->user();
    if ($responsible && $responsible->active) {
        if ($responsible->role) {
            $objToken = $responsible->createToken('MyApp', [$responsible->role->name]);
        } else {
            $objToken = $responsible->createToken('MyApp', ['mobile']);
        }
        unset($responsible->role);
        $strToken = $objToken->accessToken;
        $expiration = $objToken->token->expires_at->diffInSeconds(Carbon::now());
        $responsible->login_times = $responsible->login_times + 1;
        $responsible->update();
        $responsible->login_times = $responsible->login_times - 1;
        return response()->json(["token_type" => "Bearer", "expires_in" => $expiration, "access_token" => $strToken, 'info' => $responsible], 200);
    } else {
        return response()->json([], 401);
    }
});


Route::post('dashboard/login', function (Request $request) {
    $admin = \App\Modules\Auth\Admin\Models\Admin::Where('email', $request->email)->first();
    if ($admin && Hash::check($request->password, $admin->password)) {
//    foreach ($admin->tokens as $token) {
//      $token->revoke();
//    }
        if ($admin->role) {
            $admin->setAttribute('role_name', $admin->role->name);
            $objToken = $admin->createToken('Admin');
            $admin['abilities'] = $admin->role->permissions->map(function ($item) {
                return [
                    "subject" => $item->name,
                    'action' => 'call'
                ];
            });
        } else {
            $objToken = $admin->createToken('MyApp', ['admin']);
            $admin['abilities'] = [];
        }
        if ($admin->id === 1) {
            $admin['abilities'] = [
                [
                    'subject' => 'all',
                    'action' => 'manage'
                ]
            ];
        }
        if ($admin->id > 1 && $admin->center) {
            $admin['abilities'][] = [
                'subject' => 'STOCK_ALL_PERMISSION',
                'action' => 'call'
            ];
        }
        unset($admin->role);
        $strToken = $objToken->plainTextToken;
        return response()->json(
            [
                'message' => "Welcome $admin->name",
                'data' =>
                    [
                        "token_type" => "Bearer",
                        "token" => $strToken,
                        'user' => $admin
                    ]
            ], 200);
    } else {
        return response()->json(['error' => 'Unauthorized', 'message' => 'Unauthorized', 'data' => null], 401);
    }
});

Route::middleware('auth:sanctum')->post('login-token', function (Request $request) {
    $admin = $request->user();
    $admin = \App\Modules\Auth\Admin\Models\Admin::find($admin->id);
    if ($admin) {
        if ($admin->role) {
            $admin->setAttribute('role_name', $admin->role->name);
            $objToken = $admin->createToken('Admin');
            $admin['abilities'] = $admin->role->permissions->map(function ($item) {
                return [
                    "subject" => $item->name,
                    'action' => 'call'
                ];
            });
        } else {
            $objToken = $admin->createToken('MyApp', ['admin']);
            $admin['abilities'] = [];
        }
        if ($admin->id === 1) {
            $admin['abilities'] = [
                [
                    'subject' => 'all',
                    'action' => 'manage'
                ]
            ];
        }
        if ($admin->id > 1 && $admin->center) {
            $admin['abilities'][] = [
                'subject' => 'STOCK_ALL_PERMISSION',
                'action' => 'call'
            ];
        }
        unset($admin->role);
        $strToken = $objToken->plainTextToken;
        return response()->json(
            [
                'message' => "Welcome back $admin->name",
                'data' =>
                    [
                        "token_type" => "Bearer",
                        "token" => $strToken,
                        'user' => $admin
                    ]
            ], 200);
    } else {
        return response()->json(['error' => 'Unauthorized', 'message' => 'Unauthorized', 'data' => null], 401);
    }
});
