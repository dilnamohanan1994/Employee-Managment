<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    //Get all companies
    public function getUserDetails()
    {
        $company = Company::orderBy('created_at', 'DESC')->paginate(10);

        return response()->json([
            'message' => 'success',
            'data' => $company
        ], 201);
    }
}
