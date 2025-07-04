<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public $adminUser;

    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'admin';

    public function __construct()
    {
        // TODO add authorization
        $this->guard = config('admin-auth.defaults.guard');
    }

    /**
     * Get logged user before each method
     *
     * @param Request $request
     */
    protected function setUser($request)
    {
        if (empty($request->user($this->guard))) {
            abort(404, 'Admin User not found');
        }

        $this->adminUser = $request->user($this->guard);
    }

    /**
     * Show the form for editing logged user profile.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function editProfile(Request $request)
    {
        $this->setUser($request);

        return view('admin.profile.edit-profile', [
            'adminUser' => $this->adminUser,
        ]);
    }

    /**
     * Method: updateProfile
     * @OA\Put(
     *     path="/admin/profile",
     *     summary="Update logged in admin profile",
     *     tags={"Profile"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="language", type="string", example="en")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Profile updated successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function updateProfile(Request $request)
    {
        $this->setUser($request);
        $adminUser = $this->adminUser;

        // Validate the request
        $this->validate($request, [
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'email' => ['sometimes', 'email', Rule::unique('admin_users', 'email')->ignore($this->adminUser->getKey(), $this->adminUser->getKeyName()), 'string'],
            'language' => ['sometimes', 'string'],

        ]);

        // Sanitize input
        $sanitized = $request->only([
            'first_name',
            'last_name',
            'email',
            'language',

        ]);

        // Update changed values AdminUser
        $this->adminUser->update($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/profile'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/profile');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function editPassword(Request $request)
    {
        $this->setUser($request);

        return view('admin.profile.edit-password', [
            'adminUser' => $this->adminUser,
        ]);
    }



    /**
     * Method: updatePassword
     * @OA\Put(
     *     path="/admin/password",
     *     summary="Update logged in admin password",
     *     tags={"Profile"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="password", type="string", format="password", example="NewPass123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Password updated successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function updatePassword(Request $request)
    {
        $this->setUser($request);
        $adminUser = $this->adminUser;

        // Validate the request
        $this->validate($request, [
            'password' => ['sometimes', 'confirmed', 'min:7', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'string'],

        ]);

        // Sanitize input
        $sanitized = $request->only([
            'password',

        ]);

        //Modify input, set hashed password
        $sanitized['password'] = Hash::make($sanitized['password']);

        // Update changed values AdminUser
        $this->adminUser->update($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/password'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/password');
    }
}
