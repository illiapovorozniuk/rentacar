import AppForm from '../app-components/Form/AppForm';

Vue.component('car-model-form', {
    mixins: [AppForm],
    props: [
        'brands',
        'body_types',
        'availableTypes',
    ],
    data: function() {
        return {
            form: {
                slug:  '' ,
                name:  this.getLocalizedFormDefaults() ,
                brand:  '' ,
                body_type:  '' ,
                types:  '' ,
                count_of_seats:  '' ,
                one_to_100:  '' ,
                max_speed:  '' ,
                horsepower: '',
                status:  '' ,
                attribute_transmission: 'automatic',
            }
        }
    }

});
