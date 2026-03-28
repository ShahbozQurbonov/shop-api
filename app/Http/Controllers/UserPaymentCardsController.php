<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserPaymentCardResource;
use App\Models\UserPaymentCards;
use App\Http\Requests\StoreUserPaymentCardsRequest;
use App\Http\Requests\UpdateUserPaymentCardsRequest;
use App\Repositories\PaymentCardRepository;
use Illuminate\Support\Facades\Crypt;

class UserPaymentCardsController extends Controller
{
    public function __construct(
        protected PaymentCardRepository $cardRepository
    )
    {
        $this->middleware('auth:api');
    }

    /**
    * @OA\Get(
    *     path="/api/user-payment-cards",
    *     summary="Рӯйхати кортҳои пардохт",
    *     tags={"User Payment Cards"},
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
    *                     @OA\Property(property="name", type="string", example="Visa"),
    *                     @OA\Property(property="number", type="string", example="************1234"),
    *                     @OA\Property(
    *                         property="card_type",
    *                         type="object",
    *                         example={"id":1,"name":"Visa"}
    *                     )
    *                 )
    *             )
    *         )
    *     )
    * )
    */
    public function index()
    {
        return $this->response(UserPaymentCardResource::collection(auth()->user()->paymentCards));
    }

    /**
     * @OA\Post(
     *     path="/api/user-payment-cards",
     *     summary="Илова кардани корти пардохт",
     *     tags={"User Payment Cards"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","number","exp_date","holder_name","payment_card_type_id"},
     *
     *             @OA\Property(property="name", type="string", example="My card"),
     *             @OA\Property(property="number", type="string", example="8600123412341234"),
     *             @OA\Property(property="exp_date", type="string", example="12/27"),
     *             @OA\Property(property="holder_name", type="string", example="ALI VALI"),
     *             @OA\Property(property="payment_card_type_id", type="integer", example=1)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Илова шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="card added")
     *         )
     *     )
     * )
     */
    public function store(StoreUserPaymentCardsRequest $request)
    {
        $this->cardRepository->savePaymentCard($request);

        return $this->success('card added');
    }

    /**
     * @OA\Get(
     *     path="/api/user-payment-cards/{id}",
     *     summary="Намоиши корт",
     *     tags={"User Payment Cards"},
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
    public function show(UserPaymentCards $user_payment_card)
    {

        if ($user_payment_card->user_id !== auth()->id()) {
            return $this->error('Unauthorized');
        }

        return $this->response(new UserPaymentCardResource($user_payment_card));
    }

    /**
     * @OA\Delete(
     *     path="/api/user-payment-cards/{id}",
     *     summary="Нест кардани корт",
     *     tags={"User Payment Cards"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response=200, description="Deleted")
     * )
     */
    public function destroy(UserPaymentCards $user_payment_card)
    {
        if ($user_payment_card->user_id !== auth()->id()) {
            return $this->error('Unauthorized');
        }

        $user_payment_card->delete();

        return $this->success('card deleted');
    }
}
