<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Currency\BulkDestroyCurrency;
use App\Http\Requests\Admin\Currency\DestroyCurrency;
use App\Http\Requests\Admin\Currency\IndexCurrency;
use App\Http\Requests\Admin\Currency\StoreCurrency;
use App\Http\Requests\Admin\Currency\UpdateCurrency;
use App\Models\Currency;
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

class CurrenciesController extends Controller
{

    /**
     * Method: index
     * @OA\Get(
     *     path="/admin/currencies",
     *     summary="Get list of currencies",
     *     tags={"Currencies"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of currencies",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="sign", type="string", example="$"),
     *                     @OA\Property(property="exchange_rate", type="number", example=27.5)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(IndexCurrency $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Currency::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'sign', 'exchange_rate'],

            // set columns to searchIn
            ['id', 'slug', 'sign']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.currency.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.currency.create');

        return view('admin.currency.create');
    }

    /**
     * Method: store
     * @OA\Post(
     *     path="/admin/currencies",
     *     summary="Create a new currency",
     *     tags={"Currencies"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"sign", "exchange_rate"},
     *             @OA\Property(property="sign", type="string", example="$"),
     *             @OA\Property(property="exchange_rate", type="number", example=27.5)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Currency created successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(StoreCurrency $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Currency
        $currency = Currency::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/currencies'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/currencies');
    }

    /**
     * Display the specified resource.
     *
     * @param Currency $currency
     * @throws AuthorizationException
     * @return void
     */
    public function show(Currency $currency)
    {
        $this->authorize('admin.currency.show', $currency);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Currency $currency
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Currency $currency)
    {
        $this->authorize('admin.currency.edit', $currency);


        return view('admin.currency.edit', [
            'currency' => $currency,
        ]);
    }

    /**
     * Method: update
     * @OA\Put(
     *     path="/admin/currencies/{id}",
     *     summary="Update a currency",
     *     tags={"Currencies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Currency ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="sign", type="string", example="€"),
     *             @OA\Property(property="exchange_rate", type="number", example=30.1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Currency updated successfully"),
     *     @OA\Response(response=404, description="Currency not found")
     * )
     */

    public function update(UpdateCurrency $request, Currency $currency)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Currency
        $currency->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/currencies'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/currencies');
    }

    /**
     * Method: destroy
     * @OA\Delete(
     *     path="/admin/currencies/{id}",
     *     summary="Delete a currency",
     *     tags={"Currencies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Currency ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Currency deleted successfully"),
     *     @OA\Response(response=404, description="Currency not found")
     * )
     */
    public function destroy(DestroyCurrency $request, Currency $currency)
    {
        $currency->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Method: bulkDestroy
     * @OA\Post(
     *     path="/admin/currencies/bulk-destroy",
     *     summary="Bulk delete currencies",
     *     tags={"Currencies"},
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
     *     @OA\Response(response=200, description="Currencies deleted successfully"),
     *     @OA\Response(response=422, description="Invalid request")
     * )
     */
    public function bulkDestroy(BulkDestroyCurrency $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Currency::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
