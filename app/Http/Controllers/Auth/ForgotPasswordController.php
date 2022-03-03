<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForgotPasswordController extends Core
{


    use SendsPasswordResetEmails;
    /**
     * @var array
     */
    private $data = [];

    /**
     * ForgotPasswordController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * @return Factory|View
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email', $this->data);
    }

    /**
     * @param Request $request
     * @param $response
     * @return RedirectResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return redirect()->back()->with('success', trans($response));
    }

}
