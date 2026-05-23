<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";

const props = defineProps({
    product: Object,
    categories: Array,
});

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    stock: props.product.stock,
    status: props.product.status,
    image: null,
    category_ids: props.product.categories.map((c) => c.id),
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        _method: "PUT",
    })).post(`/seller/products/${props.product.id}`, {
        forceFormData: true,
    });
};
const previewImage = (e) => {
    form.image = e.target.files[0];
};
const imagePreview = () => {
    if (!form.image) return null;

    return URL.createObjectURL(form.image);
};
</script>

<template>
    <AppLayout>
        <div class="max-w-4xl mx-auto px-4 py-8">
            <!-- HEADER -->
            <div class="mb-8">
                <Link
                    href="/seller/products"
                    class="text-blue-600 hover:underline text-sm"
                >
                    ← Kembali ke produk
                </Link>

                <h1 class="text-3xl font-bold text-gray-800 mt-2">
                    Edit Produk
                </h1>

                <p class="text-gray-500 mt-1">Perbarui informasi produk</p>
            </div>

            <!-- FORM -->
            <form
                @submit.prevent="submit"
                class="bg-white rounded-2xl shadow p-8 space-y-6"
            >
                <!-- NAMA -->
                <div>
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Nama Produk
                    </label>

                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    />

                    <p
                        v-if="form.errors.name"
                        class="mt-2 text-sm text-red-500"
                    >
                        {{ form.errors.name }}
                    </p>
                </div>

                <!-- DESKRIPSI -->
                <div>
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Deskripsi
                    </label>

                    <textarea
                        v-model="form.description"
                        rows="5"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    />
                </div>

                <!-- GRID -->
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- HARGA -->
                    <div>
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Harga
                        </label>

                        <input
                            v-model="form.price"
                            type="number"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>

                    <!-- STOCK -->
                    <div>
                        <label
                            class="block text-sm font-semibold text-gray-700 mb-2"
                        >
                            Stock
                        </label>

                        <input
                            v-model="form.stock"
                            type="number"
                            class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                </div>

                <!-- STATUS -->
                <div>
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Status
                    </label>

                    <select
                        v-model="form.status"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="draft">Draft</option>

                        <option value="active">Active</option>

                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- KATEGORI -->
                <div>
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-3"
                    >
                        Kategori
                    </label>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <label
                            v-for="category in categories"
                            :key="category.id"
                            class="flex items-center gap-2 border rounded-xl p-3 hover:bg-gray-50 cursor-pointer"
                        >
                            <input
                                v-model="form.category_ids"
                                :value="category.id"
                                type="checkbox"
                                class="rounded border-gray-300 text-blue-600"
                            />

                            <span>
                                {{ category.icon }}
                                {{ category.name }}
                            </span>
                        </label>
                    </div>
                </div>

                <!-- IMAGE -->
                <div>
                    <label
                        class="block text-sm font-semibold text-gray-700 mb-2"
                    >
                        Foto Produk
                    </label>

                    <!-- FOTO LAMA -->
                    <div v-if="product.image" class="mb-4">
                        <img
                            :src="`/storage/${product.image}`"
                            class="w-40 rounded-2xl shadow"
                        />
                    </div>

                    <input
                        type="file"
                        @change="previewImage"
                        accept="image/*"
                        class="block w-full text-sm"
                    />

                    <!-- PREVIEW FOTO BARU -->
                    <div v-if="form.image" class="mt-4">
                        <img
                            :src="imagePreview()"
                            class="w-40 rounded-2xl shadow"
                        />
                    </div>
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end gap-3 pt-4">
                    <Link
                        href="/seller/products"
                        class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50"
                    >
                        Batal
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="px-6 py-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50"
                    >
                        <span v-if="form.processing"> Menyimpan... </span>

                        <span v-else> Update Produk </span>
                    </button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
