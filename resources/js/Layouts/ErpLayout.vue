<template>
    <div class="erp-layout">
        <aside class="erp-sidebar">
            <div class="erp-sidebar-brand">
                Laravel ERP
            </div>

            <Link href="/dashboard">Dashboard</Link>
            <Link href="/customers">Customers</Link>
            <Link href="/vendors">Vendors</Link>
            <Link href="/categories">Categories</Link>
            <Link href="/products">Products</Link>
            <Link href="/inventory">Inventory</Link>
            <Link href="/sales-orders">Sales Orders</Link>
            <Link href="/purchase-orders">Purchase Orders</Link>
            <Link href="/invoices">Invoices</Link>
            <Link href="/payments">Payments</Link>
            <Link href="/expenses">Expenses</Link>
            <Link href="/reports">Reports</Link>
            <Link href="/company-settings">Company Settings</Link>
            <Link href="/profile">Profile</Link>
        </aside>

        <main class="erp-main">
            <header class="erp-topbar">
                <div>
                    <strong>{{ title }}</strong>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <span>{{ userName }}</span>

                    <form method="post" action="/logout">
                        <input type="hidden" name="_token" :value="csrfToken">
                        <button class="btn btn-sm btn-erp-orange" type="submit">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <section class="erp-content">
                <slot />
            </section>
        </main>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

defineProps({
    title: {
        type: String,
        default: 'ERP',
    },
});

const page = usePage();

const userName = computed(() => {
    return page.props.auth?.user?.name || 'User';
});

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content') || '';
</script>
Important fix: add CSRF meta tag to resources/views/app.blade.php.
Update it to:
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel ERP') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
