<div class="row form-inline" style="padding-bottom: 10px;" v-cloak>
    <div :class="{'col-xl-10 col-md-11 text-right': !isFormLocalized, 'col text-center': isFormLocalized, 'hidden': onSmallScreen }">
        <small>{{ trans('brackets/admin-ui::admin.forms.currently_editing_translation') }}
            <span v-if="!isFormLocalized && otherLocales.length > 1"> {{ trans('brackets/admin-ui::admin.forms.more_can_be_managed') }}</span><span v-if="!isFormLocalized"> | <a href="#" @click.prevent="showLocalization">{{ trans('brackets/admin-ui::admin.forms.manage_translations') }}</a></span></small>
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

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('title_{{ $locale }}'), 'has-success': fields.title_{{ $locale }} && fields.title_{{ $locale }}.valid }">
                <label for="title_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.page.columns.title') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <input type="text" v-model="form.title.{{ $locale }}" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('title_{{ $locale }}'), 'form-control-success': fields.title_{{ $locale }} && fields.title_{{ $locale }}.valid }" id="title_{{ $locale }}" name="title_{{ $locale }}" placeholder="{{ trans('admin.page.columns.title') }}">
                    <div v-if="errors.has('title_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('title_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('h1_{{ $locale }}'), 'has-success': fields.h1_{{ $locale }} && fields.h1_{{ $locale }}.valid }">
                <label for="h1_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.page.columns.h1') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <input type="text" v-model="form.h1.{{ $locale }}" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('h1_{{ $locale }}'), 'form-control-success': fields.h1_{{ $locale }} && fields.h1_{{ $locale }}.valid }" id="h1_{{ $locale }}" name="h1_{{ $locale }}" placeholder="{{ trans('admin.page.columns.h1') }}">
                    <div v-if="errors.has('h1_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('h1_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('description_{{ $locale }}'), 'has-success': fields.description_{{ $locale }} && fields.description_{{ $locale }}.valid }">
                <label for="description_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.page.columns.description') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <div>
                        <wysiwyg v-model="form.description.{{ $locale }}" v-validate="'required'" id="description_{{ $locale }}" name="description_{{ $locale }}" :config="mediaWysiwygConfig"></wysiwyg>
                    </div>
                    <div v-if="errors.has('description_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('description_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach($locales as $locale)
        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div class="form-group row align-items-center" :class="{'has-danger': errors.has('content_{{ $locale }}'), 'has-success': fields.content_{{ $locale }} && fields.content_{{ $locale }}.valid }">
                <label for="content_{{ $locale }}" class="col-md-2 col-form-label text-md-right">{{ trans('admin.page.columns.content') }}</label>
                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                    <div>
                        <wysiwyg v-model="form.content.{{ $locale }}" v-validate="''" id="content_{{ $locale }}" name="content_{{ $locale }}" :config="mediaWysiwygConfig"></wysiwyg>
                    </div>
{{--                    <input type="text" v-model="form.content.{{ $locale }}" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('content_{{ $locale }}'), 'form-control-success': fields.content_{{ $locale }} && fields.content_{{ $locale }}.valid }" id="content_{{ $locale }}" name="content_{{ $locale }}" placeholder="{{ trans('admin.page.columns.content') }}">--}}
                    <div v-if="errors.has('content_{{ $locale }}')" class="form-control-feedback form-text" v-cloak>{{'{{'}} errors.first('content_{{ $locale }}') }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('link'), 'has-success': fields.link && fields.link.valid }">
    <label for="link" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.page.columns.link') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.link" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('link'), 'form-control-success': fields.link && fields.link.valid}" id="link" name="link" placeholder="{{ trans('admin.page.columns.link') }}">
        <div v-if="errors.has('link')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('link') }}</div>
    </div>
</div>
<div class="form-group row align-items-center">
    <label for="link" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.page.columns.type') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <select v-model="form.type" v-validate="'required'" class="form-control"
                :class="{'form-control-danger': errors.has('type'),'form-control-success': fields.type && fields.type.valid}"
                id="type" name="type">
            @foreach(\App\Enums\PageType::cases() as $type)
                <option value="{{ $type->value }}">{{ $type->value }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-check row" :class="{'has-danger': errors.has('enabled'), 'has-success': fields.enabled && fields.enabled.valid }">
    <div class="ml-md-auto" :class="isFormLocalized ? 'col-md-8' : 'col-md-10'">
        <input class="form-check-input" id="enabled" type="checkbox" v-model="form.enabled" v-validate="''" data-vv-name="enabled" name="enabled_fake_element">
        <label class="form-check-label" for="enabled">
            {{ trans('admin.page.columns.enabled') }}
        </label>
        <input type="hidden" name="enabled" :value="form.enabled">
        <div v-if="errors.has('enabled')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('enabled') }}</div>
    </div>
</div>

<div class="row">
    @if( $mode == 'edit' )
        <div class="col-12">
                    <span data-field="faq" data-type="seo" data-entity="page" data-id="{{$page->id}}"
                          class="btn btn-primary trans-popup">Translate FAQ</span>
        </div>
    @endif
    @foreach($locales as $locale)

        <div class="col-md" v-show="shouldShowLangGroup('{{ $locale }}')" v-cloak>
            <div v-for="(item, index) in form.faq" :key="index" class="form-group row align-items-center clone-row">
                <!-- Existing code for each item -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-center" style="margin-top:27px;">
                            <span class="btn btn-danger btn-xs pull-right btn-del-select py-0" @click="removeField(index)">Remove</span>
                        </div>
                        <div class="col-12  pt-2">
                            <div class="row">
                                <label class="col-md-2 col-form-label text-md-right">Question</label>
                                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                                    <div>
                                        <input type="text" class="form-control" v-model="item.question.{{ $locale }}" :name="'faq[' + index + '][question_{{ $locale }}]'">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 pt-2">
                            <div class="row">
                                <label class="col-md-2 col-form-label text-md-right">Answer</label>
                                <div class="col-md-9" :class="{'col-xl-8': !isFormLocalized }">
                                    <div>
                                        <wysiwyg v-model="item.answer.{{ $locale }}" :config="mediaWysiwygConfig" :name="'faq[' + index + '][answer_{{ $locale }}]'"></wysiwyg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-flex justify-content-center pt-2" style="margin-left: 5px;">
                <span class="btn btn-secondary btn-xs add-select py-0" @click="addField">Add FAQ</span>
            </div>
        </div>
    @endforeach
</div>
@if($mode === 'edit' )
    @include('brackets/admin-ui::admin.includes.media-uploader', [
    'mediaCollection' => $page->getMediaCollection('cover'),
    'media' => $page->getThumbs200ForCollection('cover'),
    'label' => 'Cover'
    ])
@else
    @include('brackets/admin-ui::admin.includes.media-uploader', [
    'mediaCollection' => app(App\Models\Page::class)->getMediaCollection('cover'),
    'label' => 'Cover'
    ])
@endif

