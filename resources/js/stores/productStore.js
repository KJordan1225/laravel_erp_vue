import { defineStore } from 'pinia';
import axios from 'axios';

export const useProductStore = defineStore('productStore', {
    state: () => ({
        products: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchProducts() {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.get('/products');
                this.products = response.data.products || [];
            } catch (error) {
                this.error = 'Unable to load products.';
            } finally {
                this.loading = false;
            }
        },
    },
});
