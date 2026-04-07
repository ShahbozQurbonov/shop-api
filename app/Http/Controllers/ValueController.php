<?php

namespace App\Http\Controllers;

use App\Models\Value;
use App\Http\Requests\StoreValueRequest;
use App\Http\Requests\UpdateValueRequest;

class ValueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        // $this->authorizeResource(Value::class, 'value');
    }

    /**
    * @OA\Get(
    *     path="/api/values",
    *     summary="Рӯйхати valueҳо",
    *     tags={"Values"},
    *
    *     @OA\Response(
    *         response=200,
    *         description="Рӯйхат",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *
    *                 @OA\Items(
    *                     type="object",
    *
    *                     @OA\Property(property="id", type="integer", example=1),
    *
    *                     @OA\Property(
    *                         property="name",
    *                         type="object",
    *                         example={"tj":"Сурх","ru":"Красный","uz":"Qizil"}
    *                     ),
    *
    *                     @OA\Property(property="added_price", type="number", example=1000),
    *
    *                     @OA\Property(
    *                         property="valueable_type",
    *                         type="string",
    *                         example="App\\Models\\Attribute"
    *                     ),
    *
    *                     @OA\Property(property="valueable_id", type="integer", example=1),
    *
    *                     @OA\Property(property="created_at", type="string", example="2026-03-25T06:40:41.000000Z"),
    *                     @OA\Property(property="updated_at", type="string", example="2026-03-25T06:40:41.000000Z")
    *                 )
    *             )
    *         )
    *     )
    * )
    */
    public function index()
    {
        return $this->response(Value::with('valueable')->get());
    }

    /**
     * @OA\Post(
     *     path="/api/values",
     *     summary="Эҷоди value",
     *     tags={"Values"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","valueable_id","valueable_type"},
     *
     *             @OA\Property(
     *                 property="name",
     *                 type="object",
    *                  example={"tj":"Сурх","ru":"Красный","uz":"Qizil"}
     *             ),
     *
     *             @OA\Property(property="valueable_id", type="integer", example=1),
     *
     *             @OA\Property(
     *                 property="valueable_type",
     *                 type="string",
     *                 example="App\\Models\\Attribute"
     *             ),
     *
     *             @OA\Property(property="added_price", type="number", example=1000)
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Created")
     * )
     */
    public function store(StoreValueRequest $request)
    {
        $data = $request->validated();

        $value = Value::create([
            'name' => $data['name'],
            'valueable_id' => $data['valueable_id'],
            'valueable_type' => $data['valueable_type'],
        ]);

        return $this->success('value created', $value);
    }

    /**
     * @OA\Get(
     *     path="/api/values/{id}",
     *     summary="Намоиши value",
     *     tags={"Values"},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response=200, description="OK")
     * )
     */
    public function show(Value $value)
    {
        return $this->response($value->load('valueable'));
    }

    /**
     * @OA\Put(
     *     path="/api/values/{id}",
     *     summary="Навсозии value",
     *     tags={"Values"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="name",
     *                 type="object",
     *                 example={"uz":"Yashil"}
     *             ),
     *             @OA\Property(property="added_price", type="number", example=500)
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function update(UpdateValueRequest $request, Value $value)
    {
        $value->update($request->validated());

        return $this->success('value updated', $value);
    }

    /**
     * @OA\Delete(
     *     path="/api/values/{id}",
     *     summary="Нест кардани value",
     *     tags={"Values"},
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
    public function destroy(Value $value)
    {
        $value->delete();

        return $this->success('value deleted');
    }
}