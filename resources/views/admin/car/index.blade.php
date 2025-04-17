@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.car.actions.index'))

@section('body')

    <car-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/cars') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.car.actions.index') }}
                        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url('admin/cars/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.car.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-auto form-group ">
                                        <select class="form-control" v-model="pagination.state.per_page">
                                            
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-hover table-listing">
                                <thead>
                                    <tr>
                                        <th class="bulk-checkbox">
                                            <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled"  name="enabled_fake_element" @click="onBulkItemsClickedAllWithPagination()">
                                            <label class="form-check-label" for="enabled">
                                                #
                                            </label>
                                        </th>

                                        <th is='sortable' :column="'id'">{{ trans('admin.car.columns.id') }}</th>
                                        <th is='sortable' :column="'car_model_id'">{{ trans('admin.car.columns.car_model_id') }}</th>
                                        <th is='sortable' :column="'availability_label'">{{ trans('admin.car.columns.availability_label') }}</th>
                                        <th is='sortable' :column="'price_1'">{{ trans('admin.car.columns.price_1') }}</th>
                                        <th is='sortable' :column="'price_7'">{{ trans('admin.car.columns.price_7') }}</th>
                                        <th is='sortable' :column="'price_30'">{{ trans('admin.car.columns.price_30') }}</th>
                                        <th is='sortable' :column="'price_31_more'">{{ trans('admin.car.columns.price_31_more') }}</th>
                                        <th is='sortable' :column="'deposit'">{{ trans('admin.car.columns.deposit') }}</th>
                                        <th is='sortable' :column="'km_included_per_day'">{{ trans('admin.car.columns.km_included_per_day') }}</th>
                                        <th is='sortable' :column="'overlimit_charge_per_km'">{{ trans('admin.car.columns.overlimit_charge_per_km') }}</th>
                                        <th is='sortable' :column="'min_day_reservation'">{{ trans('admin.car.columns.min_day_reservation') }}</th>
                                        <th is='sortable' :column="'free_delivery'">{{ trans('admin.car.columns.free_delivery') }}</th>
                                        <th is='sortable' :column="'registration_number'">{{ trans('admin.car.columns.registration_number') }}</th>
                                        <th is='sortable' :column="'color_id'">{{ trans('admin.car.columns.color_id') }}</th>
                                        <th is='sortable' :column="'fuel_id'">{{ trans('admin.car.columns.fuel_id') }}</th>
                                        <th is='sortable' :column="'attribute_year'">{{ trans('admin.car.columns.attribute_year') }}</th>
                                        <th is='sortable' :column="'attribute_seats'">{{ trans('admin.car.columns.attribute_seats') }}</th>
                                        <th is='sortable' :column="'attribute_1_to_100'">{{ trans('admin.car.columns.attribute_1_to_100') }}</th>
                                        <th is='sortable' :column="'attribute_max_speed'">{{ trans('admin.car.columns.attribute_max_speed') }}</th>
                                        <th is='sortable' :column="'attribute_horsepower'">{{ trans('admin.car.columns.attribute_horsepower') }}</th>
                                        <th is='sortable' :column="'attribute_transmission'">{{ trans('admin.car.columns.attribute_transmission') }}</th>
                                        <th is='sortable' :column="'attribute_doors'">{{ trans('admin.car.columns.attribute_doors') }}</th>
                                        <th is='sortable' :column="'attribute_engine'">{{ trans('admin.car.columns.attribute_engine') }}</th>
                                        <th is='sortable' :column="'attribute_baggage'">{{ trans('admin.car.columns.attribute_baggage') }}</th>
                                        <th is='sortable' :column="'status'">{{ trans('admin.car.columns.status') }}</th>

                                        <th></th>
                                    </tr>
                                    <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                        <td class="bg-bulk-info d-table-cell text-center" colspan="27">
                                            <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}.  <a href="#" class="text-primary" @click="onBulkItemsClickedAll('/admin/cars')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a
                                                        href="#" class="text-primary" @click="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a>  </span>

                                            <span class="pull-right pr-2">
                                                <button class="btn btn-sm btn-danger pr-3 pl-3" @click="bulkDelete('/admin/cars/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
                                            </span>

                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                        <td class="bulk-checkbox">
                                            <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id"  :name="'enabled' + item.id + '_fake_element'" @click="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                            <label class="form-check-label" :for="'enabled' + item.id">
                                            </label>
                                        </td>

                                    <td>@{{ item.id }}</td>
                                        <td>@{{ item.car_model_id }}</td>
                                        <td>@{{ item.availability_label }}</td>
                                        <td>@{{ item.price_1 }}</td>
                                        <td>@{{ item.price_7 }}</td>
                                        <td>@{{ item.price_30 }}</td>
                                        <td>@{{ item.price_31_more }}</td>
                                        <td>@{{ item.deposit }}</td>
                                        <td>@{{ item.km_included_per_day }}</td>
                                        <td>@{{ item.overlimit_charge_per_km }}</td>
                                        <td>@{{ item.min_day_reservation }}</td>
                                        <td>@{{ item.free_delivery }}</td>
                                        <td>@{{ item.registration_number }}</td>
                                        <td>@{{ item.color_id }}</td>
                                        <td>@{{ item.fuel_id }}</td>
                                        <td>@{{ item.attribute_year }}</td>
                                        <td>@{{ item.attribute_seats }}</td>
                                        <td>@{{ item.attribute_1_to_100 }}</td>
                                        <td>@{{ item.attribute_max_speed }}</td>
                                        <td>@{{ item.attribute_horsepower }}</td>
                                        <td>@{{ item.attribute_transmission }}</td>
                                        <td>@{{ item.attribute_doors }}</td>
                                        <td>@{{ item.attribute_engine }}</td>
                                        <td>@{{ item.attribute_baggage }}</td>
                                        <td>@{{ item.status }}</td>
                                        
                                        <td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" :href="item.resource_url + '/edit'" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                </div>
                                                <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                    <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary btn-spinner" href="{{ url('admin/cars/create') }}" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.car.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </car-listing>

@endsection