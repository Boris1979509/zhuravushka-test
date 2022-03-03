<?php

namespace App\Http\Controllers\Cabinet;

use App\Http\Controllers\Core;
use App\Http\Requests\Cabinet\ChangePasswordRequest;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ChangePasswordController extends Core
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * ChangePasswordController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * @param CartService $cartService
     * @return Factory|View
     */
    public function index(CartService $cartService)
    {
        $this->data['user'] = Auth::user();
        return view('cabinet.profile.changePassword', $cartService->getCart(), $this->data);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return RedirectResponse
     */
    public function store(ChangePasswordRequest $request)
    {
        Auth::user()->update([
            'password' => Hash::make($request['new_password'])
        ]);
        Auth::logout();
        return redirect()->route('login');
    }
}
