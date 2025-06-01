<div class="row form-inline" style="padding-bottom: 10px;" v-cloak>
    <div :class="{'col-xl-10 col-md-11 text-right': !isFormLocalized, 'col text-center': isFormLocalized, 'hidden': onSmallScreen }">
        <small>{{ trans('brackets/admin-ui::admin.forms.currently_editing_translation') }}<span v-if="!isFormLocalized && otherLocales.length > 1"> {{ trans('brackets/admin-ui::admin.forms.more_can_be_managed') }}</span><span v-if="!isFormLocalized"> | <a href="#" @click.prevent="showLocalization">{{ trans('brackets/admin-ui::admin.forms.manage_translations') }}</a></span></small>
        <i class="localization-error" v-if="!isFormLocalized && showLocalizedValidationError"></i>
    </div>

    <div class="col text-center" :class="{'language-mobile': onSmallScreen, 'has-error': !isFormLocalized && showLocalizedValidationError}" v-if="isFormLocalized || onSmallScreen" v-cloak>
        <small>{{ trans('brackets/admin-ui::admin.forms.choose_translation_to_edit') }}
            <select class="form-control" v-model="currentLocale">
                <option :value="defaultLocale" v-if="onSmallScreen">@{{defaultLocale.toUpperCase()}}</option>
                <option v-for="locale in otherLocales" :value="locale">@{{locale.toUpperCase()}}</option>
            </select>
            <i class="localization-error" v-if="isFormLocalized && showLocalizedValidationError"></i>
            <span>|</span>
            <a href="#" @click.prevent="hideLocalization">{{ trans('brackets/admin-ui::admin.forms.hide') }}</a>
        </small>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('slug'), 'has-success': fields.slug && fields.slug.valid }">
    <label for="slug" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car-model.columns.slug') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.slug" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('slug'), 'form-control-success': fields.slug && fields.slug.valid}" id="slug" name="slug" placeholder="{{ trans('admin.car-model.columns.slug') }}">
        <div v-if="errors.has('slug')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('slug') }}</div>
    </div>
</div>

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('name_{{ $locale }}'), 'has-success': fields.name_{{ $locale }} && fields.name_{{ $locale }}.valid }">
                <label for="name_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.car-model.columns.name') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <input type="text" v-model="form.name.{{ $locale }}" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name_{{ $locale }}'), 'form-control-success': fields.name_{{ $locale }} && fields.name_{{ $locale }}.valid }" id="name_{{ $locale }}" name="name_{{ $locale }}" placeholder="{{ trans('admin.car-model.columns.name') }}">
                    <div v-if="errors.has('name_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('name_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>
{{-- BRAND --}}
<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('brand_id'), 'has-success': this.fields.brand_id && this.fields.brand_id.valid }">
    <label for="brand_id"
           class="col-md-2">{{ trans('admin.forms.brand_name') }}</label>
    <div class="col-md-9 col-xl-8">

        <multiselect
            v-model="form.brand"
            :options="brands"
            :multiple="false"
            track-by="id"
            label="name"
            tag-placeholder="{{ __('Select brand') }}"
            placeholder="{{ __('brand') }}">
        </multiselect>

        <div v-if="errors.has('brand_id')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('brand_id') }}
        </div>
    </div>
</div>
{{-- END BRAND --}}

{{-- BODY TYPE--}}
<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('brand_id'), 'has-success': this.fields.body_id && this.fields.body_type_id.valid }">
    <label for="body_type_id"
           class="col-md-2">{{ trans('admin.forms.body_type_name') }}</label>
    <div class="col-md-9 col-xl-8">

        <multiselect
            v-model="form.body_type"
            :options="body_types"
            :multiple="false"
            track-by="id"
            label="name"
            tag-placeholder="{{ __('Select body_type') }}"
            placeholder="{{ __('body_type') }}">
        </multiselect>

        <div v-if="errors.has('body_type_id')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('body_type_id') }}
        </div>
    </div>
</div>
{{-- END BODY TYPE--}}
{{-- TYPE--}}
<div class="form-group row align-items-center"
     :class="{'has-danger': errors.has('types'), 'has-success': this.fields.types && this.fields.types.valid }">
    <label
           class="col-md-2">{{ trans('adminforms.body_type_name') }}</label>
    <div class="col-md-9 col-xl-8">

        <multiselect
            v-model="form.types"
            :options="availableTypes"
            :multiple="true"
            track-by="id"
            label="name"
            tag-placeholder="{{ __('Select types') }}"
            placeholder="{{ __('types') }}">
        </multiselect>

        <div v-if="errors.has('types')" class="form-control-feedback form-text" v-cloak>@{{
            errors.first('types') }}
        </div>
    </div>
</div>
{{-- TYPE--}}

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_seats'), 'has-success': fields.slug && fields.slug.valid }">
    <label for="attribute_seats" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('trans_rentacar.car.seats') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input
            type="number" min="1"
            v-model="form.attribute_seats"
            v-validate="''"
            @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('attribute_seats'),
            'form-control-success': fields.attribute_seats && fields.attribute_seats.valid}"
            id="attribute_seats" name="attribute_seats" placeholder="{{ trans('trans_rentacar.car.seats') }}">
        <div v-if="errors.has('attribute_seats')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_seats') }}</div>
    </div>
</div>
<!-- attribute_1_to_100 -->
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_1_to_100'), 'has-success': fields.attribute_1_to_100 && fields.attribute_1_to_100.valid }">
    <label for="attribute_1_to_100" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('trans_rentacar.car.0_100_kmh') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input
            type="number" step="0.01" min="0"
            v-model="form.attribute_1_to_100"
            v-validate="''"
            @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('attribute_1_to_100'),
            'form-control-success': fields.attribute_1_to_100 && fields.attribute_1_to_100.valid}"
            id="attribute_1_to_100" name="attribute_1_to_100" placeholder="{{ trans('trans_rentacar.car.0_100_kmh') }}">
        <div v-if="errors.has('attribute_1_to_100')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_1_to_100') }}</div>
    </div>
</div>

<!-- attribute_max_speed -->
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_max_speed'), 'has-success': fields.attribute_max_speed && fields.attribute_max_speed.valid }">
    <label for="attribute_max_speed" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('trans_rentacar.car.max_speed') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input
            type="number" min="0"
            v-model="form.attribute_max_speed"
            v-validate="''"
            @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('attribute_max_speed'),
            'form-control-success': fields.attribute_max_speed && fields.attribute_max_speed.valid}"
            id="attribute_max_speed" name="attribute_max_speed" placeholder="{{ trans('trans_rentacar.car.max_speed') }}">
        <div v-if="errors.has('attribute_max_speed')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_max_speed') }}</div>
    </div>
</div>

<!-- attribute_horsepower -->
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_horsepower'), 'has-success': fields.attribute_horsepower && fields.attribute_horsepower.valid }">
    <label for="attribute_horsepower" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('trans_rentacar.car.horse_power') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input
            type="number" min="0"
            v-model="form.attribute_horsepower"
            v-validate="''"
            @input="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('attribute_horsepower'),
            'form-control-success': fields.attribute_horsepower && fields.attribute_horsepower.valid}"
            id="attribute_horsepower" name="attribute_horsepower" placeholder="{{ trans('trans_rentacar.car.horse_power') }}">
        <div v-if="errors.has('attribute_horsepower')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_horsepower') }}</div>
    </div>
</div>

<!-- attribute_transmission -->
<div class="form-group row align-items-center" :class="{'has-danger': errors.has('attribute_transmission'), 'has-success': fields.attribute_transmission && fields.attribute_transmission.valid }">
    <label for="attribute_transmission" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car-model.columns.attribute_transmission') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select
            v-model="form.attribute_transmission"
            v-validate="'required'"
            @change="validate($event)"
            class="form-control"
            :class="{'form-control-danger': errors.has('attribute_transmission'),
            'form-control-success': fields.attribute_transmission && fields.attribute_transmission.valid}"
            id="attribute_transmission" name="attribute_transmission">
            <option value="automatic">Automatic</option>
            <option value="manual">Manual</option>
        </select>
        <div v-if="errors.has('attribute_transmission')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('attribute_transmission') }}</div>
    </div>
</div>

<!-- status -->
<div class="form-check row" :class="{'has-danger': errors.has('status'), 'has-success': fields.status && fields.status.valid}">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input
            class="form-check-input"
            id="status"
            type="checkbox"
            v-model="form.status"
            v-validate="''"
            data-vv-name="status"
            name="status_fake_element"
        >
        <label class="form-check-label" for="status">
            {{ trans('admin.car.columns.status') }}
        </label>
        <input type="hidden" name="status" :value="form.status">
        <div
            v-if="errors.has('status')"
            class="form-control-feedback form-text"
            v-cloak
        >
            @{{ errors.first('status') }}
        </div>
    </div>
</div>

{{--<div class="form-group row align-items-center" :class="{'has-danger': errors.has('brand_id'), 'has-success': fields.brand_id && fields.brand_id.valid }">--}}
{{--    <label for="brand_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.car-model.columns.brand_id') }}</label>--}}
{{--        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">--}}
{{--        <input type="text" v-model="form.brand_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('brand_id'), 'form-control-success': fields.brand_id && fields.brand_id.valid}" id="brand_id" name="brand_id" placeholder="{{ trans('admin.car-model.columns.brand_id') }}">--}}
{{--        <div v-if="errors.has('brand_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('brand_id') }}</div>--}}
{{--    </div>--}}
{{--</div>--}}


