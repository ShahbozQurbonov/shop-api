<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use OpenApi\Annotations as OA;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        // $this->authorizeResource(Attribute::class, 'attribute');
    }

    /**
     * @OA\Get(
     *     path="/api/attributes",
     *     summary="Рӯйхати атрибутҳо",
     *     tags={"Attributes"},
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
     *                     @OA\Property(property="name", type="string", example="Color"),
     *                     @OA\Property(
     *                         property="values",
     *                         type="array",
     *                         @OA\Items(type="object")
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return $this->response(
            Attribute::with('values')->get()
        );
    }

    /**
     * @OA\Post(
     *     path="/api/attributes",
     *     summary="Эҷоди атрибут",
     *     tags={"Attributes"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Color")
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Сохта шуд")
     * )
     */
    public function store(StoreAttributeRequest $request)
    {
        $attribute = Attribute::create($request->validated());

        return $this->success('attribute created', $attribute);
    }

    /**
     * @OA\Get(
     *     path="/api/attributes/{id}",
     *     summary="Намоиши атрибут",
     *     tags={"Attributes"},
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
    public function show(Attribute $attribute)
    {
        return $this->response(
            $attribute->load('values')
        );
    }

    /**
     * @OA\Put(
     *     path="/api/attributes/{id}",
     *     summary="Навсозии атрибут",
     *     tags={"Attributes"},
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
     *             @OA\Property(property="name", type="string", example="Size")
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Updated")
     * )
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $attribute->update($request->validated());

        return $this->success('attribute updated', $attribute);
    }

    /**
     * @OA\Delete(
     *     path="/api/attributes/{id}",
     *     summary="Нест кардани атрибут",
     *     tags={"Attributes"},
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
    public function destroy(Attribute $attribute)
    {
        // values-ро ҳам пок кун
        $attribute->values()->delete();

        $attribute->delete();

        return $this->success('attribute deleted');
    }
}
