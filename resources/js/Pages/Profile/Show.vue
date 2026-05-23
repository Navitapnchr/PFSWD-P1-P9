<script setup>
defineProps({
    user: Object,
});
</script>

<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
            <h1 class="text-2xl font-bold mb-6 text-center">Profile User</h1>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="font-semibold">{{ user.name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-semibold">{{ user.email }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Role</p>
                    <p class="font-semibold">{{ user.role }}</p>
                </div>
            </div>
        </div>
    </div>
</template>
