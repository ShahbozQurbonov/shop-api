<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignRoleToUserRequest;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->authorizeResource(Role::class, 'role');
    }

    /**
     * @OA\Get(
     *     path="/api/roles",
     *     summary="Рӯйхати ролҳо",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Рӯйхати ролҳо"
     *     )
     * )
     */
    public function index()
    {
        return $this->response(Role::all());
    }

     /**
     * @OA\Post(
     *     path="/api/roles",
     *     summary="Эҷоди роль",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="admin")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Роль сохта шуд"
     *     )
     * )
     */
    public function store(StoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        return $this->success('Роль сохта шуд', $role);
    }

    /**
     * @OA\Get(
     *     path="/api/roles/{id}",
     *     summary="Намоиши роль",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Маълумоти роль"
     *     )
     * )
     */
    public function show(Role $role)
    {
        return $this->response($role);
    }

    /**
     * @OA\Put(
     *     path="/api/roles/{id}",
     *     summary="Навсозии роль",
     *     tags={"Roles"},
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
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="manager")
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Роль навсозӣ шуд"
     *     )
     * )
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->update([
            'name' => $request->name
        ]);

        return $this->success('Роль навсозӣ шуд', $role);
    }

    /**
     * @OA\Delete(
     *     path="/api/roles/{id}",
     *     summary="Нест кардани роль",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Роль нест карда шуд"
     *     )
     * )
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return $this->success('Роль нест карда шуд');
    }

    /**
     * @OA\Post(
     *     path="/api/roles/assign",
     *     summary="Таъин кардани роль ба корбар",
     *     tags={"Roles"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","role_id"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="role_id", type="integer", example=1)
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Роль ба корбар дода шуд"
     *     )
     * )
     */
    public function assign(AssignRoleToUserRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        // $user->assignRole($role->name);
        // $user->syncRoles([$role->id]); 
        $user->assignRole($role);
        return $this->success('Роль ба корбар дода шуд');
    }
}
