<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    stats: Object,
});
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4">
                <h1 class="text-4xl font-bold mb-10">Dashboard Buyer</h1>

                <div class="grid md:grid-cols-3 gap-8">
                    <div
                        class="bg-blue-600 text-white rounded-3xl p-8 shadow-lg"
                    >
                        <p class="text-lg opacity-80">Total Pesanan</p>

                        <h2 class="text-5xl font-bold mt-4">
                            {{ stats.total_orders }}
                        </h2>
                    </div>

                    <div
                        class="bg-yellow-500 text-white rounded-3xl p-8 shadow-lg"
                    >
                        <p class="text-lg opacity-80">Pesanan Pending</p>

                        <h2 class="text-5xl font-bold mt-4">
                            {{ stats.pending_orders }}
                        </h2>
                    </div>

                    <div
                        class="bg-green-600 text-white rounded-3xl p-8 shadow-lg"
                    >
                        <p class="text-lg opacity-80">Total Belanja</p>

                        <h2 class="text-3xl font-bold mt-4">
                            Rp
                            {{
                                Number(stats.monthly_spending).toLocaleString(
                                    "id-ID",
                                )
                            }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
