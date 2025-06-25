<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Car\BulkDestroyCar;
use App\Http\Requests\Admin\Car\DestroyCar;
use App\Http\Requests\Admin\Car\IndexCar;
use App\Http\Requests\Admin\Car\StoreCar;
use App\Http\Requests\Admin\Car\UpdateCar;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\CarsColor;
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
use Illuminate\Pagination\LengthAwarePaginator;

class CarsController extends Controller
{

    /**
     * @OA\Get(
     *     path="/admin/cars",
     *     summary="List all cars",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of cars",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array", @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="car_model_id", type="integer", example=5),
     *                 @OA\Property(property="car_slug", type="string", example="audi-a6-2024"),
     *                 @OA\Property(property="availability_label", type="string", example="Available"),
     *                 @OA\Property(property="price_1", type="number", example=60.5),
     *                 @OA\Property(property="price_7", type="number", example=400),
     *                 @OA\Property(property="price_30", type="number", example=1500),
     *                 @OA\Property(property="price_31_more", type="number", example=1400),
     *                 @OA\Property(property="deposit", type="number", example=300),
     *                 @OA\Property(property="km_included_per_day", type="integer", example=100),
     *                 @OA\Property(property="overlimit_charge_per_km", type="number", example=0.5),
     *                 @OA\Property(property="min_day_reservation", type="integer", example=2),
     *                 @OA\Property(property="free_delivery", type="boolean", example=true),
     *                 @OA\Property(property="registration_number", type="string", example="AA1234BB"),
     *                 @OA\Property(property="color_id", type="integer", example=3),
     *                 @OA\Property(property="fuel_id", type="integer", example=1),
     *                 @OA\Property(property="attribute_year", type="integer", example=2023),
     *                 @OA\Property(property="attribute_seats", type="integer", example=5),
     *                 @OA\Property(property="attribute_1_to_100", type="number", example=7.2),
     *                 @OA\Property(property="attribute_max_speed", type="integer", example=240),
     *                 @OA\Property(property="attribute_horsepower", type="integer", example=180),
     *                 @OA\Property(property="attribute_transmission", type="string", example="Automatic"),
     *                 @OA\Property(property="attribute_doors", type="integer", example=4),
     *                 @OA\Property(property="attribute_engine", type="string", example="2.0L Turbo"),
     *                 @OA\Property(property="attribute_baggage", type="integer", example=450),
     *                 @OA\Property(property="status", type="string", example="active")
     *             ))
     *         )
     *     )
     * )
     */
    public function index(IndexCar $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Car::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'car_model_id', 'car_slug','availability_label', 'price_1', 'price_7', 'price_30', 'price_31_more', 'deposit', 'km_included_per_day', 'overlimit_charge_per_km', 'min_day_reservation', 'free_delivery', 'registration_number', 'color_id', 'fuel_id', 'attribute_year', 'attribute_seats', 'attribute_1_to_100', 'attribute_max_speed', 'attribute_horsepower', 'attribute_transmission', 'attribute_doors', 'attribute_engine', 'attribute_baggage', 'status'],

            // set columns to searchIn
            ['id', 'availability_label', 'car_slug', 'registration_number', 'attribute_transmission', 'attribute_engine']
        );

        $new_data = Car::carsInfo($data->toArray());

        // Сортуємо нові дані відповідно до порядку id у старих даних
        $old_order = array_column($data->items(), 'id');
        $new_data = $new_data->sortBy(function ($item) use ($old_order) {
            return array_search($item->id, $old_order);
        })->values(); // Перевпорядковуємо ключі

        $data = new LengthAwarePaginator(
            $new_data,
            $data->total(),
            $data->perPage(),
            $data->currentPage(),
            ['path' => $data->path()]
        );
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.car.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.car.create');
        return view('admin.car.create',[
            'car_models' => CarModel::all(),
            'cars_colors' => CarsColor::all(),
            'fuels' => Fuel::all(),
            'mode' => 'create'
        ]);
    }

    /**
     * @OA\Post(
     *     path="/admin/cars",
     *     summary="Create a new car",
     *     tags={"Cars"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"car_model", "color_id", "fuel_id"},
     *             @OA\Property(property="car_model", type="object",
     *                 @OA\Property(property="brand_id", type="integer", example=1),
     *                 @OA\Property(property="body_type_id", type="integer", example=2),
     *                 @OA\Property(property="slug", type="string", example="audi-a6-2024")
     *             ),
     *             @OA\Property(property="color_id", type="integer", example=3),
     *             @OA\Property(property="fuel_id", type="integer", example=1),
     *             @OA\Property(property="registration_number", type="string", example="AA1234BB"),
     *             @OA\Property(property="attribute_year", type="integer", example=2023),
     *             @OA\Property(property="price_1", type="number", example=60)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="redirect", type="string", example="/admin/cars"),
     *             @OA\Property(property="message", type="string", example="Operation succeeded")
     *         )
     *     ),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(StoreCar $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['car_brand_id'] = $request['car_model']['brand_id'];
        $sanitized['car_body_type_id'] = $request['car_model']['body_type_id'];
        $sanitized['car_model_id'] = $request->getCarModelId();
        $sanitized['car_slug'] = $request['car_model']['slug'];
        $sanitized['color_id'] = $request->getCarsColorId();
        $sanitized['fuel_id'] = $request->getFuelId();
        // Store the Car
        $car = Car::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/cars'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/cars');
    }

    /**
     * Display the specified resource.
     *
     * @param Car $car
     * @throws AuthorizationException
     * @return void
     */
    public function show(Car $car)
    {
        $this->authorize('admin.car.show', $car);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Car $car
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Car $car)
    {
        $this->authorize('admin.car.edit', $car);

        $car->load('carModel');
        $car->load('carsColor');
        $car->load('fuel');
        return view('admin.car.edit', [
            'car' => $car,
            'car_models' => CarModel::all(),
            'cars_colors' => CarsColor::all(),
            'fuels' => Fuel::all(),
            'mode' => 'edit'
        ]);
    }

    /**
     * @OA\Put(
     *     path="/admin/cars/{id}",
     *     summary="Update a car",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Car ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="car_model", type="object",
     *                 @OA\Property(property="brand_id", type="integer", example=1),
     *                 @OA\Property(property="body_type_id", type="integer", example=2),
     *                 @OA\Property(property="slug", type="string", example="audi-a6-2024")
     *             ),
     *             @OA\Property(property="fuel_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="redirect", type="string", example="/admin/cars"),
     *             @OA\Property(property="message", type="string", example="Operation succeeded")
     *         )
     *     )
     * )
     */
    public function update(UpdateCar $request, Car $car)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['car_model_id'] = $request->getCarModelId();
        $sanitized['car_brand_id'] = $request['car_model']['brand_id'];
        $sanitized['car_body_type_id'] = $request['car_model']['body_type_id'];
        $sanitized['car_slug'] = $request['car_model']['slug'];
//        $sanitized['color_id'] = $request->getCarsColorId();
        $sanitized['fuel_id'] = $request->getFuelId();

        // Update changed values Car
        $car->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/cars'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/cars');
    }

    /**
     * @OA\Delete(
     *     path="/admin/cars/{id}",
     *     summary="Delete a car",
     *     tags={"Cars"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Car ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Car deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Operation succeeded")
     *         )
     *     )
     * )
     */
    public function destroy(DestroyCar $request, Car $car)
    {
        $car->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * @OA\Post(
     *     path="/admin/cars/bulk-destroy",
     *     summary="Bulk delete cars",
     *     tags={"Cars"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="ids", type="array", @OA\Items(type="integer"), example={1,2,3})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cars deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Operation succeeded")
     *         )
     *     )
     * )
     */
    public function bulkDestroy(BulkDestroyCar $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Car::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
