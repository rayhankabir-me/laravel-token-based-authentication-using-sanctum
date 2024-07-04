<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\ResisterRequest;
use App\Mail\ResetPasswordLink;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function sendResetLinkEmail(LinkEmailRequest $request)
    {

        $url = URL::temporarySignedRoute('password.reset', Carbon::now()->addMinutes(30), ['email' => $request->email]);

        $appUrl = env('APP_URL');
        $frontendUrl = env('FRONTEND_URL');
        $new_url = str_replace($appUrl, $frontendUrl, $url);


        \Mail::to($request->email)->send(new ResetPasswordLink($new_url));

        return response()->json([
            'message' => 'Email has been sent, please check your mail',
        ]);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!$user)
        {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'Password reset successfull'
        ], 200);

    }
}
