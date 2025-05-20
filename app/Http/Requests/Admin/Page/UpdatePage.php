<?php

namespace App\Http\Requests\Admin\Page;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePage extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.page.edit', $this->page);
    }

/**
     * Get the validation rules that apply to the requests untranslatable fields.
     *
     * @return array
     */
    public function untranslatableRules(): array {
        return [
            'link' => ['sometimes', Rule::unique('pages', 'link')->ignore($this->page->getKey(), $this->page->getKeyName()), 'string'],
            'type' => ['sometimes', 'string'],
            'enabled' => ['sometimes', 'boolean'],
            'faq' => ['nullable'],


        ];
    }

    /**
     * Get the validation rules that apply to the requests translatable fields.
     *
     * @return array
     */
    public function translatableRules($locale): array {
        return [
            'title' => ['sometimes', 'string'],
            'h1' => ['nullable', 'string'],
            'description' => ['sometimes', 'string'],
            'content' => ['nullable', 'string'],

        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
