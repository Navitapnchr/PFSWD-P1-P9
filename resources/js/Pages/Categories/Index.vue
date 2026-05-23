<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, router } from "@inertiajs/vue3";

defineProps({
    categories: Object,
});

const destroy = (id) => {
    if (confirm("Yakin hapus kategori?")) {
        router.delete(`/admin/categories/${id}`);
    }
};
</script>

<template>
    <AppLayout>
        <div class="max-w-7xl mx-auto px-4 py-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold">Manajemen Kategori</h1>

                    <p class="text-gray-500 mt-1">
                        Kelola kategori produk toko online
                    </p>
                </div>

                <Link
                    href="/admin/categories/create"
                    class="bg-blue-600 text-white px-4 py-2 rounded-xl"
                >
                    + Tambah Kategori
                </Link>
            </div>

            <div class="bg-white rounded-2xl shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="text-left p-4">Icon</th>

                            <th class="text-left p-4">Nama</th>

                            <th class="text-left p-4">Slug</th>

                            <th class="text-left p-4">Status</th>

                            <th class="text-left p-4">Urutan</th>

                            <th class="text-left p-4">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="category in categories.data"
                            :key="category.id"
                            class="border-b"
                        >
                            <td class="p-4 text-2xl">
                                {{ category.icon }}
                            </td>

                            <td class="p-4 font-medium">
                                {{ category.name }}
                            </td>

                            <td class="p-4 text-sm text-gray-500">
                                {{ category.slug }}
                            </td>

                            <td class="p-4">
                                <span
                                    class="px-2 py-1 rounded-lg text-xs"
                                    :class="
                                        category.is_active
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-red-100 text-red-700'
                                    "
                                >
                                    {{
                                        category.is_active
                                            ? "Aktif"
                                            : "Nonaktif"
                                    }}
                                </span>
                            </td>

                            <td class="p-4">
                                {{ category.sort_order }}
                            </td>

                            <td class="p-4 flex gap-2">
                                <Link
                                    :href="`/admin/categories/${category.id}/edit`"
                                    class="text-blue-600 hover:underline"
                                >
                                    Edit
                                </Link>

                                <button
                                    @click="destroy(category.id)"
                                    class="text-red-600 hover:underline"
                                >
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
