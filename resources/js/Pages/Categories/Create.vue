<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm, Link } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    description: "",
    icon: "",
    is_active: true,
    sort_order: 0,
});

const submit = () => {
    form.post("/admin/categories");
};
</script>

<template>
    <AppLayout>
        <div class="max-w-3xl mx-auto px-4 py-8">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold">Tambah Kategori</h1>

                <Link
                    href="/admin/categories"
                    class="text-gray-600 hover:text-blue-600"
                >
                    ← Kembali
                </Link>
            </div>

            <form
                @submit.prevent="submit"
                class="bg-white p-6 rounded-2xl shadow space-y-5"
            >
                <div>
                    <label class="block mb-2 font-medium"> Nama </label>

                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full border rounded-xl px-4 py-3"
                    />

                    <p
                        v-if="form.errors.name"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ form.errors.name }}
                    </p>
                </div>

                <div>
                    <label class="block mb-2 font-medium"> Deskripsi </label>

                    <textarea
                        v-model="form.description"
                        rows="4"
                        class="w-full border rounded-xl px-4 py-3"
                    />
                </div>

                <div>
                    <label class="block mb-2 font-medium"> Icon Emoji </label>

                    <input
                        v-model="form.icon"
                        type="text"
                        class="w-full border rounded-xl px-4 py-3"
                    />
                </div>

                <div>
                    <label class="block mb-2 font-medium"> Urutan </label>

                    <input
                        v-model="form.sort_order"
                        type="number"
                        class="w-full border rounded-xl px-4 py-3"
                    />
                </div>

                <div class="flex items-center gap-3">
                    <input v-model="form.is_active" type="checkbox" />

                    <label> Aktif </label>
                </div>

                <button
                    type="submit"
                    class="bg-blue-600 text-white px-5 py-3 rounded-xl"
                >
                    Simpan
                </button>
            </form>
        </div>
    </AppLayout>
</template>
