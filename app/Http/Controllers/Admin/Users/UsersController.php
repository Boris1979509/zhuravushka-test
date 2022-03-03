<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Core;
use App\Http\Requests\Admin\Users\UpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Users\CreateRequest;
use Illuminate\View\View;

class UsersController extends Core
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $query = $this->userRepository->orderByDesc();
        if (!empty($value = $request->get('id'))) {
            $query->where('id', $value);
        }

        if (!empty($value = $request->get('name'))) {
            $query->where('name', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('email'))) {
            $query->where('email', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('phone'))) {
            $query->where('phone', 'like', '%' . $value . '%');
        }

        if (!empty($value = $request->get('role'))) {
            $query->where('role', $value);
        }

        $users = $query->paginate(20);

        $roles = User::rolesList();

        return view('admin.users.index', compact('users', 'roles'), $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.users.create', $this->data);
    }

    /**
     * @param CreateRequest $request
     * @return RedirectResponse
     */
    public function store(CreateRequest $request): RedirectResponse
    {
        $user = User::new(
            $request['name'],
            $request['email'],
            $request['phone']
        );

        return redirect()->route('admin.users.show', $user);
    }

    /**
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'), $this->data);
    }

    /**
     * @param User $user
     * @return Factory|View
     */
    public function edit(User $user): View
    {
        $roles = User::rolesList();
        return view('admin.users.edit', compact('user', 'roles'), $this->data);
    }

    /**
     * @param UpdateRequest $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, User $user): RedirectResponse
    {
        $result = $user->update($request->only([
            'name',
            'last_name',
            'middle_name',
            'email',
            'phone'
        ]));

        if ($request['role'] !== $user->role) {
            $user->changeRole($request['role']);
        }
        if ($result) {
            return redirect()->route('admin.users.show', $user)->with('success', __('Updated successfully'));
        } else {
            return redirect()->route('admin.users.show', $user)->with('error', __('Update error'));
        }
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
