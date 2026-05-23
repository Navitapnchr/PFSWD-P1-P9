<script setup>
import { computed } from "vue";
import { Link, usePage, router } from "@inertiajs/vue3";

const page = usePage();

const auth = computed(() => page.props.auth?.user);
const flash = computed(() => page.props.flash);

router.on("success", () => {
    // placeholder sync cart
});
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <!-- NAVBAR -->
        <nav
            class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <!-- LOGO -->
                    <Link href="/" class="flex items-center gap-2">
                        <span class="text-2xl">🛍</span>
                        <span class="font-bold text-xl text-blue-600">
                            Toko Online
                        </span>
                    </Link>

                    <!-- MENU -->
                    <div class="hidden md:flex items-center gap-6">
                        <Link
                            href="/"
                            class="text-gray-600 hover:text-blue-600"
                        >
                            Home
                        </Link>

                        <Link
                            href="/tentang"
                            class="text-gray-600 hover:text-blue-600"
                        >
                            Tentang
                        </Link>

                        <!-- SUDAH LOGIN -->
                        <template v-if="auth">
                            <!-- BUYER -->
                            <template v-if="auth.role === 'buyer'">
                                <Link
                                    href="/profile"
                                    class="text-gray-600 hover:text-blue-600"
                                >
                                    Profile
                                </Link>
                            </template>

                            <!-- SELLER -->
                            <template v-if="auth.role === 'seller'">
                                <span class="text-sm text-green-600">
                                    Seller
                                </span>
                            </template>

                            <!-- ADMIN -->
                            <template v-if="auth.role === 'admin'">
                                <span class="text-sm text-red-600">
                                    Admin
                                </span>
                            </template>

                            <!-- DASHBOARD -->
                            <Link
                                :href="
                                    auth.role === 'admin'
                                        ? '/admin/dashboard'
                                        : auth.role === 'seller'
                                          ? '/seller/dashboard'
                                          : '/dashboard'
                                "
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm"
                            >
                                Dashboard
                            </Link>

                            <!-- USER -->
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-gray-600">
                                    {{ auth.name }}
                                </span>

                                <Link
                                    href="/logout"
                                    method="post"
                                    as="button"
                                    class="text-sm text-red-500 hover:text-red-700"
                                >
                                    Keluar
                                </Link>
                            </div>
                        </template>

                        <!-- BELUM LOGIN -->
                        <template v-else>
                            <Link
                                href="/login"
                                class="text-gray-600 hover:text-blue-600"
                            >
                                Masuk
                            </Link>

                            <Link
                                href="/register"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg"
                            >
                                Daftar
                            </Link>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <!-- FLASH -->
        <div
            v-if="flash?.success"
            class="bg-green-50 border-l-4 border-green-500 p-4 max-w-7xl mx-auto mt-4 rounded"
        >
            <p class="text-green-700 text-sm">✅ {{ flash.success }}</p>
        </div>

        <div
            v-if="flash?.error"
            class="bg-red-50 border-l-4 border-red-500 p-4 max-w-7xl mx-auto mt-4 rounded"
        >
            <p class="text-red-700 text-sm">❌ {{ flash.error }}</p>
        </div>

        <!-- CONTENT -->
        <main>
            <slot />
        </main>
    </div>
</template>
