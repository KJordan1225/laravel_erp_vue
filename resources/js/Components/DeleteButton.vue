<template>
    <button
        type="button"
        class="btn btn-sm btn-danger"
        @click="confirmDelete"
    >
        Delete
    </button>
</template>

<script setup>
const emit = defineEmits(['confirmed']);

const props = defineProps({
    message: {
        type: String,
        default: 'Are you sure you want to delete this record?',
    },
});

function confirmDelete() {
    if (window.confirm(props.message)) {
        emit('confirmed');
    }
}
</script>
