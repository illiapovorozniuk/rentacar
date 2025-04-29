import AppForm from '../app-components/Form/AppForm';

Vue.component('currency-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                slug:  '' ,
                sign:  '' ,
                exchange_rate:  '' ,
                
            }
        }
    }

});