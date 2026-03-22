<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Рӯйхати корбаронро гирифтан",
     *     @OA\Response(response=200, description="Муаффак")
     * )
     */
    public function index()
    {
        return $this->response(User::all());
    }
}
