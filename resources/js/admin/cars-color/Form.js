import AppForm from '../app-components/Form/AppForm';
import ColorPicker from 'one-colorpicker/src/color/colorPicker/colorpicker.vue';
import ColorPanel from 'one-colorpicker/src/color/colorPanel/colorpanel.vue';

Vue.component('color-picker', ColorPicker);
Vue.component('color-panel', ColorPanel);
Vue.component('cars-color-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                slug:  '' ,
                name:  this.getLocalizedFormDefaults() ,
                color_code:  '' ,

            }
        }
    }

});
