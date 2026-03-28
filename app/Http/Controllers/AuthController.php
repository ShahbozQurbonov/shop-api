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
    * @OA\Post(
    *     path="/api/login",
    *     summary="Воридшавӣ ба система",
    *     description="Истифодабаранда бо email ва password ворид мешавад",
    *     tags={"Auth"},
    *     
    *     @OA\Parameter(
    *         name="email",
    *         in="query",
    *         required=true,
    *         description="Почтаи электронӣ",
    *         @OA\Schema(type="string", format="email", example="user@gmail.com")
    *     ),
    *     @OA\Parameter(
    *         name="password",
    *         in="query",
    *         required=true,
    *         description="Рамз",
    *         @OA\Schema(type="string", format="password", example="password")
    *     ),
    * 
    *     @OA\Response(
    *         response=200,
    *         description="Воридшавӣ бомуваффақият анҷом ёфт",
    *         @OA\JsonContent(
    *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiN2VlNWM0OTBiZGI2ODkxNmNkNmJiOTUxZGY0NzVhN2NhYjA3MjBmM2RmOGY4ZmQwODJhMWY3OTc1YWI0MDAyMGQxMTFhYTdhYzcyZTkwZWIiLCJpYXQiOjE3NzQ2MDY0MjEuOTIwMDIzLCJuYmYiOjE3NzQ2MDY0MjEuOTIwMDI4LCJleHAiOjE4MDYxNDI0MjEuOTEwMzMzLCJzdWIiOiIxOCIsInNjb3BlcyI6W119.SJrtrc1KcMYGJKH2aIoVZZsgeMJEx1_PBHrCpJ9_XVITrtcnHG-bPoDMO4WVR83nxWi6QdcsQgEiJShF-Pi1UJNHZVOJO9JrgA4KHVAiIeAJfm0gugbyAObwpqwxBCUC_zxqBfUWsjYBqa8QTumraZX2cQ3IvmTXP40IjI8mgBWAlME77RRLIwvJqI4dCs0PnL7u36DDSNCJwHAkPZcYUN7Uyj3Xydms2SdGvJC217tTqemO2GaNeTaMKfNsZ5qDLN5uKNZ5T3v93hpiYovJV54QyVUIm9gItCdCaG2TOJ9yFmB3_9yBGcQvbAAHjRU66nby6NTt6jcCSO69COD0dbnUXn5KvrdnX5m0jRLmrwm0pxN7AprMo5gBnd9RkpmimSoTMuvU5eE8uoNBbDFTbkzPjyIZ6TV84sWGp1vEL1huavMo5MTWjx-eAmLVhepLIqqW2_SOvbhxBEaSTaXfoG-Y9aHAQolkHF6gKwbG4k9f1KsJd5r6CsdWUuiMclUgwr9vpX24oeLRMPq_GtfZE5PNLqwnizbCQDYQVba5Rm9TaQfTc0eC8-i1JnXhPjUoVDp2mN5CePUd_ZzH5jYMA2amVk05lwYFiJu-vzEZlvJNOWaZG0e2CsFhICOiKHk8yjR9HoTeD-LvaZv3LGJGBC3Y5F4Gyu8ch8bxPmCN2P0")
    *         )
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Хатогии валидация"
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Email ё password нодуруст аст"
    *     )
    * )
    */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email ё password нодуруст аст']
            ]);
        }
        $user->tokens()->delete();

        $token = $user->createToken('authToken')->accessToken;

        return $this->success('ok', [
            'token' => $token,
            'user' => new UserResource($user)
        ]);
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Берун рафтан",
     *     description="Нест кардани token-и корбар",
     *     security={{"bearerAuth":{}}},
     *     tags={"Auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Шумо бо муваффақият аз система баромадед"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'Шумо бо муваффақият аз система баромадед'
        ]);
    }
    
    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Ба қайд гирифтан",
     *     description="Эҷод кардани корбари нав",
     *     tags={"Auth"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"first_name","last_name","email","phone","password","password_confirmation"},
     *
     *                 @OA\Property(property="first_name", type="string", example="Ali"),
     *                 @OA\Property(property="last_name", type="string", example="Ahmadov"),
     *                 @OA\Property(property="email", type="string", example="user@gmail.com"),
     *                 @OA\Property(property="phone", type="string", example="+992924002010"),
     *                 @OA\Property(property="password", type="string", example="Password1"),
     *                 @OA\Property(property="password_confirmation", type="string", example="Password1"),
     *
     *                 @OA\Property(
     *                     property="photo",
     *                     type="string",
     *                     format="binary",
     *                     description="Акс (jpg, jpeg, png, max: 1MB)"
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Ба қайд гирифтан муваффақ шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Корбар бо муваффақият сохта шуд"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="token", type="string", example="access_token_here"),
     *                 @OA\Property(property="user", type="object")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Хатогии валидация"
     *     )
     * )
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $user->assignRole('customer');

        $this->fileService->checkUserPhoto($request, $user);

        $token = $user->createToken('authToken')->accessToken;

        return $this->success('user created', [
            'token' => $token,
            'user' => new UserResource($user)
        ]);
    }

    /**
     * @OA\Post(
     *    path="/api/change-password",
     *    summary="Паролро иваз кардан",
     *    description="Тағйир додани пароли корбар",
     *    security={{"bearerAuth":{}}},
     *    tags={"Auth"},
     *
     *    @OA\RequestBody(
     *        required=true,
     *        @OA\JsonContent(
     *            required={"current_password","new_password","new_password_confirmation"},
     *            @OA\Property(property="current_password", type="string", example="Password12"),
     *            @OA\Property(property="new_password", type="string", example="Password123"),
     *            @OA\Property(property="new_password_confirmation", type="string", example="Password123")
     *        )
     *    ),
     *
     *    @OA\Response(
     *        response=200,
     *        description="Парол бомуваффақият иваз шуд"
     *    ),
     *    @OA\Response(response=422, description="Хатогии валидация")
     *)
     */
    public function changePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed|regex:/[A-Z]/|regex:/[0-9]/',
        ]);
        
        $user = $request->user();

        if (!Hash::check($data['current_password'], $user->password)) {
            return $this->error('Пароли ҳозира нодуруст аст.');
        }
        $user->password = Hash::make($data['new_password']);
        $user->save();

        return $this->success('Парол бомуваффақият иваз шуд');
    }


    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Маълумоти корбар",
     *     description="Гирифтани маълумоти корбари ҷорӣ",
     *     tags={"Auth"},
     *    security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Муваффақ",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="first_name", type="string", example="Ali"),
     *             @OA\Property(property="last_name", type="string", example="Ahmadov"),
     *             @OA\Property(property="email", type="string", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function user()
    {
        return $this->response(new UserResource(auth()->user()));
    }

}
