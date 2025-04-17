<?php

namespace App\Http\Requests\Admin\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCar extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.car.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'car_model' => ['required'],
            'availability_label' => ['required', 'string'],
            'price_1' => ['required', 'numeric'],
            'price_7' => ['required', 'numeric'],
            'price_30' => ['required', 'numeric'],
            'price_31_more' => ['required', 'numeric'],
            'deposit' => ['required', 'integer'],
            'km_included_per_day' => ['required', 'integer'],
            'overlimit_charge_per_km' => ['required', 'numeric'],
            'min_day_reservation' => ['required', 'integer'],
            'free_delivery' => ['required', 'integer'],
            'registration_number' => ['required', 'string'],
            'color_id' => ['required', 'string'],
            'fuel_id' => ['required', 'integer'],
            'attribute_year' => ['required', 'integer'],
            'attribute_seats' => ['nullable', 'integer'],
            'attribute_1_to_100' => ['nullable', 'numeric'],
            'attribute_max_speed' => ['nullable', 'integer'],
            'attribute_horsepower' => ['nullable', 'integer'],
            'attribute_transmission' => ['nullable', 'string'],
            'attribute_doors' => ['nullable', 'integer'],
            'attribute_engine' => ['nullable', 'string'],
            'attribute_baggage' => ['nullable', 'integer'],
            'status' => ['required', 'boolean'],
        ];
    }

    public function getCarModelId(){
        if ($this->has('car_model')){
            return $this->get('car_model')['id'];
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
