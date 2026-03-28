<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserSettingResource;
use App\Models\UserSetting;
use App\Http\Requests\StoreUserSettingRequest;
use App\Http\Requests\UpdateUserSettingRequest;

class UserSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(UserSetting::class, 'user_setting');
    }

    /**
    * @OA\Get(
    *     path="/api/user-settings",
    *     summary="Танзимоти корбар",
    *     description="Гирифтани ҳамаи танзимоти корбари авторизатсияшуда",
    *     tags={"User Settings"},
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
    *
    *                     @OA\Property(
    *                         property="setting",
    *                         type="object",
    *                         example={"id":1,"name":{"tj":"Забон","ru":"Язык","uz":"Til"},"type":"select"}
    *                     ),
    *
    *                     @OA\Property(
    *                         property="value",
    *                         type="object",
    *                         nullable=true,
    *                         example={"id":1,"name":{"tj":"Тоҷикӣ","ru":"Таджикский","uz":"Tojik"}}
    *                     ),
    *
    *                     @OA\Property(property="switch", type="boolean", example=true)
    *                 )
    *             )
    *         )
    *     )
    * )
    */
    public function index()
    {
        return $this->response(UserSettingResource::collection(auth()->user()->settings));
    }

    /**
     * @OA\Post(
     *     path="/api/user-settings",
     *     summary="Эҷоди танзимоти корбар",
     *     tags={"User Settings"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"setting_id"},
     *             @OA\Property(property="setting_id", type="integer", example=1),
     *             @OA\Property(property="value_id", type="integer", example=2),
     *             @OA\Property(property="switch", type="boolean", example=true)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Сохта шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Танзимоти корбар бо муваффақият сохта шуд"),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Аллакай вуҷуд дорад"
     *     )
     * )
     */
    public function store(StoreUserSettingRequest $request)
    {
        if (auth()->user()->settings()->where('setting_id', $request->setting_id)->exists()){
            return $this->error('setting already exists');
        }

        $userSetting = auth()->user()->settings()->create([
            'setting_id' => $request->setting_id,
            'value_id' => $request->value_id ?? null,
            'switch' => $request->switch ?? null,
        ]);

        return $this->success('user setting created', $userSetting);
    }

    /**
     * @OA\Put(
     *     path="/api/user-settings/{id}",
     *     summary="Навсозии танзимот",
     *     tags={"User Settings"},
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
     *             @OA\Property(property="value_id", type="integer", example=2),
     *             @OA\Property(property="switch", type="boolean", example=false)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Навсозӣ шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Танзимоти корбар бо муваффақият навсозӣ шуд")
     *         )
     *     )
     * )
     */
    public function update(UpdateUserSettingRequest $request, UserSetting $userSetting)
    {
        $userSetting->update([
            'switch' => $request->switch ?? null,
            'value_id' => $request->value_id ?? null,
        ]);

        return $this->success('user setting updated');
    }

    /**
     * @OA\Delete(
     *     path="/api/user-settings/{id}",
     *     summary="Нест кардани танзимот",
     *     tags={"User Settings"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Нест шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Танзимоти корбар бо муваффақият нест карда шуд")
     *         )
     *     )
     * )
     */
    public function destroy(UserSetting $userSetting)
    {
        $userSetting->delete();

        return $this->success('user setting deleted');
    }
}
