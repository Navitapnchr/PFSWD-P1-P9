<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    order: Object,
});

const form = useForm({
    payment_proof: null,
});

const previewUrl = ref(null);

const rupiah = (n) =>
    new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        maximumFractionDigits: 0,
    }).format(n);

const onFileChange = (e) => {
    form.payment_proof = e.target.files[0];
    previewUrl.value = URL.createObjectURL(form.payment_proof);
};

const submit = () => {
    form.post(route("orders.payment.upload", props.order.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <AppLayout>
        <Head title="Upload Bukti Pembayaran" />

        <div class="max-w-2xl mx-auto px-4 py-8">

            <Link
                :href="route('orders.index')"
                class="text-gray-500 hover:text-gray-700 text-sm"
            >
                ← Kembali ke Pesanan Saya
            </Link>

            <h1 class="text-2xl font-bold mt-4 mb-6">
                Upload Bukti Pembayaran
            </h1>

            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 mb-6">
                <p class="text-sm text-gray-500">
                    Nomor Pesanan
                </p>

                <p class="font-bold">
                    {{ order.order_number }}
                </p>

                <p class="text-2xl font-bold text-blue-600 mt-2">
                    {{ rupiah(order.total_amount) }}
                </p>

                <p class="text-xs text-gray-500 mt-1">
                    Transfer sesuai nominal di atas.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-6">

                <div v-if="previewUrl" class="mb-5">
                    <img
                        :src="previewUrl"
                        class="w-64 rounded-lg border"
                    />
                </div>

                <input
                    type="file"
                    accept="image/*"
                    @change="onFileChange"
                    class="block w-full border rounded-lg p-3"
                />

                <p
                    v-if="form.errors.payment_proof"
                    class="text-red-500 text-sm mt-2"
                >
                    {{ form.errors.payment_proof }}
                </p>

                <button
                    @click="submit"
                    :disabled="!form.payment_proof || form.processing"
                    class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg disabled:opacity-50"
                >
                    {{
                        form.processing
                            ? "Mengirim..."
                            : "Kirim Bukti Pembayaran"
                    }}
                </button>

            </div>

        </div>
    </AppLayout>
</template>