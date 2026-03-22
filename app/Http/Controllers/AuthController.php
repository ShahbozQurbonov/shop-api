<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected FileService $fileService,
    ){}

    /**
     * @throws ValidationException
     * @OA\Post(
     *     path="/api/login",
     *     summary="Воридшавӣ истифода кардан",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=200, description="Воридшавӣ муаффак")
     * )
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        $this->authService->checkCredentials($user, $request);

        return $this->success(
            '',
            ['token' => $user->createToken($request->email)->plainTextToken]
        );
    }


    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Берун рафтан",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="Берун рафтани муаффак")
     * )
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success('user logged out',);
    }


    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Ба қайд гирифтан",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=200, description="Ба қайд гирифтани муаффак")
     * )
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        $user->assignRole('customer');

        $this->fileService->checkUserPhoto($request, $user);

        return $this->success(
            'user created',
            ['token' => $user->createToken($request->email)->plainTextToken]
        );
    }

    /**
     * @OA\Post(
     *     path="/api/change-password",
     *     summary="Пароленро тағйир додан",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=200, description="Пароленро навсозӣ кардани муаффак")
     * )
     */
    public function changePassword()
    {

    }


    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Маълумоти корбари ҷорӣро гирифтан",
     *     tags={"Auth"},
     *     @OA\Response(response=200, description="Муаффак")
     * )
     */
    public function user(Request $request)
    {
        return $this->response(new UserResource($request->user()));
    }

}
