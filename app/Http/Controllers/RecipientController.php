<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipientResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class RecipientController extends Controller
{
    /**
     * Все когда-либо введенные данным юзером получатели
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return RecipientResource::collection(Auth::user()->recipients);
    }

    public function recipientsForUser(User $user)
    {
        return RecipientResource::collection($user->recipients);
    }
}
