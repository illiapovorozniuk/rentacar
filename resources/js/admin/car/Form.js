import AppForm from '../app-components/Form/AppForm';

Vue.component('car-form', {
    mixins: [AppForm],
    props: [
        'car_models',
        'cars_colors',
        'fuels',
    ],
    data: function() {
        return {
            form: {
                car_model:  '' ,
                availability_label:  '' ,
                price_1:  0 ,
                price_7:  0 ,
                price_30:  0 ,
                price_31_more:  0 ,
                deposit:  0 ,
                km_included_per_day:  300 ,
                overlimit_charge_per_km:  '' ,
                min_day_reservation:  '' ,
                free_delivery:  '' ,
                registration_number:  '' ,
                cars_color:  '' ,
                fuel:  '' ,
                attribute_year:  '' ,
                attribute_seats:  '' ,
                attribute_1_to_100:  '' ,
                attribute_max_speed:  '' ,
                attribute_horsepower:  '' ,
                attribute_transmission:  '' ,
                attribute_doors:  '' ,
                attribute_engine:  '' ,
                attribute_baggage:  '' ,
                status:  false ,

            }
        }
    }

});
