<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BodyType\BulkDestroyBodyType;
use App\Http\Requests\Admin\BodyType\DestroyBodyType;
use App\Http\Requests\Admin\BodyType\IndexBodyType;
use App\Http\Requests\Admin\BodyType\StoreBodyType;
use App\Http\Requests\Admin\BodyType\UpdateBodyType;
use App\Models\BodyType;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BodyTypesController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/body-types",
     *     summary="Get a list of body types",
     *     tags={"Body Types"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search string",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of body types",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="SUV"),
     *                 @OA\Property(property="icon", type="string", example="suv.svg")
     *             ))
     *         )
     *     )
     * )
     */
    public function index(IndexBodyType $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(BodyType::class)->processRequestAndGet(
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

        return view('admin.body-type.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.body-type.create');

        return view('admin.body-type.create');
    }

    /**
     * @OA\Post(
     *     path="/admin/body-types",
     *     summary="Create a new body type",
     *     tags={"Body Types"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "icon"},
     *             @OA\Property(property="name", type="string", example="Sedan"),
     *             @OA\Property(property="icon", type="string", example="sedan.svg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Body type created"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed"
     *     )
     * )
     */
    public function store(StoreBodyType $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the BodyType
        $bodyType = BodyType::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/body-types'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/body-types');
    }

    /**
     * Display the specified resource.
     *
     * @param BodyType $bodyType
     * @throws AuthorizationException
     * @return void
     */
    public function show(BodyType $bodyType)
    {
        $this->authorize('admin.body-type.show', $bodyType);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param BodyType $bodyType
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(BodyType $bodyType)
    {
        $this->authorize('admin.body-type.edit', $bodyType);


        return view('admin.body-type.edit', [
            'bodyType' => $bodyType,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/admin/body-types/{id}",
     *     summary="Update a body type",
     *     tags={"Body Types"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Body type ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Coupe"),
     *             @OA\Property(property="icon", type="string", example="coupe.svg")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Body type updated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Body type not found"
     *     )
     * )
     */

    public function update(UpdateBodyType $request, BodyType $bodyType)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values BodyType
        $bodyType->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/body-types'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/body-types');
    }

    /**
     * @OA\Delete(
     *     path="/admin/body-types/{id}",
     *     summary="Delete a body type",
     *     tags={"Body Types"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Body type ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Body type deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Body type not found"
     *     )
     * )
     */
    public function destroy(DestroyBodyType $request, BodyType $bodyType)
    {
        $bodyType->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * @OA\Post(
     *     path="/admin/body-types/bulk-destroy",
     *     summary="Bulk delete body types",
     *     tags={"Body Types"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="ids",
     *                 type="array",
     *                 @OA\Items(type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Body types deleted"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid input"
     *     )
     * )
     */
    public function bulkDestroy(BulkDestroyBodyType $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    BodyType::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
