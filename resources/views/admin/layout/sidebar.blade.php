<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav" style="background: #000">
            <a class="nav-link collapsed d-flex align-items-center" style="padding-left: 0px !important;" data-toggle="collapse" href="#SideBarSettings" role="button"
               aria-expanded="true" aria-controls="multiCollapseExample2">
                <li class="nav-title d-flex" style="display: flex !important;padding-bottom:0px !important;; padding-top:0px !important;padding-right: 5px !important;">
                    {{ trans('brackets/admin-ui::admin.sidebar.cars_config') }}
                </li>
                <svg style="opacity: 0.5; margin-left: 2px" xmlns="http://www.w3.org/2000/svg" width="10" height="14" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                    <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                </svg>
            </a>
            <div class="row">
                <div class="col">
                    <div class="collapse multi-collapse" id="SideBarSettings" style="padding-left: 2px;">
                        <li class="nav-item"><a class="nav-link" href="{{ url('admin/brands') }}">
                                <img src="{{ asset('images/admin/sidebar/brands.svg') }}" alt="brands"/>{{ trans('admin.brand.title') }}
                            </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('admin/body-types') }}">
                                <img src="{{ asset('images/admin/sidebar/body-types.svg') }}" alt="body-types"/>{{ trans('admin.body-type.title') }}
                            </a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ url('admin/types') }}">
                                <img src="{{ asset('images/admin/sidebar/types.svg') }}" alt="types"/>{{ trans('admin.type.title') }}
                            </a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin/fuels') }}"><img height="25" width="50" src="{{ asset('images/admin/sidebar/fuels.svg') }}" alt="types"/> {{ trans('admin.fuel.title') }}
                            </a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin/car-models') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.car-model.title') }}
                            </a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin/cars-colors') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.cars-color.title') }}
                            </a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('admin/cars') }}"><i class="nav-icon icon-star"></i> {{ trans('admin.car.title') }}
                            </a></li>
                    </div>
                </div>
            </div>
            {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}
                </a></li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}
                </a></li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('admin/currencies') }}"><i class="nav-icon icon-plane"></i> {{ trans('admin.currency.title') }}
                </a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
