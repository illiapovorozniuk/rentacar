<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Brand\BulkDestroyBrand;
use App\Http\Requests\Admin\Brand\DestroyBrand;
use App\Http\Requests\Admin\Brand\IndexBrand;
use App\Http\Requests\Admin\Brand\StoreBrand;
use App\Http\Requests\Admin\Brand\UpdateBrand;
use App\Models\Brand;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BrandsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/brands",
     *     summary="List all brands",
     *     tags={"Brands"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Optional search filter",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of brands",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="BMW"),
     *                 @OA\Property(property="icon", type="string", example="bmw.svg")
     *             ))
     *         )
     *     )
     * )
     */
    public function index(IndexBrand $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Brand::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'icon'],

            // set columns to searchIn
            ['id', 'slug', 'name', 'icon']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.brand.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.brand.create');

        return view('admin.brand.create');
    }

    /**
     * @OA\Post(
     *     path="/admin/brands",
     *     summary="Create a new brand",
     *     tags={"Brands"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name", "slug", "icon"},
     *                 @OA\Property(property="name", type="string", example="Toyota"),
     *                 @OA\Property(property="slug", type="string", example="toyota"),
     *                 @OA\Property(property="icon", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Brand successfully created"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed"
     *     )
     * )
     */
    public function store(StoreBrand $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $sanitized['icon'] = saveOrUpdateImage($file, 'images/brands', $sanitized['slug']);
        }
        // Store the Brand
        $brand = Brand::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/brands'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/brands');
    }

    /**
     * Display the specified resource.
     *
     * @param Brand $brand
     * @return void
     * @throws AuthorizationException
     */
    public function show(Brand $brand)
    {
        $this->authorize('admin.brand.show', $brand);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Brand $brand
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Brand $brand)
    {
        $this->authorize('admin.brand.edit', $brand);


        return view('admin.brand.edit', [
            'brand' => $brand,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/admin/brands/{id}",
     *     summary="Update an existing brand",
     *     tags={"Brands"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Brand ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="Audi"),
     *                 @OA\Property(property="slug", type="string", example="audi"),
     *                 @OA\Property(property="icon", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Brand successfully updated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Brand not found"
     *     )
     * )
     */
    public function update(UpdateBrand $request, Brand $brand)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        if ($request->hasFile('icon')) {
            $file = $request->file('icon');
            $sanitized['icon'] = saveOrUpdateImage($file, 'images/brands', $sanitized['slug'], 'update', $brand->icon);
        }

        // Update changed values Brand
        $brand->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/brands'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/brands');
    }

    /**
     * @OA\Delete(
     *     path="/admin/brands/{id}",
     *     summary="Delete a brand",
     *     tags={"Brands"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Brand ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Brand deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Brand not found"
     *     )
     * )
     */

    public function destroy(DestroyBrand $request, Brand $brand)
    {
        deleteImage($brand->icon);
        $brand->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * @OA\Post(
     *     path="/admin/brands/bulk-destroy",
     *     summary="Bulk delete brands",
     *     tags={"Brands"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="ids", type="array", @OA\Items(type="integer", example=1))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Brands deleted"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input"
     *     )
     * )
     */
    public function bulkDestroy(BulkDestroyBrand $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Brand::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
