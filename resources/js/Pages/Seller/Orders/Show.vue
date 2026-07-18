<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, Head } from "@inertiajs/vue3";

const props = defineProps({
    order: Object,
});

const rupiah = (n) =>
    new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        maximumFractionDigits: 0,
    }).format(n);
</script>

<template>
    <AppLayout>
        <Head :title="'Order ' + order.order_number" />

        <div class="max-w-3xl mx-auto px-4 py-8">

            <Link
                :href="route('seller.orders.index')"
                class="text-gray-500 text-sm"
            >
                ← Kembali ke Pesanan Masuk
            </Link>

            <div class="flex justify-between items-center mt-3 mb-6">
                <h1 class="text-2xl font-bold">
                    {{ order.order_number }}
                </h1>

                <span class="px-4 py-1 rounded-full bg-gray-100">
                    {{ order.status }}
                </span>
            </div>

            <!-- ITEM -->
            <div class="bg-white rounded-xl shadow p-6 mb-6">
                <h2 class="font-bold mb-4">
                    Item Pesanan
                </h2>

                <table class="w-full">
                    <tr
                        v-for="item in order.items"
                        :key="item.id"
                        class="border-b"
                    >
                        <td class="py-2">
                            {{ item.product_name }}
                        </td>

                        <td class="text-right">
                            {{ rupiah(item.price) }} × {{ item.qty }}
                        </td>

                        <td class="text-right font-bold">
                            {{ rupiah(item.price * item.qty) }}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" class="text-right font-bold pt-3">
                            Total
                        </td>

                        <td class="text-right text-red-600 font-bold pt-3">
                            {{ rupiah(order.total_amount) }}
                        </td>
                    </tr>
                </table>
            </div>

            <!-- BUKTI PEMBAYARAN -->
            <div
                v-if="order.payment_proof"
                class="bg-white rounded-xl shadow p-6 mb-6"
            >
                <h2 class="font-bold mb-4">
                    Bukti Pembayaran
                </h2>

                <img
                    :src="'/storage/' + order.payment_proof"
                    class="max-w-sm rounded-lg border mb-5"
                />

                <!-- VERIFY & REJECT -->
                <div
                    v-if="order.status === 'paid'"
                    class="flex gap-3"
                >
                    <Link
                        :href="route('seller.orders.verify', order.id)"
                        method="post"
                        as="button"
                        class="flex-1 bg-green-600 text-white py-3 rounded-lg"
                    >
                        Verify
                    </Link>

                    <Link
                        :href="route('seller.orders.reject', order.id)"
                        method="post"
                        as="button"
                        class="flex-1 bg-red-600 text-white py-3 rounded-lg"
                    >
                        Reject
                    </Link>
                </div>

                <!-- SHIP -->
                <div
                    v-if="order.status === 'processing'"
                    class="mt-4"
                >
                    <Link
                        :href="route('seller.orders.ship', order.id)"
                        method="post"
                        as="button"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold"
                    >
                        🚚 Tandai Sudah Dikirim
                    </Link>
                </div>

            </div>

            <!-- PENGIRIMAN -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="font-bold mb-3">
                    Alamat Pengiriman
                </h2>

                <p>{{ order.shipping_address }}</p>

                <p class="mt-2 text-gray-500">
                    {{ order.phone }}
                </p>
            </div>

        </div>
    </AppLayout>
</template>