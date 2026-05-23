<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";

defineProps({
    totalProduk: Number,
    totalPenjual: Number,
    categories: Array,
    produkTerbaru: Array,
});
</script>

<template>
    <AppLayout>
        <!-- HERO -->
        <section class="bg-gradient-to-br from-blue-600 to-blue-800 text-white">
            <div class="max-w-7xl mx-auto px-4 py-24 text-center">
                <h1 class="text-5xl font-bold mb-6 leading-tight">
                    Marketplace Modern
                    <br />
                    Untuk Semua Kebutuhan
                </h1>

                <p class="text-xl text-blue-100 max-w-2xl mx-auto">
                    Temukan produk terbaik dari seller terpercaya dengan
                    pengalaman belanja modern.
                </p>

                <div class="mt-10 flex justify-center gap-4">
                    <Link
                        href="/products"
                        class="bg-white text-blue-700 px-8 py-4 rounded-2xl font-semibold hover:bg-blue-50 transition"
                    >
                        Lihat Produk
                    </Link>

                    <Link
                        href="/register"
                        class="border border-white/30 px-8 py-4 rounded-2xl font-semibold hover:bg-white/10 transition"
                    >
                        Mulai Jualan
                    </Link>
                </div>
            </div>
        </section>

        <!-- STATS -->
        <section class="py-16 bg-white">
            <div class="max-w-6xl mx-auto px-4">
                <div class="grid md:grid-cols-2 gap-8">
                    <div class="bg-blue-50 rounded-3xl p-10 text-center">
                        <p class="text-5xl font-bold text-blue-600">
                            {{ totalProduk }}
                        </p>

                        <p class="text-gray-600 mt-3 text-lg">Produk Aktif</p>
                    </div>

                    <div class="bg-green-50 rounded-3xl p-10 text-center">
                        <p class="text-5xl font-bold text-green-600">
                            {{ totalPenjual }}
                        </p>

                        <p class="text-gray-600 mt-3 text-lg">Seller Aktif</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- KATEGORI -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-800">
                        Kategori Populer
                    </h2>

                    <p class="text-gray-500 mt-3">
                        Jelajahi berbagai kategori produk
                    </p>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <Link
                        v-for="category in categories"
                        :key="category.id"
                        :href="`/products?category=${category.slug}`"
                        class="bg-white rounded-2xl p-6 text-center shadow-sm hover:shadow-lg transition"
                    >
                        <div class="text-5xl mb-4">
                            {{ category.icon }}
                        </div>

                        <h3 class="font-semibold text-gray-800">
                            {{ category.name }}
                        </h3>
                    </Link>
                </div>
            </div>
        </section>

        <!-- PRODUK TERBARU -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">
                            Produk Terbaru
                        </h2>

                        <p class="text-gray-500 mt-2">
                            Produk terbaru dari seller pilihan
                        </p>
                    </div>

                    <Link
                        href="/products"
                        class="text-blue-600 hover:underline"
                    >
                        Lihat Semua →
                    </Link>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <Link
                        v-for="product in produkTerbaru"
                        :key="product.id"
                        :href="`/products/${product.slug}`"
                        class="bg-white border rounded-3xl overflow-hidden hover:shadow-xl transition"
                    >
                        <img
                            v-if="product.image"
                            :src="`/storage/${product.image}`"
                            class="w-full h-56 object-cover"
                        />

                        <div class="p-6">
                            <div class="flex gap-2 flex-wrap mb-3">
                                <span
                                    v-for="cat in product.categories"
                                    :key="cat.id"
                                    class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full"
                                >
                                    {{ cat.name }}
                                </span>
                            </div>

                            <h3
                                class="font-bold text-lg text-gray-800 line-clamp-2"
                            >
                                {{ product.name }}
                            </h3>

                            <p class="text-blue-600 font-bold text-xl mt-4">
                                Rp {{ Number(product.price).toLocaleString() }}
                            </p>
                        </div>
                    </Link>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
