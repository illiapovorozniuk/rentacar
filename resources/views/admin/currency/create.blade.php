@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.currency.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <currency-form
            :action="'{{ url('admin/currencies') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.currency.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.currency.components.form-elements')
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </currency-form>

        </div>

        </div>

    
@endsection