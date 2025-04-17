import AppForm from '../app-components/Form/AppForm';

Vue.component('car-form', {
    mixins: [AppForm],
    props: [
        'car_models',
    ],
    data: function() {
        return {
            form: {
                car_model:  '' ,
                availability_label:  '' ,
                price_1:  '' ,
                price_7:  '' ,
                price_30:  '' ,
                price_31_more:  '' ,
                deposit:  '' ,
                km_included_per_day:  '' ,
                overlimit_charge_per_km:  '' ,
                min_day_reservation:  '' ,
                free_delivery:  '' ,
                registration_number:  '' ,
                color_id:  '' ,
                fuel_id:  '' ,
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
