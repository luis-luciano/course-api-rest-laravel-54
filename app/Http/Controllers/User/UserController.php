<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Mail\UserCreated;
use App\Services\User as UserService;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends ApiController
{

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->seeAll($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::createDefault($request->all());

        return $this->showOne($user, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->all());

        return $this->showOne($user, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return $this->showOne($user);
    }

    /**
     * [verify description]
     * @param  String $token
     * @return [type]        [description]
     */
    public function verify($token)
    {
        $user = User::where('verification_token', $token)
            ->where('verified', false)->firstOrFail();

        // Update to avoid unnecessary verification
        $user->verified = true;
        $user->verification_token = null;
        $user->save();

        return $this->successResponse(['message' => 'Verificado con exito']);
    }

    public function resend(User $user)
    {
        $this->authorize('verify', $user);

        $user->generateVerificationToken();

        if (!$user->verified) {
            $user->save();
        }

        $this->userService->sendEmail($user, UserCreated::class);

        return $this->successResponse(['message' => 'El correo de verificacion se envió con exito.']);
    }
}
