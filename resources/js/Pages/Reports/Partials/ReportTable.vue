<template>
    <div class="erp-card h-100">
        <div class="erp-card-header">
            {{ title }}
        </div>

        <div class="erp-card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr>
                            <th
                                v-for="header in headers"
                                :key="header"
                            >
                                {{ header }}
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="(row, rowIndex) in rows"
                            :key="rowIndex"
                        >
                            <td
                                v-for="(cell, cellIndex) in row"
                                :key="cellIndex"
                            >
                                {{ cell }}
                            </td>
                        </tr>

                        <tr v-if="rows.length === 0">
                            <td
                                :colspan="headers.length"
                                class="text-center text-muted"
                            >
                                No records found.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    headers: {
        type: Array,
        default: () => [],
    },
    rows: {
        type: Array,
        default: () => [],
    },
});
</script>
