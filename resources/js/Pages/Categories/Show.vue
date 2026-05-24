<script setup>
defineProps({
    category: Object,
})
</script>

<template>
    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="mb-8">
            <h1 class="text-4xl font-bold">
                {{ category.name }}
            </h1>

            <p class="text-gray-500 mt-2">
                Daftar produk kategori {{ category.name }}
            </p>
        </div>

        <div
            v-if="category.products.length"
            class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6"
        >
            <div
                v-for="product in category.products"
                :key="product.id"
                class="bg-white rounded-2xl shadow p-4"
            >
                <img
                    :src="product.image
                        ? '/storage/' + product.image
                        : 'https://placehold.co/400'"
                    class="w-full h-52 object-cover rounded-xl"
                />

                <h2 class="font-bold text-lg mt-4">
                    {{ product.name }}
                </h2>

                <p class="text-blue-600 font-bold text-xl mt-2">
                    Rp {{ Number(product.price).toLocaleString('id-ID') }}
                </p>

                <p class="text-sm text-gray-500 mt-1">
                    Seller:
                    {{ product.seller?.name }}
                </p>

                <a
                    :href="`/products/${product.slug}`"
                    class="block text-center mt-4 bg-blue-600 text-white py-2 rounded-xl hover:bg-blue-700"
                >
                    Lihat Produk
                </a>
            </div>
        </div>

        <div
            v-else
            class="bg-white rounded-2xl shadow p-10 text-center"
        >
            <h2 class="text-2xl font-bold">
                Belum ada produk
            </h2>
        </div>

    </div>
</template>