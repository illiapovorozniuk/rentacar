<?php

namespace App\Http\Requests\Admin\CarModel;

use Brackets\Translatable\TranslatableFormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCarModel extends TranslatableFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.car-model.edit', $this->carModel);
    }

/**
     * Get the validation rules that apply to the requests untranslatable fields.
     *
     * @return array
     */
    public function untranslatableRules(): array {
        return [
            'slug' => ['sometimes', Rule::unique('car_models', 'slug')->ignore($this->carModel->getKey(), $this->carModel->getKeyName()), 'string'],
            'brand' => ['sometimes'],
            'body_type' => ['sometimes'],
            'attribute_seats' => ['sometimes', 'nullable', 'integer'],
            'attribute_1_to_100' => ['sometimes', 'nullable', 'numeric'],
            'attribute_max_speed' => ['sometimes', 'nullable', 'integer'],
            'attribute_horsepower' => ['sometimes', 'nullable', 'integer'],
            'attribute_transmission' => ['sometimes', 'nullable', 'string', 'in:automatic,manual'],
            'status' => ['sometimes', 'nullable', 'integer'],
            'types' => ['required'],

        ];
    }

    /**
     * Get the validation rules that apply to the requests translatable fields.
     *
     * @return array
     */
    public function translatableRules($locale): array {
        return [
            'name' => ['sometimes', 'string'],

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

    public function getBrandId(){
        if ($this->has('brand')){
            return $this->get('brand')['id'];
        }
        return null;
    }

    public function getBodyTypeId(){
        if ($this->has('body_type')){
            return $this->get('body_type')['id'];
        }
        return null;
    }

    public function getTypes(): array
    {
        if ($this->has('types')) {
            $tags = $this->get('types');
            return array_column($tags, 'id');
        }
        return [];
    }
}
