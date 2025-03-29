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
     * Display a listing of the resource.
     *
     * @param IndexBodyType $request
     * @return array|Factory|View
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
     * Store a newly created resource in storage.
     *
     * @param StoreBodyType $request
     * @return array|RedirectResponse|Redirector
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
     * Update the specified resource in storage.
     *
     * @param UpdateBodyType $request
     * @param BodyType $bodyType
     * @return array|RedirectResponse|Redirector
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
     * Remove the specified resource from storage.
     *
     * @param DestroyBodyType $request
     * @param BodyType $bodyType
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
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
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyBodyType $request
     * @throws Exception
     * @return Response|bool
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
