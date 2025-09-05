<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $bId = $request->user()->business_id;
        $users = User::where('business_id', $bId)->get();
        return response()->json([
            'status' => 'success',
            'users' => UserResource::collection($users)
        ]);
    }
}
