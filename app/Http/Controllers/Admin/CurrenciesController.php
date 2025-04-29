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
     * Display a listing of the resource.
     *
     * @param IndexCurrency $request
     * @return array|Factory|View
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
     * Store a newly created resource in storage.
     *
     * @param StoreCurrency $request
     * @return array|RedirectResponse|Redirector
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
     * Update the specified resource in storage.
     *
     * @param UpdateCurrency $request
     * @param Currency $currency
     * @return array|RedirectResponse|Redirector
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
     * Remove the specified resource from storage.
     *
     * @param DestroyCurrency $request
     * @param Currency $currency
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
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
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCurrency $request
     * @throws Exception
     * @return Response|bool
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
