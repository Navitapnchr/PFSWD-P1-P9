<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    category: Object,
});
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50">
            <!-- HEADER -->
            <section class="bg-white border-b">
                <div class="max-w-7xl mx-auto px-4 py-12">
                    <Link
                        href="/products"
                        class="text-blue-600 hover:underline"
                    >
                        ← Kembali ke katalog
                    </Link>

                    <div class="mt-6">
                        <div class="text-6xl">
                            {{ category.icon }}
                        </div>

                        <h1 class="text-5xl font-bold text-gray-900 mt-5">
                            {{ category.name }}
                        </h1>

                        <p class="text-gray-500 mt-4">
                            {{ category.products.length }} produk tersedia
                        </p>
                    </div>
                </div>
            </section>

            <!-- PRODUCTS -->
            <section class="max-w-7xl mx-auto px-4 py-12">
                <div
                    class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
                >
                    <Link
                        v-for="product in category.products"
                        :key="product.id"
                        :href="`/products/${product.slug}`"
                        class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition"
                    >
                        <img
                            v-if="product.image"
                            :src="`/storage/${product.image}`"
                            class="w-full aspect-square object-cover"
                        />

                        <div class="p-5">
                            <h2
                                class="font-bold text-lg text-gray-800 line-clamp-2"
                            >
                                {{ product.name }}
                            </h2>

                            <p class="text-sm text-gray-500 mt-2">
                                {{
                                    product.seller?.store_name ||
                                    product.seller?.name
                                }}
                            </p>

                            <p class="text-2xl font-bold text-blue-600 mt-5">
                                Rp
                                {{
                                    Number(product.price).toLocaleString(
                                        "id-ID",
                                    )
                                }}
                            </p>
                        </div>
                    </Link>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
