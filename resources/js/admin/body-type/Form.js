import AppForm from '../app-components/Form/AppForm';

Vue.component('body-type-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                slug:  '' ,
                name:  this.getLocalizedFormDefaults() ,
                icon:  '' ,
                
            }
        }
    }

});