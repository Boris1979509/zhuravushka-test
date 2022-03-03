<?php


namespace App\Http\Controllers\Cabinet;


use App\Http\Controllers\Core;
use App\Http\Requests\Cabinet\FeedbackRequest;
use App\Models\Feedback;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FeedbackController extends Core
{
    /**
     * @var array
     */
    protected $data = [];

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
        return view('cabinet.feedback.index', $this->data, $cartService->getCart());
    }

    /**
     * @param FeedbackRequest $request
     * @return RedirectResponse
     */
    public function send(FeedbackRequest $request)
    {
        $user_id = Auth::id();
        Feedback::newMessage(
            $request['subject'],
            $request['message'],
            $user_id
        );
        return redirect()->back()->with('success', __('MessageSuccessfullySend'));
    }
}
