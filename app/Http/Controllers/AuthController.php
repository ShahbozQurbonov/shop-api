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
    *         @OA\Schema(type="string", format="email", example="user@example.com")
    *     ),
    *     @OA\Parameter(
    *         name="password",
    *         in="query",
    *         required=true,
    *         description="Рамз",
    *         @OA\Schema(type="string", format="password", example="12345678")
    *     ),
    * 
    *     @OA\Response(
    *         response=200,
    *         description="Воридшавӣ бомуваффақият анҷом ёфт",
    *         @OA\JsonContent(
    *             @OA\Property(property="token", type="string", example="1|abcdefg123456")
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
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user->tokens()->delete();

        $token = $user->createToken('authToken')->accessToken;

        return $this->success('ok', [
            'token' => $token
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
     *         description="Берун рафтани муваффақ"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function logout()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user->token()->revoke();

        return $this->success('user logged out');
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Ба қайд гирифтан",
     *     description="Эҷод кардани корбари нав",
     *     tags={"Auth"},
     * 
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         required=true,
     *         description="Ном",
     *         @OA\Schema(type="string", example="Ali")
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         required=true,
     *         description="Насаб",
     *         @OA\Schema(type="string", example="Ahmadov")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         description="Почтаи электронӣ",
     *         @OA\Schema(type="string", format="email", example="user@example.com")
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         required=true,
     *         description="Рақами телефон",
     *         @OA\Schema(type="string", example="+992900000000")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         required=true,
     *         description="Рамз",
     *         @OA\Schema(type="string", example="12345678")
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         required=true,
     *         description="Тасдиқи рамз",
     *         @OA\Schema(type="string", example="12345678")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Ба қайд гирифтан муваффақ шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|abcdefg123456")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Хатогии валидация")
     * )
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);

        $user = User::create($data);
        $user->assignRole('customer');

        $this->fileService->checkUserPhoto($request, $user);

        $token = $user->createToken('authToken')->accessToken;

        return $this->success('user created', [
            'token' => $token
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/change-password",
     *     summary="Паролро иваз кардан",
     *     description="Тағйир додани пароли корбар",
     *     tags={"Auth"},
     * 
     *     @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         description="Bearer token",
     *         @OA\Schema(type="string", example="Bearer 1|abcdefg123456")
     *     ),
     * 
     *     @OA\Parameter(
     *         name="current_password",
     *         in="query",
     *         required=true,
     *         description="Пароли ҳозира",
     *         @OA\Schema(type="string", example="12345678")
     *     ),
     *     @OA\Parameter(
     *         name="new_password",
     *         in="query",
     *         required=true,
     *         description="Пароли нав",
     *         @OA\Schema(type="string", example="87654321")
     *     ),
     *     @OA\Parameter(
     *         name="new_password_confirmation",
     *         in="query",
     *         required=true,
     *         description="Тасдиқи пароли нав",
     *         @OA\Schema(type="string", example="87654321")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Парол бомуваффақият иваз шуд"
     *     ),
     *     @OA\Response(response=422, description="Хатогии валидация")
     * )
     */
    public function changePassword()
    {
        $data = request()->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['Пароли ҳозира нодуруст аст.'],
            ]);
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
