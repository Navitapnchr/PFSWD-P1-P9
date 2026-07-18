<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, router } from "@inertiajs/vue3";

defineProps({
    orders: Object,
    filters: Object,
});

const cancelOrder = (id) => {
    if (confirm("Batalkan pesanan?")) {
        router.post(`/orders/${id}/cancel`);
    }
};
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="max-w-6xl mx-auto px-4">
                <h1 class="text-4xl font-bold mb-10">Pesanan Saya</h1>

                <div class="flex gap-3 mb-8 flex-wrap">
                    <button @click="router.get('/orders')" class="px-5 py-2 rounded-xl border">
                        Semua
                    </button>

                    <button @click="router.get('/orders?status=pending')" class="px-5 py-2 rounded-xl border">
                        Pending
                    </button>

                    <button @click="router.get('/orders?status=paid')" class="px-5 py-2 rounded-xl border">
                        Paid
                    </button>

                    <button @click="router.get('/orders?status=shipped')" class="px-5 py-2 rounded-xl border">
                        Shipped
                    </button>

                    <button @click="router.get('/orders?status=delivered')" class="px-5 py-2 rounded-xl border">
                        Delivered
                    </button>

                    <button @click="router.get('/orders?status=cancelled')" class="px-5 py-2 rounded-xl border">
                        Cancelled
                    </button>
                </div>

                <div
                    v-for="order in orders.data"
                    :key="order.id"
                    class="bg-white rounded-3xl p-8 shadow-sm mb-5"
                >
                    <div class="flex justify-between">
                        <div>
                            <h2 class="font-bold text-xl">
                                {{ order.order_number }}
                            </h2>

                            <p class="text-gray-500 mt-2 capitalize">
                                {{ order.status }}
                            </p>
                        </div>

                        <div class="text-right">
                            <p class="text-blue-600 font-bold text-2xl">
                                Rp {{ Number(order.total_amount).toLocaleString("id-ID") }}
                            </p>
                        </div>
                    </div>

                    <div
                        v-if="order.status === 'pending'"
                        class="mt-5 flex gap-3"
                    >
                        <!-- Tombol Bayar -->
                        <Link
                            :href="`/orders/${order.id}/payment`"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl"
                        >
                            Bayar
                        </Link>

                        <!-- Tombol Batal -->
                        <button
                            @click="cancelOrder(order.id)"
                            class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl"
                        >
                            Batalkan Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>