import AppForm from '../app-components/Form/AppForm';

Vue.component('page-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                title:  this.getLocalizedFormDefaults() ,
                link:  '' ,
                type:  '' ,
                h1:  this.getLocalizedFormDefaults() ,
                description:  this.getLocalizedFormDefaults() ,
                content:  this.getLocalizedFormDefaults() ,
                enabled:  false ,
                faq:  '' ,
                
            }
        }
    }

});