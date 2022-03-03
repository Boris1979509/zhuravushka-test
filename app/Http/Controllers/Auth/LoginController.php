<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Core;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LoginController extends Core
{
    use ThrottlesLogins;
    /**
     * @var array
     */
    private $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * @param CartService $cartService
     * @return Factory|View
     */
    public function showLoginForm(CartService $cartService)
    {
        return view('auth.inc.inc-login', $this->data, $cartService->getCart());
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $authenticate = Auth::attempt(
            $request->only(['phone', 'password'])
        // $request->filled('remember')
        );

        if ($authenticate) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            /** Admin or User */
            $home = auth()->user()->isAdmin() ? 'admin.home' : 'cabinet.order';

            if ($request->wantsJson()) {
                session()->flash('success', __('Welcome') . auth()->user()->name);
                $this->data['url'] = route($home);
                return response()->json($this->data);
            }

            return redirect()
                ->intended(route($home))
                ->with('success', __('Welcome') . auth()->user()->name);
        }

        $this->incrementLoginAttempts($request);
        // Неверный логин или пароль
        throw ValidationException::withMessages(['password' => [trans('auth.failed')]]);
    }


    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('home');
    }

    /**
     * @return string
     */
    protected function username(): string
    {
        return 'phone';
    }
}
