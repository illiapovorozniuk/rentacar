<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav" style="background: #000">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/brands') }}">
                    <img src="{{ asset('images/admin/sidebar/brands.svg') }}" alt="brands" />{{ trans('admin.brand.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/body-types') }}">
                   <img src="{{ asset('images/admin/sidebar/body-types.svg') }}" alt="body-types" />{{ trans('admin.body-type.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/types') }}">
                   <img src="{{ asset('images/admin/sidebar/types.svg') }}" alt="types" />{{ trans('admin.type.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/fuels') }}"><img height="25" width="50" src="{{ asset('images/admin/sidebar/fuels.svg') }}" alt="types" /> {{ trans('admin.fuel.title') }}</a></li>
           <li class="nav-item"><a class="nav-link" href="{{ url('admin/car-models') }}"><i class="nav-icon icon-flag"></i> {{ trans('admin.car-model.title') }}</a></li>
           {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
