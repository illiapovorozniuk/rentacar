<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CarModel\BulkDestroyCarModel;
use App\Http\Requests\Admin\CarModel\DestroyCarModel;
use App\Http\Requests\Admin\CarModel\IndexCarModel;
use App\Http\Requests\Admin\CarModel\StoreCarModel;
use App\Http\Requests\Admin\CarModel\UpdateCarModel;
use App\Models\BodyType;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Type;
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

class CarModelsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCarModel $request
     * @return array|Factory|View
     */
    public function index(IndexCarModel $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(CarModel::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'brand_id', 'body_type_id'],

            // set columns to searchIn
            ['id', 'slug', 'name'],

            function ($query) use ($request) {
//                $query->with(['brand']);
//                $query->join('brands', 'brands.id', '=', 'car_models.brand_id');
//
//                $query->with(['bodyType']);
//                $query->join('body_types', 'body_types.id', '=', 'car_models.body_type_id');
//
//                if($request->has('brands')){
//                    $query->whereIn('brand_id', $request->get('brands'));
//                }
//
//                if($request->has('body_types')){
//                    $query->whereIn('body_type_id', $request->get('body_types'));
//                }
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.car-model.index', [
            'data' => $data,
            'brands' => $brands = Brand::all(),
            'body_types' => $body_types = BodyType::all(),
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.car-model.create');

        return view('admin.car-model.create',[
            'brands' => Brand::all(),
            'body_types' => BodyType::all(),
            'types' => Type::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCarModel $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCarModel $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['brand_id'] = $request->getBrandId();
        $sanitized['body_type_id'] = $request->getBodyTypeId();
        $sanitized['types'] = $request->getTypes();
        DB::transaction(function () use ($sanitized) {
            // Store the CarModel
            $carModel = CarModel::create($sanitized);
            $carModel->types()->sync($sanitized['types']);
        });


        if ($request->ajax()) {
            return ['redirect' => url('admin/car-models'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/car-models');
    }

    /**
     * Display the specified resource.
     *
     * @param CarModel $carModel
     * @throws AuthorizationException
     * @return void
     */
    public function show(CarModel $carModel)
    {
        $this->authorize('admin.car-model.show', $carModel);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CarModel $carModel
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(CarModel $carModel)
    {
        $this->authorize('admin.car-model.edit', $carModel);

        $carModel->load('brand');
        $carModel->load('bodyType');
        $carModel->load('types');

        return view('admin.car-model.edit', [
            'carModel' => $carModel,
            'brands' => Brand::all(),
            'body_types' => BodyType::all(),
            'types' => Type::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCarModel $request
     * @param CarModel $carModel
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCarModel $request, CarModel $carModel)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['brand_id'] = $request->getBrandId();
        $sanitized['body_type_id'] = $request->getBodyTypeId();
        $sanitized['types'] = $request->getTypes();
        DB::transaction(function () use ($carModel, $sanitized) {
            // Update changed values CarModel
            $carModel->update($sanitized);
            $carModel->types()->sync($sanitized['types']);
        });


        if ($request->ajax()) {
            return [
                'redirect' => url('admin/car-models'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/car-models');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCarModel $request
     * @param CarModel $carModel
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCarModel $request, CarModel $carModel)
    {
        $carModel->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCarModel $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCarModel $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    CarModel::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
