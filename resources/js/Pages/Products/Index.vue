<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";
import dayjs from "dayjs";

const props = defineProps({
    products: Object,
    categories: Array,
    filters: Object,
});

const search = ref(props.filters?.search || "");
const sort = ref(props.filters?.sort || "latest");
const isNew = (date) => {
    return dayjs().diff(dayjs(date), "day") <= 7;
};
const submitSearch = () => {
    router.get("/products", {
        search: search.value,
        category: props.filters?.category || "",
        sort: sort.value,
    });
};

const resetFilter = () => {
    router.get("/products");
};

const filterCategory = (slug) => {
    router.get("/products", {
        category: slug,
        search: search.value,
        sort: sort.value,
    });
};
</script>

<template>
    <AppLayout>
        <div class="min-h-screen bg-gray-50">
            <!-- HEADER -->
            <section class="bg-white border-b">
                <div class="max-w-7xl mx-auto px-4 py-10">
                    <h1 class="text-4xl font-bold text-gray-900">
                        Katalog Produk
                    </h1>

                    <p class="text-gray-500 mt-2">
                        {{ products.total }} produk ditemukan
                    </p>

                    <!-- SEARCH -->
                    <form
                        @submit.prevent="submitSearch"
                        class="flex flex-col md:flex-row gap-3 mt-8"
                    >
                        <div class="relative flex-1">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="🔍 Cari produk..."
                                class="w-full rounded-2xl border border-gray-300 px-5 py-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>

                        <Link
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-2xl font-medium transition"
                        >
                            Cari
                        </Link>

                        <link   
                            type="button"
                            @click="resetFilter"
                            class="border border-gray-300 hover:bg-gray-100 px-8 py-4 rounded-2xl font-medium transition"
                        >
                            Reset
                        </link>
                    </form>
                    <div class="mt-6">
                        <select
                            v-model="sort"
                            @change="submitSearch"
                            class="border border-gray-300 rounded-2xl px-5 py-3 bg-white"
                        >
                            <option value="latest">Terbaru</option>

                            <option value="price_asc">Harga Terendah</option>

                            <option value="price_desc">Harga Tertinggi</option>

                            <option value="popular">Terpopuler</option>
                        </select>
                    </div>
                    <!-- CATEGORY -->
                    <div class="flex flex-wrap gap-3 mt-6">

    <button
        @click="filterCategory('')"
        :class="[
            !filters?.category
                ? 'bg-blue-600 text-white border-blue-600'
                : 'bg-white hover:bg-gray-100 border-gray-300',
            'px-5 py-2 rounded-full border transition',
        ]"
    >
        Semua
    </button>

    <Link
    v-for="category in categories"
    :key="category.id"

    :href="`/categories/${category.slug}`"

    :class="[
        filters?.category === category.slug
            ? 'bg-blue-600 text-white border-blue-600'
            : 'bg-white hover:bg-gray-100 border-gray-300',
        'px-5 py-2 rounded-full border transition'
    ]"
>
    {{ category.icon }}
    {{ category.name }}
</Link>
</div>
                </div>
            </section>

            <!-- PRODUCTS -->
            <section class="max-w-7xl mx-auto px-4 py-12">
                <div
                    v-if="products.data.length"
                    class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8"
                >
                    <Link
                        v-for="product in products.data"
                        :key="product.id"
                        :href="`/products/${product.slug}`"
                        class="bg-white rounded-3xl overflow-hidden border border-gray-100 hover:shadow-2xl transition duration-300 flex flex-col relative"
                    >
                        <!-- IMAGE -->
                        <div class="aspect-square bg-gray-100 overflow-hidden">
                            <img
                                v-if="product.image"
                                :src="`/storage/${product.image}`"
                                class="w-full h-full object-cover hover:scale-105 transition duration-300"
                            />

                            <div
                                v-else
                                class="w-full h-full flex items-center justify-center text-gray-400"
                            >
                                Tidak ada gambar
                            </div>
                        </div>
                        <div
                            v-if="isNew(product.created_at)"
                            class="absolute top-4 left-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow"
                        >
                            BARU
                        </div>
                        <!-- CONTENT -->
                        <div class="p-5 flex flex-col flex-1">
                            <!-- CATEGORY -->
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span
                                    v-for="cat in product.categories"
                                    :key="cat.id"
                                    class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full"
                                >
                                    {{ cat.name }}
                                </span>
                            </div>

                            <!-- TITLE -->
                            <h2
                                class="font-bold text-lg text-gray-800 line-clamp-2 min-h-[56px]"
                            >
                                {{ product.name }}
                            </h2>

                            <!-- SELLER -->
                            <p class="text-sm text-gray-500 mt-2">
                                {{
                                    product.seller?.store_name ||
                                    product.seller?.name
                                }}
                            </p>

                            <!-- PRICE -->
                            <p class="text-2xl font-bold text-blue-600 mt-5">
                                Rp
                                {{
                                    Number(product.price).toLocaleString(
                                        "id-ID",
                                    )
                                }}
                            </p>

                            <!-- FOOTER -->
                            <div
                                class="flex justify-between items-center mt-auto pt-5 text-sm text-gray-500"
                            >
                                <span> Stock {{ product.stock }} </span>

                                <span> {{ product.views || 0 }} views </span>
                            </div>
                        </div>
                    </Link>
                </div>

                <!-- EMPTY -->
                <div
                    v-else
                    class="bg-white rounded-3xl p-20 text-center shadow-sm"
                >
                    <h2 class="text-2xl font-bold text-gray-700">
                        Produk tidak ditemukan
                    </h2>

                    <p class="text-gray-500 mt-3">Coba gunakan keyword lain</p>
                </div>

                <!-- PAGINATION -->
                <div
                    v-if="products.links"
                    class="flex justify-center mt-16 gap-2 flex-wrap"
                >
                    <template
                        v-for="(link, index) in products.links"
                        :key="index"
                    >
                        <Link
                            v-if="link.url"
                            :href="link.url"
                            v-html="link.label"
                            :class="[
                                link.active
                                    ? 'bg-blue-600 text-white'
                                    : 'bg-white hover:bg-gray-100 text-gray-700',
                                'px-4 py-2 rounded-xl border border-gray-300 transition',
                            ]"
                        />

                        <span
                            v-else
                            v-html="link.label"
                            class="px-4 py-2 rounded-xl border border-gray-200 text-gray-400 bg-gray-100"
                        />
                    </template>
                </div>
            </section>
        </div>
    </AppLayout>
</template>
