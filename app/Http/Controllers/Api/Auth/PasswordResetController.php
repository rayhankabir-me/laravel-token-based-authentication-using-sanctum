<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkEmailRequest;
use App\Mail\ResetPasswordLink;
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
}
