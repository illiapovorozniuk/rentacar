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
     * Display a listing of the resource.
     *
     * @param IndexCarsColor $request
     * @return array|Factory|View
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
     * Store a newly created resource in storage.
     *
     * @param StoreCarsColor $request
     * @return array|RedirectResponse|Redirector
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
     * Update the specified resource in storage.
     *
     * @param UpdateCarsColor $request
     * @param CarsColor $carsColor
     * @return array|RedirectResponse|Redirector
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
     * Remove the specified resource from storage.
     *
     * @param DestroyCarsColor $request
     * @param CarsColor $carsColor
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
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
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCarsColor $request
     * @throws Exception
     * @return Response|bool
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
