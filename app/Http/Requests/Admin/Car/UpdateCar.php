<?php

namespace App\Http\Requests\Admin\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateCar extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.car.edit', $this->car);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'car_model' => ['sometimes'],
            'availability_label' => ['sometimes', 'string'],
            'price_1' => ['sometimes', 'numeric'],
            'price_7' => ['sometimes', 'numeric'],
            'price_30' => ['sometimes', 'numeric'],
            'price_31_more' => ['sometimes', 'numeric'],
            'deposit' => ['sometimes', 'integer'],
            'km_included_per_day' => ['sometimes', 'integer'],
            'overlimit_charge_per_km' => ['sometimes', 'numeric'],
            'min_day_reservation' => ['sometimes', 'integer'],
            'free_delivery' => ['sometimes', 'integer'],
            'registration_number' => ['sometimes', 'string'],
            'cars_color' => ['sometimes'],
            'fuel_id' => ['sometimes', 'integer'],
            'attribute_year' => ['sometimes', 'integer'],
            'attribute_seats' => ['nullable', 'integer'],
            'attribute_1_to_100' => ['nullable', 'numeric'],
            'attribute_max_speed' => ['nullable', 'integer'],
            'attribute_horsepower' => ['nullable', 'integer'],
            'attribute_transmission' => ['nullable', 'string'],
            'attribute_doors' => ['nullable', 'integer'],
            'attribute_engine' => ['nullable', 'string'],
            'attribute_baggage' => ['nullable', 'integer'],
            'status' => ['sometimes', 'boolean'],

        ];
    }

    public function getCarModelId(){
        if ($this->has('car_model')){
            return $this->get('car_model')['id'];
        }
        return null;
    }
    public function getCarsColorId(){
        if ($this->has('cars_color')){
            return $this->get('cars_color')['id'];
        }
        return null;
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
