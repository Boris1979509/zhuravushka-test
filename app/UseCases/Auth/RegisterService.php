<?php

namespace App\UseCases\Auth;

use App\Models\User;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\SuccessfulRegistration;
use App\UseCases\Auth\PhoneService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Mail\Mailer as MailerInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterService
{
    /**
     * @var Mailer $mailer
     */
    private $mailer;
    /**
     * @var Dispatcher $dispatcher
     */
    private $dispatcher;
    /**
     * @var PhoneService $service
     */
    private $service;

    public function __construct(MailerInterface $mailer, Dispatcher $dispatcher, PhoneService $service)
    {
        $this->mailer = $mailer;
        $this->dispatcher = $dispatcher;
        $this->service = $service;
    }

    public function register(RegisterRequest $request): void
    {
        $user = User::register([
            'name'                  => Str::ucfirst($request['name']),
            'last_name'             => $request['last_name'],
            'middle_name'           => $request['middle_name'],
            'email'                 => $request['email'],
            //'phone'              => $this->service->filterPhone(session('phone')),
            'phone'                 => session('phone'),
            'phone_verified_status' => User::STATUS_ACTIVE,
            'phone_verify_token'    => session('token'),
            'password'              => Hash::make($request['password']),
            //'delivery_place'        => $request['address'],
            'role'                  => User::ROLE_USER,
        ]);

        $this->mailer->to($user->email)->send(new SuccessfulRegistration($user));
        $this->dispatcher->dispatch(new Registered($user));
    }

    /**
     * If register by email
     * @param int $id
     */
    public function verify(int $id): void
    {
        /** @var User $user */
        $user = User::findOrFail($id);
        $user->verify();
    }
    /**
     * @return void
     */
    public function forget(): void
    {
        $this->service->forget();
    }
}
