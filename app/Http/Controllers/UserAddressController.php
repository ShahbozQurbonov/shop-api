<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Http\Requests\StoreUserAddressRequest;
use App\Http\Requests\UpdateUserAddressRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;

class UserAddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     path="/api/user-addresses",
     *     summary="Рӯйхати суроғаҳои корбар",
     *     tags={"User Addresses"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Рӯйхат",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="latitude", type="string", example="38.56"),
     *                     @OA\Property(property="longitude", type="string", example="68.78"),
     *                     @OA\Property(property="region", type="string", example="Dushanbe"),
     *                     @OA\Property(property="district", type="string", example="Sino"),
     *                     @OA\Property(property="street", type="string", example="Rudaki"),
     *                     @OA\Property(property="home", type="string", example="12A")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return $this->response(auth()->user()->addresses);
    }

    /**
     * @OA\Post(
     *     path="/api/user-addresses",
     *     summary="Эҷоди суроға",
     *     tags={"User Addresses"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"latitude","longitude","region","district","street"},
     *             @OA\Property(property="latitude", type="string", example="38.56"),
     *             @OA\Property(property="longitude", type="string", example="68.78"),
     *             @OA\Property(property="region", type="string", example="Dushanbe"),
     *             @OA\Property(property="district", type="string", example="Sino"),
     *             @OA\Property(property="street", type="string", example="Rudaki"),
     *             @OA\Property(property="home", type="string", example="12A")
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Сохта шуд")
     * )
     */
    public function store(StoreUserAddressRequest $request): JsonResponse
    {
        $address = auth()->user()->addresses()->create($request->toArray());

        return $this->success('shipping address created', $address);
    }

    /**
     * @OA\Get(
     *     path="/api/user-addresses/{id}",
     *     summary="Намоиши суроға",
     *     tags={"User Addresses"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function show(UserAddress $userAddress)
    {
        if ($userAddress->user_id !== auth()->id()) {
            return $this->error('Unauthorized');
        }

        return $this->response($userAddress);
    }

    /**
     * @OA\Put(
     *     path="/api/user-addresses/{id}",
     *     summary="Навсозии суроға",
     *     tags={"User Addresses"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="latitude", type="string"),
     *             @OA\Property(property="longitude", type="string"),
     *             @OA\Property(property="region", type="string"),
     *             @OA\Property(property="district", type="string"),
     *             @OA\Property(property="street", type="string"),
     *             @OA\Property(property="home", type="string")
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Навсозӣ шуд")
     * )
     */
    public function update(UpdateUserAddressRequest $request, UserAddress $userAddress)
    {
        if ($userAddress->user_id !== auth()->id()) {
            return $this->error('Unauthorized');
        }

        $userAddress->update($request->validated());

        return $this->success('address updated', $userAddress);
    }

    /**
     * @OA\Delete(
     *     path="/api/user-addresses/{id}",
     *     summary="Нест кардани суроға",
     *     tags={"User Addresses"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(response=200, description="Нест шуд")
     * )
     */
    public function destroy(UserAddress $userAddress)
    {
        if ($userAddress->user_id !== auth()->id()) {
            return $this->error('Unauthorized');
        }

        $userAddress->delete();

        return $this->success('address deleted');
    }
}
