<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

     /**
     * @OA\Get(
     *     path="/api/statuses",
     *     summary="Рӯйхати статусҳо",
     *     tags={"Statuses"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="for",
     *         in="query",
     *         description="Филтр (order ва ғайра)",
     *         required=false,
     *         @OA\Schema(type="string", example="order")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Status::query();

        if ($request->filled('for')) {
            $query->where('for', $request->for);
        }

        return $this->response($query->get());
    }

    /**
     * @OA\Post(
     *     path="/api/statuses",
     *     summary="Эҷоди статус",
     *     tags={"Statuses"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","for"},
     *             @OA\Property(
     *                 property="name",
     *                 type="object",
     *                 example={"tj":"Нав","ru":"Новый","uz":"Yangi"}
     *             ),
     *             @OA\Property(property="for", type="string", example="order"),
     *             @OA\Property(property="code", type="string", example="new")
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Сохта шуд")
     * )
     */
    public function store(StoreStatusRequest $request)
    {
        $status = Status::create($request->validated());

        return $this->success('status created', $status);
    }

    /**
     * @OA\Get(
     *     path="/api/statuses/{id}",
     *     summary="Намоиши статус",
     *     tags={"Statuses"},
     *     security={{"bearerAuth":{}}},
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
    public function show(Status $status)
    {
        return $this->response($status);
    }

    /**
     * @OA\Put(
     *     path="/api/statuses/{id}",
     *     summary="Навсозии статус",
     *     tags={"Statuses"},
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
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="name",
     *                 type="object",
     *                 example={"tj":"Нав","ru":"Новый","uz":"Yangi"}
     *             ),
     *             @OA\Property(property="for", type="string", example="order"),
     *             @OA\Property(property="code", type="string", example="new")
     *         )
     *     ),
     *
     *     @OA\Response(response=200, description="Навсозӣ шуд")
     * )
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        $status->update($request->validated());

        return $this->success('status updated', $status);
    }

    /**
     * @OA\Delete(
     *     path="/api/statuses/{id}",
     *     summary="Нест кардани статус",
     *     tags={"Statuses"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(response=200, description="Нест шуд")
     * )
     */
    public function destroy(Status $status)
    {
        $status->delete();

        return $this->success('status deleted');
    }
}
