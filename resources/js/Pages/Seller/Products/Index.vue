<script setup>
import { Link, router } from '@inertiajs/vue3'

defineProps({
    products: Object,
})

const hapusProduk = (id) => {
    if (confirm('Yakin mau hapus produk ini?')) {
        router.delete(route('seller.products.destroy', id))
    }
}
</script>

<template>
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">
                    Produk Saya
                </h1>

                <p class="text-gray-500 mt-1">
                    Kelola semua produk toko Anda
                </p>
            </div>

            <Link
                :href="route('seller.products.create')"
                class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700"
            >
                + Tambah Produk
            </Link>
        </div>

        <div
            v-if="products.data.length"
            class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6"
        >
            <div
                v-for="product in products.data"
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
                    Stock: {{ product.stock }}
                </p>

                <div class="flex gap-2 mt-4">
                    <Link
                        :href="route('products.show', product.slug)"
                        class="flex-1 text-center bg-gray-200 py-2 rounded-lg hover:bg-gray-300"
                    >
                        Detail
                    </Link>

                    <button
                        @click="hapusProduk(product.id)"
                        class="flex-1 bg-red-500 text-white py-2 rounded-lg hover:bg-red-600"
                    >
                        Hapus
                    </button>
                </div>
            </div>
        </div>

        <div
            v-else
            class="bg-white rounded-2xl p-10 text-center shadow"
        >
            <h2 class="text-2xl font-bold mb-2">
                Belum ada produk
            </h2>

            <p class="text-gray-500">
                Tambahkan produk pertama Anda sekarang.
            </p>
        </div>
    </div>
</template>