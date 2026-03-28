<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Рӯйхати корбаронро гирифтан",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="Муваффак")
     * )
     */
    public function index()
    {
        return $this->response(UserResource::collection(User::all()));
    }
}
