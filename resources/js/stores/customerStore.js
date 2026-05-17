import { defineStore } from 'pinia';
import axios from 'axios';

export const useCustomerStore = defineStore('customerStore', {
    state: () => ({
        customers: [],
        loading: false,
        error: null,
    }),

    actions: {
        async fetchCustomers() {
            this.loading = true;
            this.error = null;

            try {
                const response = await axios.get('/customers');
                this.customers = response.data.customers || [];
            } catch (error) {
                this.error = 'Unable to load customers.';
            } finally {
                this.loading = false;
            }
        },
    },
});
