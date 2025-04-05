import AppListing from '../app-components/Listing/AppListing';

Vue.component('car-model-listing', {
    mixins: [AppListing]
    ,data() {
        return {
            showBrandsFilter: false,
            brandsMultiselect: {},

            filters: {
                brands: [],
            },
        }
    },
    watch: {
        showBrandsFilter: function (newVal, oldVal) {
            this.brandsMultiselect = [];
        },
        brandsMultiselect: function(newVal, oldVal) {
            this.filters.brands = newVal.map(function(object) { return object['key']; });
            this.filter('brands', this.filters.brands);
            this.filter('body_types', this.filters.brands);
        }
    }
});
