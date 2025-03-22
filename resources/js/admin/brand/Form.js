import AppForm from '../app-components/Form/AppForm';

Vue.component('brand-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                slug:  '' ,
                name:  '' ,
                icon:  null
            },
            fileUploadError: null
        }
    },
    methods: {
        onFileChange(event) {
            this.form.icon = event.target.files[0];
        },
        onSubmit() {
            let formData = new FormData();
            formData.append('slug', this.form.slug);
            formData.append('name', this.form.name);
            formData.append('icon', this.form.icon);

            axios.post(this.action, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                // handle success
            }).catch(error => {
                // handle error
            });
        }
    }
});
