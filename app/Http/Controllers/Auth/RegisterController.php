<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Core;
use App\Http\Requests\Auth\RegisterRequest;
use App\Providers\RouteServiceProvider;
use App\UseCases\Auth\RegisterService;
use App\UseCases\Cart\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Throwable;

class RegisterController extends Core
{

    /**
     * @var array
     */
    protected $data = [];
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * @var RegisterService $service
     */
    private $service;

    public function __construct(RegisterService $service)
    {
        parent::__construct();
        $this->middleware('guest');
        $this->service = $service;
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        if ($this->phoneVerified()) {
            $this->service->register($request);
            $this->service->forget();// Session destroy
            session()->flash('success', __('SuccessfulRegistrationInfo'));
            $this->data = ['url' => route('login')];
        } else {
            $message = ['error' => __('The phone number was not confirmed')];
            $this->data = ['error' => view('flash.index', $message)->render()];
        }
        return response()->json($this->data);
    }

    /**
     * @param CartService $cartService
     * @return View
     */
    public function showRegistrationForm(CartService $cartService): View
    {
        return view('auth.register', $this->data, $cartService->getCart());
    }

    /**
     * Guest users
     * @return bool
     */
    private function phoneVerified(): bool
    {
        return session('verified') && session('phone') ? true : false;
    }
}
