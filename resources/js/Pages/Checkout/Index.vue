<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    cartItems: Array,
    total: Number,
});

const form = useForm({
    shipping_address: "",

    phone: "",

    notes: "",
});

const checkout = () => {
    form.post("/checkout");
};
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-4xl font-bold text-gray-900 mb-10">Checkout</h1>

                <div class="grid lg:grid-cols-3 gap-10">
                    <!-- LEFT -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-3xl shadow-sm p-8">
                            <h2 class="text-2xl font-bold mb-8">
                                Produk Checkout
                            </h2>

                            <div
                                v-for="item in cartItems"
                                :key="item.id"
                                class="flex gap-5 border-b py-5"
                            >
                                <img
                                    v-if="item.product.image"
                                    :src="`/storage/${item.product.image}`"
                                    class="w-28 h-28 object-cover rounded-2xl"
                                />

                                <div class="flex-1">
                                    <h3 class="font-bold text-lg">
                                        {{ item.product.name }}
                                    </h3>

                                    <p class="text-gray-500 mt-2">
                                        Qty: {{ item.qty }}
                                    </p>

                                    <p
                                        class="text-blue-600 font-bold text-xl mt-4"
                                    >
                                        Rp
                                        {{
                                            Number(
                                                item.product.price * item.qty,
                                            ).toLocaleString("id-ID")
                                        }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div>
                        <div
                            class="bg-white rounded-3xl shadow-sm p-8 sticky top-10"
                        >
                            <h2 class="text-2xl font-bold mb-8">
                                Informasi Pengiriman
                            </h2>

                            <!-- ALAMAT -->
                            <div class="mb-5">
                                <label class="block mb-2 font-medium">
                                    Alamat
                                </label>

                                <textarea
                                    v-model="form.shipping_address"
                                    rows="4"
                                    class="w-full rounded-2xl border-gray-300"
                                />
                            </div>

                            <!-- PHONE -->
                            <div class="mb-5">
                                <label class="block mb-2 font-medium">
                                    Nomor HP
                                </label>

                                <input
                                    v-model="form.phone"
                                    type="text"
                                    class="w-full rounded-2xl border-gray-300"
                                />
                            </div>

                            <!-- NOTES -->
                            <div class="mb-8">
                                <label class="block mb-2 font-medium">
                                    Catatan
                                </label>

                                <textarea
                                    v-model="form.notes"
                                    rows="3"
                                    class="w-full rounded-2xl border-gray-300"
                                />
                            </div>

                            <!-- TOTAL -->
                            <div class="border-t pt-6">
                                <div class="flex justify-between text-lg">
                                    <span>Total</span>

                                    <span class="font-bold text-blue-600">
                                        Rp
                                        {{
                                            Number(total).toLocaleString(
                                                "id-ID",
                                            )
                                        }}
                                    </span>
                                </div>
                            </div>

                            <!-- BUTTON -->
                            <button
                                @click="checkout"
                                :disabled="form.processing"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl mt-8 transition"
                            >
                                Checkout Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
