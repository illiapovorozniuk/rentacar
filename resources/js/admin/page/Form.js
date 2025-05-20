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
                faq: [
                    {
                        question: this.getLocalizedFormDefaults(),
                        answer: this.getLocalizedFormDefaults(),
                    }
                ],

            },
            mediaCollections: ['cover'],
            mediaWysiwygConfig: {
                semantic: false
            }
        }
    },
    methods: {
        addField() {
            if (!this.form.faq) {
                this.form.faq = [];
            }
            this.form.faq.push({
                question: this.getLocalizedFormDefaults(),
                answer: this.getLocalizedFormDefaults(),
            });
        },
        removeField(index) {
            this.form.faq.splice(index, 1);
        },
        resetIfA(newValue, field) {
            if (newValue === 'a') {
                this.form.price_cars_config[field] = []; // скидання вибору
            }
        },

    },

});
