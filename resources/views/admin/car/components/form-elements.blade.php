<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('car_model_id'), 'has-success': this.fields.car_model_id && this.fields.car_model_id.valid }">
    <label for="car_model_id"
           class="col-md-2">{{ trans('admin.forms.car_model_name') }}</label>
    <div class="col-md-9 col-xl-8">

        <multiselect
            v-model="form.car_model"
            :options="car_models"
            :multiple="false"
            track-by="id"
            label="name"
            tag-placeholder="{{ __('Select car_model') }}"
            placeholder="{{ __('car_model') }}">
        </multiselect>

        <div v-if="errors.has('car_model_id')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('car_model_id') }}
        </div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('availability_label'), 'has-success': fields.availability_label && fields.availability_label.valid }">
    <label for="availability_label" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.availability_label') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.availability_label" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('availability_label'), 'form-control-success': fields.availability_label && fields.availability_label.valid}" id="availability_label" name="availability_label" placeholder="{{ trans('admin.car.columns.availability_label') }}">
        <div v-if="errors.has('availability_label')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('availability_label') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('price_1'), 'has-success': fields.price_1 && fields.price_1.valid }">
    <label for="price_1" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.price_1') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.price_1" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('price_1'), 'form-control-success': fields.price_1 && fields.price_1.valid}" id="price_1" name="price_1" placeholder="{{ trans('admin.car.columns.price_1') }}">
        <div v-if="errors.has('price_1')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('price_1') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('price_7'), 'has-success': fields.price_7 && fields.price_7.valid }">
    <label for="price_7" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.price_7') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.price_7" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('price_7'), 'form-control-success': fields.price_7 && fields.price_7.valid}" id="price_7" name="price_7" placeholder="{{ trans('admin.car.columns.price_7') }}">
        <div v-if="errors.has('price_7')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('price_7') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('price_30'), 'has-success': fields.price_30 && fields.price_30.valid }">
    <label for="price_30" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.price_30') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.price_30" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('price_30'), 'form-control-success': fields.price_30 && fields.price_30.valid}" id="price_30" name="price_30" placeholder="{{ trans('admin.car.columns.price_30') }}">
        <div v-if="errors.has('price_30')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('price_30') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('price_31_more'), 'has-success': fields.price_31_more && fields.price_31_more.valid }">
    <label for="price_31_more" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.price_31_more') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.price_31_more" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('price_31_more'), 'form-control-success': fields.price_31_more && fields.price_31_more.valid}" id="price_31_more" name="price_31_more" placeholder="{{ trans('admin.car.columns.price_31_more') }}">
        <div v-if="errors.has('price_31_more')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('price_31_more') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('deposit'), 'has-success': fields.deposit && fields.deposit.valid }">
    <label for="deposit" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.deposit') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.deposit" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('deposit'), 'form-control-success': fields.deposit && fields.deposit.valid}" id="deposit" name="deposit" placeholder="{{ trans('admin.car.columns.deposit') }}">
        <div v-if="errors.has('deposit')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('deposit') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('km_included_per_day'), 'has-success': fields.km_included_per_day && fields.km_included_per_day.valid }">
    <label for="km_included_per_day" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.km_included_per_day') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.km_included_per_day" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('km_included_per_day'), 'form-control-success': fields.km_included_per_day && fields.km_included_per_day.valid}" id="km_included_per_day" name="km_included_per_day" placeholder="{{ trans('admin.car.columns.km_included_per_day') }}">
        <div v-if="errors.has('km_included_per_day')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('km_included_per_day') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('overlimit_charge_per_km'), 'has-success': fields.overlimit_charge_per_km && fields.overlimit_charge_per_km.valid }">
    <label for="overlimit_charge_per_km" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.overlimit_charge_per_km') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.overlimit_charge_per_km" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('overlimit_charge_per_km'), 'form-control-success': fields.overlimit_charge_per_km && fields.overlimit_charge_per_km.valid}" id="overlimit_charge_per_km" name="overlimit_charge_per_km" placeholder="{{ trans('admin.car.columns.overlimit_charge_per_km') }}">
        <div v-if="errors.has('overlimit_charge_per_km')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('overlimit_charge_per_km') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('min_day_reservation'), 'has-success': fields.min_day_reservation && fields.min_day_reservation.valid }">
    <label for="min_day_reservation" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.min_day_reservation') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.min_day_reservation" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('min_day_reservation'), 'form-control-success': fields.min_day_reservation && fields.min_day_reservation.valid}" id="min_day_reservation" name="min_day_reservation" placeholder="{{ trans('admin.car.columns.min_day_reservation') }}">
        <div v-if="errors.has('min_day_reservation')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('min_day_reservation') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('free_delivery'), 'has-success': fields.free_delivery && fields.free_delivery.valid }">
    <label for="free_delivery" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.free_delivery') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.free_delivery" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('free_delivery'), 'form-control-success': fields.free_delivery && fields.free_delivery.valid}" id="free_delivery" name="free_delivery" placeholder="{{ trans('admin.car.columns.free_delivery') }}">
        <div v-if="errors.has('free_delivery')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('free_delivery') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('registration_number'), 'has-success': fields.registration_number && fields.registration_number.valid }">
    <label for="registration_number" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.registration_number') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.registration_number" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('registration_number'), 'form-control-success': fields.registration_number && fields.registration_number.valid}" id="registration_number" name="registration_number" placeholder="{{ trans('admin.car.columns.registration_number') }}">
        <div v-if="errors.has('registration_number')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('registration_number') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('color_id'), 'has-success': fields.color_id && fields.color_id.valid }">
    <label for="color_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.color_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.color_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('color_id'), 'form-control-success': fields.color_id && fields.color_id.valid}" id="color_id" name="color_id" placeholder="{{ trans('admin.car.columns.color_id') }}">
        <div v-if="errors.has('color_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('color_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('fuel_id'), 'has-success': fields.fuel_id && fields.fuel_id.valid }">
    <label for="fuel_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.fuel_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.fuel_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('fuel_id'), 'form-control-success': fields.fuel_id && fields.fuel_id.valid}" id="fuel_id" name="fuel_id" placeholder="{{ trans('admin.car.columns.fuel_id') }}">
        <div v-if="errors.has('fuel_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('fuel_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_year'), 'has-success': fields.attribute_year && fields.attribute_year.valid }">
    <label for="attribute_year" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.attribute_year') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_year" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_year'), 'form-control-success': fields.attribute_year && fields.attribute_year.valid}" id="attribute_year" name="attribute_year" placeholder="{{ trans('admin.car.columns.attribute_year') }}">
        <div v-if="errors.has('attribute_year')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_year') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_seats'), 'has-success': fields.attribute_seats && fields.attribute_seats.valid }">
    <label for="attribute_seats" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.attribute_seats') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_seats" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_seats'), 'form-control-success': fields.attribute_seats && fields.attribute_seats.valid}" id="attribute_seats" name="attribute_seats" placeholder="{{ trans('admin.car.columns.attribute_seats') }}">
        <div v-if="errors.has('attribute_seats')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_seats') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_1_to_100'), 'has-success': fields.attribute_1_to_100 && fields.attribute_1_to_100.valid }">
    <label for="attribute_1_to_100" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.attribute_1_to_100') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_1_to_100" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_1_to_100'), 'form-control-success': fields.attribute_1_to_100 && fields.attribute_1_to_100.valid}" id="attribute_1_to_100" name="attribute_1_to_100" placeholder="{{ trans('admin.car.columns.attribute_1_to_100') }}">
        <div v-if="errors.has('attribute_1_to_100')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_1_to_100') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_max_speed'), 'has-success': fields.attribute_max_speed && fields.attribute_max_speed.valid }">
    <label for="attribute_max_speed" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.attribute_max_speed') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_max_speed" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_max_speed'), 'form-control-success': fields.attribute_max_speed && fields.attribute_max_speed.valid}" id="attribute_max_speed" name="attribute_max_speed" placeholder="{{ trans('admin.car.columns.attribute_max_speed') }}">
        <div v-if="errors.has('attribute_max_speed')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_max_speed') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_horsepower'), 'has-success': fields.attribute_horsepower && fields.attribute_horsepower.valid }">
    <label for="attribute_horsepower" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.attribute_horsepower') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_horsepower" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_horsepower'), 'form-control-success': fields.attribute_horsepower && fields.attribute_horsepower.valid}" id="attribute_horsepower" name="attribute_horsepower" placeholder="{{ trans('admin.car.columns.attribute_horsepower') }}">
        <div v-if="errors.has('attribute_horsepower')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_horsepower') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_transmission'), 'has-success': fields.attribute_transmission && fields.attribute_transmission.valid }">
    <label for="attribute_transmission" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.attribute_transmission') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_transmission" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_transmission'), 'form-control-success': fields.attribute_transmission && fields.attribute_transmission.valid}" id="attribute_transmission" name="attribute_transmission" placeholder="{{ trans('admin.car.columns.attribute_transmission') }}">
        <div v-if="errors.has('attribute_transmission')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_transmission') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_doors'), 'has-success': fields.attribute_doors && fields.attribute_doors.valid }">
    <label for="attribute_doors" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.attribute_doors') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_doors" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_doors'), 'form-control-success': fields.attribute_doors && fields.attribute_doors.valid}" id="attribute_doors" name="attribute_doors" placeholder="{{ trans('admin.car.columns.attribute_doors') }}">
        <div v-if="errors.has('attribute_doors')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_doors') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_engine'), 'has-success': fields.attribute_engine && fields.attribute_engine.valid }">
    <label for="attribute_engine" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.attribute_engine') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_engine" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_engine'), 'form-control-success': fields.attribute_engine && fields.attribute_engine.valid}" id="attribute_engine" name="attribute_engine" placeholder="{{ trans('admin.car.columns.attribute_engine') }}">
        <div v-if="errors.has('attribute_engine')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_engine') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_baggage'), 'has-success': fields.attribute_baggage && fields.attribute_baggage.valid }">
    <label for="attribute_baggage" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car.columns.attribute_baggage') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.attribute_baggage" v-validate="'integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('attribute_baggage'), 'form-control-success': fields.attribute_baggage && fields.attribute_baggage.valid}" id="attribute_baggage" name="attribute_baggage" placeholder="{{ trans('admin.car.columns.attribute_baggage') }}">
        <div v-if="errors.has('attribute_baggage')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_baggage') }}</div>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="status" type="checkbox" v-model="form.status" v-validate="''" data-vv-name="status"  name="status_fake_element">
        <label class="form-check-label" for="status">
            {{ trans('admin.car.columns.status') }}
        </label>
        <input type="hidden" name="status" :value="form.status">
        <div v-if="errors.has('status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('status') }}</div>
    </div>
</div>


