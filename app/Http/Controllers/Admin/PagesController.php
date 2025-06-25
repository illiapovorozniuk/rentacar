<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Page\BulkDestroyPage;
use App\Http\Requests\Admin\Page\DestroyPage;
use App\Http\Requests\Admin\Page\IndexPage;
use App\Http\Requests\Admin\Page\StorePage;
use App\Http\Requests\Admin\Page\UpdatePage;
use App\Models\Page;
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

class PagesController extends Controller
{

    /**
     * Method: index
     * @OA\Get(
     *     path="/admin/pages",
     *     summary="Get list of pages",
     *     tags={"Pages"},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search keyword",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of pages",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="About Us"),
     *                     @OA\Property(property="link", type="string", example="/about-us"),
     *                     @OA\Property(property="type", type="string", example="static"),
     *                     @OA\Property(property="h1", type="string", example="Welcome"),
     *                     @OA\Property(property="description", type="string", example="Page description"),
     *                     @OA\Property(property="content", type="string", example="Page content"),
     *                     @OA\Property(property="enabled", type="boolean", example=true)
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(IndexPage $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Page::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'title', 'link', 'type', 'h1', 'description', 'content', 'enabled'],

            // set columns to searchIn
            ['id', 'title', 'link', 'type', 'h1', 'description', 'content', 'faq']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.page.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.page.create');

        return view('admin.page.create',[
            'mode' => 'create'
        ]);
    }

    /**
     * Method: store
     * @OA\Post(
     *     path="/admin/pages",
     *     summary="Create a new page",
     *     tags={"Pages"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title", "link", "type", "h1"},
     *             @OA\Property(property="title", type="string", example="About Us"),
     *             @OA\Property(property="link", type="string", example="/about-us"),
     *             @OA\Property(property="type", type="string", example="static"),
     *             @OA\Property(property="h1", type="string", example="Welcome"),
     *             @OA\Property(property="description", type="string", example="Page description"),
     *             @OA\Property(property="content", type="string", example="Page content"),
     *             @OA\Property(property="faq", type="string", example="[{'q':'Question 1','a':'Answer 1'}]"),
     *             @OA\Property(property="enabled", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Page created successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(StorePage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized["faq"] = json_encode($request->input('faq'));
        $sanitized["faq"] = str_replace('<br>', '', $sanitized["faq"]);
        // Store the Page
        $page = Page::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/pages'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/pages');
    }

    /**
     * Display the specified resource.
     *
     * @param Page $page
     * @throws AuthorizationException
     * @return void
     */
    public function show(Page $page)
    {
        $this->authorize('admin.page.show', $page);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Page $page)
    {
        $this->authorize('admin.page.edit', $page);
        $page->faq = json_decode($page->faq);
        return view('admin.page.edit', [
            'page' => $page,
            'mode'=> 'edit'
        ]);
    }

    /**
     * Method: update
     * @OA\Put(
     *     path="/admin/pages/{id}",
     *     summary="Update a page",
     *     tags={"Pages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Page ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="About Us Updated"),
     *             @OA\Property(property="link", type="string", example="/about-us-updated"),
     *             @OA\Property(property="type", type="string", example="static"),
     *             @OA\Property(property="h1", type="string", example="Welcome Updated"),
     *             @OA\Property(property="description", type="string", example="Updated description"),
     *             @OA\Property(property="content", type="string", example="Updated content"),
     *             @OA\Property(property="faq", type="string", example="[{'q':'New Question','a':'New Answer'}]"),
     *             @OA\Property(property="enabled", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Page updated successfully"),
     *     @OA\Response(response=404, description="Page not found")
     * )
     */

    public function update(UpdatePage $request, Page $page)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized["faq"] = json_encode($request->input('faq'));
        $sanitized["faq"] = str_replace('<br>', '', $sanitized["faq"]);
        // Update changed values Page
        $page->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/pages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/pages');
    }

    /**
     * Method: destroy
     * @OA\Delete(
     *     path="/admin/pages/{id}",
     *     summary="Delete a page",
     *     tags={"Pages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Page ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Page deleted successfully"),
     *     @OA\Response(response=404, description="Page not found")
     * )
     */
    public function destroy(DestroyPage $request, Page $page)
    {
        $page->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Method: bulkDestroy
     * @OA\Post(
     *     path="/admin/pages/bulk-destroy",
     *     summary="Bulk delete pages",
     *     tags={"Pages"},
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
     *     @OA\Response(response=200, description="Pages deleted successfully"),
     *     @OA\Response(response=422, description="Invalid request")
     * )
     */
    public function bulkDestroy(BulkDestroyPage $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Page::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
