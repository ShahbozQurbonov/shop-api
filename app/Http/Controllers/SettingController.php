<?php

namespace App\Http\Controllers;

use App\Http\Resources\SettingResource;
use App\Models\Setting;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     path="/api/settings",
     *     summary="Рӯйхати танзимотҳо",
     *     tags={"Settings"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function index()
    {
        return $this->response(
            SettingResource::collection(
                Setting::with('values')->get()
            )
        );
    }

    /**
     * @OA\Post(
     *     path="/api/settings",
     *     summary="Эҷоди танзимот",
     *     tags={"Settings"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","type"},
     *             @OA\Property(
     *                 property="name",
     *                 type="object",
     *                 example={"tj":"Забон","ru":"Язык","uz":"Til"}
     *             ),
     *             @OA\Property(property="type", type="string", example="select"),
     *             @OA\Property(
     *                 property="values",
     *                 type="array",
     *                 @OA\Items(type="object",
     *                     @OA\Property(
     *                         property="name",
     *                         type="object",
     *                         example={"tj":"Тоҷикӣ","ru":"Таджикский","uz":"Tojikcha"}
     *                     ),
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Сохта шуд")
     * )
     */
    public function store(StoreSettingRequest $request)
    {
        $data = $request->validated();

        $setting = Setting::create([
            'name' => $data['name'],
            'type' => $data['type'],
        ]);

        // агар select бошад → values соз
        if ($data['type'] === 'select' && !empty($data['values'])) {
            foreach ($data['values'] as $value) {
                $setting->values()->create([
                    'name' => $value['name']
                ]);
            }
        }

        return $this->success('setting created', $setting->load('values'));
    }

    /**
     * @OA\Get(
     *     path="/api/settings/{id}",
     *     summary="Намоиши танзимот",
     *     tags={"Settings"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID танзимот",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="object")
     *         )
     *     )
     * )
     */
    public function show(Setting $setting)
    {
        return $this->response($setting->load('values'));
    }

    /**
     * @OA\Put(
     *     path="/api/settings/{id}",
     *     summary="Навсозии танзимот",
     *     tags={"Settings"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID танзимот",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="name",
     *                 type="object",
     *                 example={"tj":"Забон","ru":"Язык","uz":"Til"}
     *             ),
     *             @OA\Property(property="type", type="string", example="select")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Навсозӣ шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="setting updated")
     *         )
     *     )
     * )
     */
    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $data = $request->validated();

        $setting->update([
            'name' => $data['name'] ?? $setting->name,
            'type' => $data['type'] ?? $setting->type,
        ]);

        return $this->success('setting updated', $setting->load('values'));
    }

    /**
     * @OA\Delete(
     *     path="/api/settings/{id}",
     *     summary="Нест кардани танзимот",
     *     tags={"Settings"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID танзимот",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Нест шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="setting deleted")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Ёфт нашуд"
     *     )
     * )
     */
    public function destroy(Setting $setting)
    {
        $setting->values()->delete(); // cascade manually
        $setting->delete();

        return $this->success('setting deleted');
    }
}
