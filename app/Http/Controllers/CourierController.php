<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourierResource;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        return CourierResource::collection(Courier::orderByDesc('created_at')->get());
    }

    public function show(Courier $courier)
    {
        return new CourierResource($courier);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:couriers,phone',
            'comment' => 'nullable'
        ]);

        $courier = Courier::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'comment' => $request->input('comment'),
        ]);

        return new CourierResource($courier);
    }

    public function update(Request $request, Courier $courier)
    {
        $request->validate([
            'name' => 'required',
            'phone' => [
                'required',
                Rule::unique('couriers')->ignore($courier->id),
            ],
            'comment' => 'nullable'
        ]);

        $courier->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'comment' => $request->input('comment'),
        ]);

        return new CourierResource($courier);
    }

    public function destroy(Courier $courier)
    {
        return $courier->delete();
    }
}
