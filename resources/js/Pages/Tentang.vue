<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
defineProps({
    judul: String,
    deskripsi: String,
    fitur: Array,
});
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-100 py-12 px-4">
            <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm p-8">
                <h1 class="text-4xl font-bold text-blue-600 mb-6">
                    {{ judul }}
                </h1>

                <p class="text-gray-600 mb-8">
                    {{ deskripsi }}
                </p>

                <h2 class="text-2xl font-semibold mb-4">Fitur Aplikasi</h2>

                <ul class="space-y-3">
                    <li
                        v-for="(item, index) in fitur"
                        :key="index"
                        class="bg-blue-50 border border-blue-100 rounded-lg p-4"
                    >
                        {{ item }}
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>
