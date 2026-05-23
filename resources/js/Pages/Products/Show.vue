<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/vue3";

defineProps({
    product: Object,
    produkLain: Array,
});
const form = useForm({
    rating: 5,
    comment: "",
});

const submitReview = (productId) => {
    form.post(`/products/${productId}/reviews`, {
        preserveScroll: true,

        onSuccess: () => {
            form.reset();

            form.rating = 5;
        },
    });
};
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4">
                <!-- DETAIL -->
                <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
                    <div class="grid lg:grid-cols-2 gap-10">
                        <!-- IMAGE -->
                        <div class="bg-gray-100">
                            <img
                                v-if="product.image"
                                :src="`/storage/${product.image}`"
                                class="w-full h-full object-cover"
                            />

                            <div
                                v-else
                                class="h-full min-h-[500px] flex items-center justify-center text-gray-400"
                            >
                                Tidak ada gambar
                            </div>
                        </div>

                        <!-- CONTENT -->
                        <div class="p-10">
                            <!-- CATEGORY -->
                            <div class="flex flex-wrap gap-2 mb-5">
                                <span
                                    v-for="category in product.categories"
                                    :key="category.id"
                                    class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full text-sm"
                                >
                                    {{ category.name }}
                                </span>
                            </div>

                            <!-- TITLE -->
                            <h1
                                class="text-4xl font-bold text-gray-900 leading-tight"
                            >
                                {{ product.name }}
                            </h1>

                            <!-- SELLER -->
                            <p class="text-gray-500 mt-4">
                                Dijual oleh
                                <span class="font-semibold">
                                    {{
                                        product.seller?.store_name ||
                                        product.seller?.name
                                    }}
                                </span>
                            </p>

                            <!-- PRICE -->
                            <p class="text-5xl font-bold text-blue-600 mt-8">
                                Rp
                                {{
                                    Number(product.price).toLocaleString(
                                        "id-ID",
                                    )
                                }}
                            </p>

                            <!-- INFO -->
                            <div class="grid grid-cols-2 gap-5 mt-10">
                                <div class="bg-gray-50 rounded-2xl p-5">
                                    <p class="text-gray-500 text-sm">Stock</p>

                                    <p class="font-bold text-2xl mt-2">
                                        {{ product.stock }}
                                    </p>
                                </div>

                                <div class="bg-gray-50 rounded-2xl p-5">
                                    <p class="text-gray-500 text-sm">Views</p>

                                    <p class="font-bold text-2xl mt-2">
                                        {{ product.views || 0 }}
                                    </p>
                                </div>
                            </div>

                            <!-- STATUS -->
                            <div class="mt-8">
                                <span
                                    class="bg-green-100 text-green-700 px-5 py-2 rounded-full text-sm font-medium"
                                >
                                    {{ product.status }}
                                </span>
                            </div>

                            <!-- DESCRIPTION -->
                            <div class="mt-10">
                                <h2
                                    class="text-2xl font-bold text-gray-800 mb-4"
                                >
                                    Deskripsi Produk
                                </h2>

                                <div
                                    class="prose max-w-none text-gray-600 leading-relaxed"
                                >
                                    {{ product.description }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- REVIEW -->
                <div class="bg-white rounded-3xl shadow-sm p-10 mt-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">
                        Review Produk
                    </h2>

                    <!-- FORM -->
                    <div class="border rounded-3xl p-6 mb-10">
                        <h3 class="font-bold text-lg mb-5">Tambah Review</h3>

                        <!-- RATING -->
                        <div class="mb-5">
                            <label class="block font-medium mb-2">
                                Rating
                            </label>

                            <select
                                v-model="form.rating"
                                class="w-full rounded-2xl border-gray-300"
                            >
                                <option :value="5">⭐⭐⭐⭐⭐</option>
                                <option :value="4">⭐⭐⭐⭐</option>
                                <option :value="3">⭐⭐⭐</option>
                                <option :value="2">⭐⭐</option>
                                <option :value="1">⭐</option>
                            </select>
                        </div>

                        <!-- COMMENT -->
                        <div class="mb-5">
                            <label class="block font-medium mb-2">
                                Komentar
                            </label>

                            <textarea
                                v-model="form.comment"
                                rows="4"
                                class="w-full rounded-2xl border-gray-300"
                                placeholder="Bagikan pengalaman Anda..."
                            />
                        </div>

                        <button
                            @click="submitReview(product.id)"
                            :disabled="form.processing"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl transition"
                        >
                            Kirim Review
                        </button>
                    </div>

                    <!-- LIST REVIEW -->
                    <div v-if="product.reviews.length" class="space-y-6">
                        <div
                            v-for="review in product.reviews"
                            :key="review.id"
                            class="border rounded-3xl p-6"
                        >
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-lg">
                                        {{ review.user.name }}
                                    </h3>

                                    <p class="text-yellow-500 mt-1">
                                        {{ "⭐".repeat(review.rating) }}
                                    </p>
                                </div>

                                <p class="text-sm text-gray-400">
                                    {{ review.created_at }}
                                </p>
                            </div>

                            <p class="text-gray-600 mt-5 leading-relaxed">
                                {{ review.comment }}
                            </p>
                        </div>
                    </div>

                    <div v-else class="text-gray-500">Belum ada review.</div>
                </div>
                <!-- PRODUK LAIN -->
                <div v-if="produkLain.length" class="mt-16">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">
                                Produk Lainnya
                            </h2>

                            <p class="text-gray-500 mt-2">
                                Produk lain dari seller yang sama
                            </p>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                        <Link
                            v-for="item in produkLain"
                            :key="item.id"
                            :href="`/products/${item.slug}`"
                            class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition"
                        >
                            <img
                                v-if="item.image"
                                :src="`/storage/${item.image}`"
                                class="w-full aspect-square object-cover"
                            />

                            <div class="p-5">
                                <h3
                                    class="font-bold text-gray-800 line-clamp-2"
                                >
                                    {{ item.name }}
                                </h3>

                                <p class="text-blue-600 font-bold text-xl mt-4">
                                    Rp
                                    {{
                                        Number(item.price).toLocaleString(
                                            "id-ID",
                                        )
                                    }}
                                </p>
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
