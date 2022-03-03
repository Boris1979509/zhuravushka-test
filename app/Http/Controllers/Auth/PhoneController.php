<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PhoneRequest;
use App\UseCases\Auth\PhoneService;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    /**
     * @var array
     */
    private $data = [];
    /**
     * @var PhoneService
     */
    private $service;

    public function __construct(PhoneService $service)
    {
        $this->service = $service;
    }

    public function request(PhoneRequest $request)
    {
        $phone = $request->input('phone');

        //if (is_null(session('phone'))) {
        //session(['phone' => $phone]);
        //}

        $this->data['resultVerify'] = $this->service->request($phone);
        if ($this->data['resultVerify']['status']) {
            $this->data['view'] = view('auth.phoneVerify', [])->render();
        }
        return response()->json($this->data);

    }

    public function verify(Request $request)
    {
        $this->data = $this->service->verify($request->input('tokenClient'));
        return response()->json($this->data);
    }
}
