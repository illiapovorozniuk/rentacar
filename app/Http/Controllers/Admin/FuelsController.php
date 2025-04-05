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
     * Display a listing of the resource.
     *
     * @param IndexFuel $request
     * @return array|Factory|View
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
     * Store a newly created resource in storage.
     *
     * @param StoreFuel $request
     * @return array|RedirectResponse|Redirector
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
     * Update the specified resource in storage.
     *
     * @param UpdateFuel $request
     * @param Fuel $fuel
     * @return array|RedirectResponse|Redirector
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
     * Remove the specified resource from storage.
     *
     * @param DestroyFuel $request
     * @param Fuel $fuel
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
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
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyFuel $request
     * @throws Exception
     * @return Response|bool
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
