<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'type' => ['required', Rule::in(['ooo', 'ip']),]
        ]);

        $data = array_merge($request->all(), ['user_id' => Auth::user()->id]);

        $company = Company::create($data);

        return new CompanyResource($company);
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'type' => ['required', Rule::in(['ooo', 'ip']),]
        ]);

        $company = tap($company)->update($request->all());

        return new CompanyResource($company);
    }
}
