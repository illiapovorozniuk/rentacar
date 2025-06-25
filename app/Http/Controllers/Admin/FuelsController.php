<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Fuel\BulkDestroyFuel;
use App\Http\Requests\Admin\Fuel\DestroyFuel;
use App\Http\Requests\Admin\Fuel\IndexFuel;
use App\Http\Requests\Admin\Fuel\StoreFuel;
use App\Http\Requests\Admin\Fuel\UpdateFuel;
use App\Models\Fuel;
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

class FuelsController extends Controller
{

    /**
     * Method: index
     * @OA\Get(
     *     path="/admin/fuels",
     *     summary="Get list of fuels",
     *     tags={"Fuels"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of fuels",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Diesel")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(IndexFuel $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Fuel::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

            // set columns to searchIn
            ['id', 'slug', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.fuel.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.fuel.create');

        return view('admin.fuel.create');
    }

    /**
     * Method: store
     * @OA\Post(
     *     path="/admin/fuels",
     *     summary="Create a new fuel",
     *     tags={"Fuels"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Diesel")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Fuel created successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(StoreFuel $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Fuel
        $fuel = Fuel::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/fuels'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/fuels');
    }

    /**
     * Display the specified resource.
     *
     * @param Fuel $fuel
     * @throws AuthorizationException
     * @return void
     */
    public function show(Fuel $fuel)
    {
        $this->authorize('admin.fuel.show', $fuel);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Fuel $fuel
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Fuel $fuel)
    {
        $this->authorize('admin.fuel.edit', $fuel);


        return view('admin.fuel.edit', [
            'fuel' => $fuel,
        ]);
    }

    /**
     * Method: update
     * @OA\Put(
     *     path="/admin/fuels/{id}",
     *     summary="Update a fuel",
     *     tags={"Fuels"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Fuel ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Petrol")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Fuel updated successfully"),
     *     @OA\Response(response=404, description="Fuel not found")
     * )
     */
    public function update(UpdateFuel $request, Fuel $fuel)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Fuel
        $fuel->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/fuels'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/fuels');
    }

    /**
     * Method: destroy
     * @OA\Delete(
     *     path="/admin/fuels/{id}",
     *     summary="Delete a fuel",
     *     tags={"Fuels"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Fuel ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Fuel deleted successfully"),
     *     @OA\Response(response=404, description="Fuel not found")
     * )
     */
    public function destroy(DestroyFuel $request, Fuel $fuel)
    {
        $fuel->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Method: bulkDestroy
     * @OA\Post(
     *     path="/admin/fuels/bulk-destroy",
     *     summary="Bulk delete fuels",
     *     tags={"Fuels"},
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
     *     @OA\Response(response=200, description="Fuels deleted successfully"),
     *     @OA\Response(response=422, description="Invalid request")
     * )
     */
    public function bulkDestroy(BulkDestroyFuel $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Fuel::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
