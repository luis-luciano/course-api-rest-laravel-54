<?php

namespace App\Services;

use App\User as UserModel;
use Illuminate\Support\Facades\Mail;

class User
{
    public function sendEmail(UserModel $user, $mailable)
    {
        retry(5, function () use ($user, $mailable) {
            Mail::to($user->email)->send(new $mailable($user));
        }, 100);
    }
}
