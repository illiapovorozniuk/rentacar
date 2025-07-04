@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.car.actions.edit', ['name' => $car->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <car-form
                :action="'{{ $car->resource_url }}'"
                :data="{{ $car->toJson() }}"
                :car_models="{{$car_models->toJson()}}"
                :cars_colors="{{$cars_colors->toJson()}}"
                :fuels="{{$fuels->toJson()}}"
                v-cloak
                inline-template>

                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.car.actions.edit', ['name' => $car->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.car.components.form-elements')
                    </div>


                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>

                </form>

        </car-form>

        </div>

</div>

@endsection
