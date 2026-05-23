<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    products: Object,
    filters: Object,
});

const search = ref(props.filters?.search || "");

const deleteProduct = (id) => {
    if (confirm("Yakin ingin menghapus produk ini?")) {
        router.delete(`/seller/products/${id}`);
    }
};
</script>

<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 py-8">
            <!-- HEADER -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Produk Saya
                    </h1>

                    <p class="text-gray-500 mt-1">Kelola produk toko Anda</p>
                    <form
                        @submit.prevent="
                            router.get('/seller/products', {
                                search: search,
                                status: filters?.status || '',
                            })
                        "
                        class="mb-4"
                    >
                        <input
                            type="text"
                            v-model="search"
                            placeholder="Cari produk..."
                            class="border rounded-xl px-4 py-3 w-72"
                        />
                    </form>
                    <div class="mt-4">
                        <select
                            :value="filters?.status || ''"
                            @change="
                                router.get('/seller/products', {
                                    status: $event.target.value,
                                })
                            "
                            class="border rounded-xl px-4 py-3 w-56 bg-white"
                        >
                            <option value="">Semua Status</option>

                            <option value="active">Active</option>

                            <option value="draft">Draft</option>

                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <Link
                    href="/seller/products/create"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-medium transition"
                >
                    + Tambah Produk
                </Link>
            </div>

            <!-- TABLE -->
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th
                                class="text-left px-6 py-4 text-sm font-semibold text-gray-600"
                            >
                                Produk
                            </th>

                            <th
                                class="text-left px-6 py-4 text-sm font-semibold text-gray-600"
                            >
                                Harga
                            </th>

                            <th
                                class="text-left px-6 py-4 text-sm font-semibold text-gray-600"
                            >
                                Stock
                            </th>

                            <th
                                class="text-left px-6 py-4 text-sm font-semibold text-gray-600"
                            >
                                Status
                            </th>

                            <th
                                class="text-right px-6 py-4 text-sm font-semibold text-gray-600"
                            >
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="product in products.data"
                            :key="product.id"
                            class="border-b hover:bg-gray-50"
                        >
                            <!-- PRODUK -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img
                                        v-if="product.image"
                                        :src="`/storage/${product.image}`"
                                        class="w-16 h-16 rounded-xl object-cover"
                                    />

                                    <div>
                                        <h3 class="font-semibold text-gray-800">
                                            {{ product.name }}
                                        </h3>

                                        <p class="text-sm text-gray-500">
                                            {{
                                                product.categories?.length || 0
                                            }}
                                            kategori
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- HARGA -->
                            <td class="px-6 py-4 font-medium text-gray-700">
                                Rp
                                {{
                                    Number(product.price).toLocaleString(
                                        "id-ID",
                                    )
                                }}
                            </td>

                            <!-- STOCK -->
                            <td class="px-6 py-4">
                                {{ product.stock }}
                            </td>

                            <!-- STATUS -->
                            <td class="px-6 py-4">
                                <span
                                    :class="[
                                        'px-3 py-1 rounded-full text-xs font-medium',
                                        product.status === 'active'
                                            ? 'bg-green-100 text-green-700'
                                            : product.status === 'inactive'
                                              ? 'bg-red-100 text-red-700'
                                              : 'bg-yellow-100 text-yellow-700',
                                    ]"
                                >
                                    {{ product.status }}
                                </span>
                            </td>

                            <!-- AKSI -->
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <Link
                                        :href="`/seller/products/${product.id}/edit`"
                                        class="px-4 py-2 bg-blue-50 text-blue-600 rounded-lg text-sm hover:bg-blue-100"
                                    >
                                        Edit
                                    </Link>

                                    <button
                                        @click="deleteProduct(product.id)"
                                        class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm hover:bg-red-100"
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
