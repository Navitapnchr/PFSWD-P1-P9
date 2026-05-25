<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { router, Link } from "@inertiajs/vue3";

defineProps({
    cartItems: Array,
    total: Number,
});

const removeItem = (id) => {
    if (confirm("Hapus produk?")) {
        router.delete(`/cart/${id}`);
    }
};
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="max-w-6xl mx-auto px-4">
                <h1 class="text-4xl font-bold mb-10">Keranjang Belanja</h1>

                <div v-if="cartItems.length" class="grid lg:grid-cols-3 gap-10">
                    <!-- ITEMS -->
                    <div class="lg:col-span-2">
                        <div
                            v-for="item in cartItems"
                            :key="item.id"
                            class="bg-white rounded-3xl p-6 mb-5 shadow-sm flex gap-5"
                        >
                            <img
                                v-if="item.product.image"
                                :src="`/storage/${item.product.image}`"
                                class="w-28 h-28 object-cover rounded-2xl"
                            />

                            <div class="flex-1">
                                <h2 class="font-bold text-xl">
                                    {{ item.product.name }}
                                </h2>

                                <p class="text-gray-500 mt-2">
                                    Qty: {{ item.qty }}
                                </p>

                                <p
                                    class="text-blue-600 font-bold text-2xl mt-4"
                                >
                                    Rp
                                    {{
                                        Number(
                                            item.product.price * item.qty,
                                        ).toLocaleString("id-ID")
                                    }}
                                </p>
                            </div>

                            <button
                                @click="removeItem(item.id)"
                                class="text-red-500"
                            >
                                Hapus
                            </button>
                        </div>
                    </div>

                    <!-- TOTAL -->
                    <Link
                        href="/checkout"
                        class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl mt-8 transition"
                    >
                        Checkout
                    </Link>
                    <div>
                        <div
                            class="bg-white rounded-3xl p-8 shadow-sm sticky top-10"
                        >
                            <h2 class="text-2xl font-bold mb-6">Ringkasan</h2>

                            <div class="flex justify-between mb-5">
                                <span>Total</span>

                                <span class="font-bold text-blue-600 text-xl">
                                    Rp
                                    {{ Number(total).toLocaleString("id-ID") }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    v-else
                    class="bg-white rounded-3xl p-10 text-center text-gray-500"
                >
                    Keranjang masih kosong.
                </div>
            </div>
        </div>
    </AppLayout>
</template>
