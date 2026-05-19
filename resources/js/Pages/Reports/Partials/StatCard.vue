<template>
    <div class="erp-card erp-stat-card h-100">
        <div class="erp-card-body">
            <div class="text-muted">{{ title }}</div>
            <h2 class="mb-0">{{ value }}</h2>
        </div>
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
});
</script>
