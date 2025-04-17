<?php

namespace App\Http\Requests\Admin\Car;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class IndexCar extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.car.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,car_model_id,availability_label,price_1,price_7,price_30,price_31_more,deposit,km_included_per_day,overlimit_charge_per_km,min_day_reservation,free_delivery,registration_number,color_id,attribute_year,attribute_seats,attribute_1_to_100,attribute_max_speed,attribute_horsepower,attribute_transmission,attribute_doors,attribute_engine,attribute_baggage,status|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
