<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Http\Requests\StorePhotoRequest;
use App\Http\Requests\UpdatePhotoRequest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use OpenApi\Annotations as OA;

class PhotoController extends Controller
{
        public function __construct()
        {
            $this->middleware('auth:api');
            $this->authorizeResource(Photo::class, 'photo');
        }
    /**
     * @OA\Get(
     *     path="/api/photos",
     *     summary="Рӯйхати аксҳо",
     *     tags={"Photos"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Рӯйхати аксҳо"
     *     )
     * )
     */
    public function index()
    {
        return $this->response(Photo::latest()->get());
    }


    /**
     * @OA\Post(
     *     path="/api/photos",
     *     summary="Илова кардани акс",
     *     tags={"Photos"},
     *     security={{"bearerAuth":{}}},
     * 
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"photo","photoable_id","photoable_type"},
     *                 @OA\Property(property="photo", type="string", format="binary"),
     *                 @OA\Property(property="photoable_id", type="integer", example=1),
     *                 @OA\Property(
     *                     property="photoable_type",
     *                     type="string",
     *                     enum={"product","user"},
     *                     example="product"
     *                 )
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Акс илова шуд"
     *     )
     * )
     */
    public function store(StorePhotoRequest $request)
    {
        $typeMap = [
            'product' => Product::class,
            'user' => User::class,
        ];

        if (!isset($typeMap[$request->photoable_type])) {
            return response()->json([
                'message' => 'Invalid photoable_type'
            ], 422);
        }

        $photoableType = $typeMap[$request->photoable_type];

        // ❗ check model exists
        $photoable = $photoableType::find($request->photoable_id);

        if (!$photoable) {
            return $this->error('Маълумоти дархостшуда ёфт нашуд', 404);
    }

        // 📸 upload file
        $file = $request->file('photo');
        $path = $file->store('photos', 'public');

        // 💾 save
        $photo = Photo::create([
            'full_name' => $file->getClientOriginalName(),
            'path' => $path,
            'photoable_id' => $photoable->id,
            'photoable_type' => $photoableType,
        ]);

        return $this->success('Акс бо муваффақият илова шуд', $photo);
    }

    /**
     * @OA\Get(
     *     path="/api/photos/{id}",
     *     summary="Намоиши акс",
     *     tags={"Photos"},
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
     *         description="Маълумоти акс"
     *     )
     * )
     */
    public function show(Photo $photo)
    {
        return $this->response($photo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/photos/{id}",
     *     summary="Навсозии акс",
     *     tags={"Photos"},
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
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"_method","photo"},
     *                 @OA\Property(property="_method", type="string", example="PUT"),
     *                 @OA\Property(property="photo", type="string", format="binary")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Акс навсозӣ шуд"
     *     )
     * )
     */
    public function update(UpdatePhotoRequest $request, Photo $photo)
    {
        if ($request->hasFile('photo')) {
            Storage::delete($photo->path);

            $file = $request->file('photo');
            $path = $file->store('photos', 'public');

            $photo->update([
                'full_name' => $file->getClientOriginalName(),
                'path' => $path,
            ]);
        }

        return $this->success('Акс навсозӣ шуд', $photo);
    }

    /**
     * @OA\Delete(
     *     path="/api/photos/{id}",
     *     summary="Нест кардани акс",
     *     tags={"Photos"},
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
     *         description="Акс нест карда шуд"
     *     )
     * )
     */
    public function destroy(Photo $photo)
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return $this->success('Акс нест карда шуд');
    }
}
