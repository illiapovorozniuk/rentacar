@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.order.actions.index'))

@section('body')

    <order-listing
        :data="{{ $data->toJson() }}"
        :url="'{{ url('admin/orders') }}'"
        inline-template>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.order.actions.index') }}
                    </div>
                    <div class="card-body overflow-auto" v-cloak>
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
                                    <th is='sortable' :column="'id'">ID</th>
                                    <th is='sortable' :column="'user_name'">Юзер</th>
                                    <th is='sortable' :column="'car_name'">Авто</th>
                                    <th></th>
                                    <th is='sortable' :column="'status'">Статус</th>
                                    <th is='sortable' :column="'total_price'">Сума замовлення</th>
                                    <th is='sortable' :column="'date_from'">Початок оренди</th>
                                    <th is='sortable' :column="'date_to'">Кінець оренди</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item, index) in collection" :key="item.id">
                                    <td>@{{ item.id }}</td>
                                    <td>@{{ item.user_name }}</td>
                                    <td>
                                        <img v-if="item.car_info.main_photo" :src="item.car_info.main_photo" alt="main photo" style="max-width: 80px; max-height: 60px; border-radius: 5px;">
                                        @{{ item.car_info.brand_slug + ' ' + item.car_info.car_slug+ ' ' + item.car_info.attribute_year  }}
                                    </td>
                                    <td>
                                    </td>
                                    <td>@{{ item.status }}</td>
                                    <td>@{{ item.total_price }} <span v-if="item.currency">@{{ item.currency.sign }}</span></td>

                                    <td>@{{ item.date_from }}</td>
                                    <td>@{{ item.date_to }}</td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </order-listing>

@endsection
