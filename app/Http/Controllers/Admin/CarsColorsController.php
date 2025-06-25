<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarsColor\BulkDestroyCarsColor;
use App\Http\Requests\Admin\CarsColor\DestroyCarsColor;
use App\Http\Requests\Admin\CarsColor\IndexCarsColor;
use App\Http\Requests\Admin\CarsColor\StoreCarsColor;
use App\Http\Requests\Admin\CarsColor\UpdateCarsColor;
use App\Models\CarsColor;
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

class CarsColorsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/cars-colors",
     *     summary="List all car colors",
     *     tags={"Car Colors"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of car colors",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Red"),
     *                 @OA\Property(property="color_code", type="string", example="#FF0000")
     *             ))
     *         )
     *     )
     * )
     */
    public function index(IndexCarsColor $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(CarsColor::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'color_code'],

            // set columns to searchIn
            ['id', 'slug', 'name', 'color_code']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.cars-color.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.cars-color.create');

        return view('admin.cars-color.create');
    }

    /**
     * @OA\Post(
     *     path="/admin/cars-colors",
     *     summary="Create a new car color",
     *     tags={"Car Colors"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "color_code"},
     *             @OA\Property(property="name", type="string", example="Metallic Gray"),
     *             @OA\Property(property="color_code", type="string", example="#A9A9A9")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car color created successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed"
     *     )
     * )
     */
    public function store(StoreCarsColor $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the CarsColor
        $carsColor = CarsColor::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/cars-colors'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/cars-colors');
    }

    /**
     * Display the specified resource.
     *
     * @param CarsColor $carsColor
     * @throws AuthorizationException
     * @return void
     */
    public function show(CarsColor $carsColor)
    {
        $this->authorize('admin.cars-color.show', $carsColor);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CarsColor $carsColor
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(CarsColor $carsColor)
    {
        $this->authorize('admin.cars-color.edit', $carsColor);


        return view('admin.cars-color.edit', [
            'carsColor' => $carsColor,
        ]);
    }

    /**
     * @OA\Put(
     *     path="/admin/cars-colors/{id}",
     *     summary="Update a car color",
     *     tags={"Car Colors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of car color to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Black"),
     *             @OA\Property(property="color_code", type="string", example="#000000")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car color updated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car color not found"
     *     )
     * )
     */
    public function update(UpdateCarsColor $request, CarsColor $carsColor)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values CarsColor
        $carsColor->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/cars-colors'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/cars-colors');
    }

    /**
     * @OA\Delete(
     *     path="/admin/cars-colors/{id}",
     *     summary="Delete a car color",
     *     tags={"Car Colors"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of car color to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car color deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Car color not found"
     *     )
     * )
     */
    public function destroy(DestroyCarsColor $request, CarsColor $carsColor)
    {
        $carsColor->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * @OA\Post(
     *     path="/admin/cars-colors/bulk-destroy",
     *     summary="Bulk delete car colors",
     *     tags={"Car Colors"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="ids", type="array", @OA\Items(type="integer", example=1))
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car colors deleted"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Invalid request"
     *     )
     * )
     */
    public function bulkDestroy(BulkDestroyCarsColor $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    CarsColor::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
