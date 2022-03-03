<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserResource::collection(User::where('role_id', User::ROLE_CLIENT)->orderBy('created_at', 'desc')->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return UserResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'password' => 'min:6|confirmed',

            'title' => 'required',
            'type' => 'required',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
        ]);

        $company = Company::create([
            'title' => $request->input('title'),
            'type' => $request->input('type'),
            "inn" => "234",
            "ogrn" => $request->input('ogrn'),
            "okpo" => $request->input('okpo'),
            "address" => $request->input('address'),
            "oktmo" => $request->input('oktmo'),
            "okved" => $request->input('okved'),
            "pfr" => $request->input('pfr'),
            "rs" => $request->input('rs'),
            "bank" => $request->input('bank'),
            "bank_address" => $request->input('bank_address'),
            "bik" => $request->input('bik'),
            "ks" => $request->input('ks'),
            "phone" => $request->input('company_phone'),
            "mail" => $request->input('mail'),
            "kpp" => $request->input('kpp'),
            'user_id' => $user->id
        ]);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
