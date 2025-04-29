<div class="form-group row align-items-center" :class="{'has-danger': errors.has('slug'), 'has-success': fields.slug && fields.slug.valid }">
    <label for="slug" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.currency.columns.slug') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.slug" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('slug'), 'form-control-success': fields.slug && fields.slug.valid}" id="slug" name="slug" placeholder="{{ trans('admin.currency.columns.slug') }}">
        <div v-if="errors.has('slug')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('slug') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('sign'), 'has-success': fields.sign && fields.sign.valid }">
    <label for="sign" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.currency.columns.sign') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.sign" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('sign'), 'form-control-success': fields.sign && fields.sign.valid}" id="sign" name="sign" placeholder="{{ trans('admin.currency.columns.sign') }}">
        <div v-if="errors.has('sign')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('sign') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('exchange_rate'), 'has-success': fields.exchange_rate && fields.exchange_rate.valid }">
    <label for="exchange_rate" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.currency.columns.exchange_rate') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.exchange_rate" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('exchange_rate'), 'form-control-success': fields.exchange_rate && fields.exchange_rate.valid}" id="exchange_rate" name="exchange_rate" placeholder="{{ trans('admin.currency.columns.exchange_rate') }}">
        <div v-if="errors.has('exchange_rate')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('exchange_rate') }}</div>
    </div>
</div>


