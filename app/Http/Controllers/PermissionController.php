<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignPermissionToRoleRequest;
use App\Http\Requests\StorePermissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Permission::class, 'permission');
    }

    /**
    * @OA\Get(
    *     path="/api/permissions",
    *     summary="Рӯйхати иҷозатҳо",
    *     description="Гирифтани ҳамаи иҷозатҳо",
    *     tags={"Permissions"},
    *     security={{"bearerAuth":{}}},
    *
    *     @OA\Response(
    *         response=200,
    *         description="Рӯйхати иҷозатҳо",
    *         @OA\JsonContent(
    *             @OA\Property(
    *                 property="data",
    *                 type="array",
    *                 @OA\Items(
    *                     type="object",
    *                     @OA\Property(property="id", type="integer", example=1),
    *                     @OA\Property(property="name", type="string", example="permission:create"),
    *                     @OA\Property(property="guard_name", type="string", example="web")
    *                 )
    *             )
    *         )
    *     ),
    *
    *     @OA\Response(
    *         response=403,
    *         description="Иҷозат нест"
    *     )
    * )
    */
    public function index()
    {
        return $this->response(Permission::all());
    }

    /**
     * @OA\Post(
     *     path="/api/permissions",
     *     summary="Эҷоди иҷозат",
     *     description="Иҷозати нав месозад",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="permission:create")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Иҷозат сохта шуд",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="permission created"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={"id":1,"name":"permission:create","guard_name":"web"}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Аллакай вуҷуд дорад"
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Иҷозат нест"
     *     )
     * )
     */
    public function store(StorePermissionRequest $request)
    {
        if (Permission::query()->where('name', $request->name)->exists()) {
            return $this->error('persmission already exists');
        }
        $permission = Permission::create(['name' => $request->name, "guard_name" => "web"]);
        return $this->success('permission created', $permission);
    }

    /**
     * @OA\Post(
     *     path="/api/permissions/assign",
     *     summary="Пайваст кардани иҷозат ба роль",
     *     description="Иҷозатро ба роль пайваст мекунад",
     *     tags={"Permissions"},
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"permission_id","role_id"},
     *             @OA\Property(property="permission_id", type="integer", example=1),
     *             @OA\Property(property="role_id", type="integer", example=2)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Муваффақият",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="permission assigned to role")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=400,
     *         description="Аллакай пайваст шудааст"
     *     ),
     *
     *     @OA\Response(
     *         response=403,
     *         description="Иҷозат нест"
     *     )
     * )
     */
    public function assign(AssignPermissionToRoleRequest $request)
    {
        $permission = Permission::findOrFail($request->permission_id);
        $role = Role::findOrFail($request->role_id);

        if ($role->hasPermissionTo($permission->name)){
            return $this->error('permission already assigned');
        }

        $role->givePermissionTo($permission->name);
        return $this->success('permission assigned to role');
    }
}
