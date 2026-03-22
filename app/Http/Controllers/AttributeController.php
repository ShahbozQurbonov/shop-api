<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use OpenApi\Annotations as OA;

class AttributeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/attributes",
     *     summary="Рӯйхати атрибутҳоро гирифтан",
     *     tags={"Attributes"},
     *     @OA\Response(response=200, description="Муаффак")
     * )
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/attributes/create",
     *     summary="Шакли эҷоди атрибутро нишон додан",
     *     tags={"Attributes"},
     *     @OA\Response(response=200, description="Муаффак")
     * )
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/attributes",
     *     summary="Атрибути нав эҷод кардан",
     *     tags={"Attributes"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=201, description="Эҷод шуд")
     * )
     * Store a newly created resource in storage.
     */
    public function store(StoreAttributeRequest $request)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/attributes/{id}",
     *     summary="Атрибути мушаххасро нишон додан",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Муаффак")
     * )
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * @OA\Get(
     *     path="/api/attributes/{id}/edit",
     *     summary="Шакли таҳрири атрибутро нишон додан",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Муаффак")
     * )
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        //
    }

    /**
     * @OA\Put(
     *     path="/api/attributes/{id}",
     *     summary="Атрибути мушаххасро навсозӣ кардан",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(type="object")
     *     ),
     *     @OA\Response(response=200, description="Навсозӣ шуд")
     * )
     * Update the specified resource in storage.
     */
    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/api/attributes/{id}",
     *     summary="Атрибути мушаххасро нест кардан",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Нест шуд")
     * )
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        //
    }
}
