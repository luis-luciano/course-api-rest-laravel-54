<?php

namespace App\Observers;

use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use App\Services\User as UserService;
use App\User as UserModel;

class User
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function created(UserModel $user)
    {
        $this->userService->sendEmail($user, UserCreated::class);
    }

    public function updating(UserModel $user)
    {
        if ($user->email_changed) {
            $user->generateVerificationToken();
        }
    }

    public function updated(UserModel $user)
    {
        if ($user->email_changed) {
            $this->userService->sendEmail($user, UserMailChanged::class);
        }
    }
}
