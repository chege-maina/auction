<template>
    <div class="md:relative md:inline-block">
        <!-- Dropdown toggle button -->
        <button
            @click="isOpen = !isOpen"
            class="relative z-10 flex items-center p-2 text-sm text-gray-200 bg-[#310058] border border-transparent rounded-md focus:border-[#b57be6] focus:ring-opacity-40 dark:focus:ring-opacity-40 focus:ring-blue-300 focus:ring focus:outline-none"
        >
            <span class="mx-1 capitalize">{{ $store.getters.user.name }}</span>
            <svg
                class="w-5 h-5 mx-1"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    d="M12 15.713L18.01 9.70299L16.597 8.28799L12 12.888L7.40399 8.28799L5.98999 9.70199L12 15.713Z"
                    fill="currentColor"
                ></path>
            </svg>
        </button>

        <!-- Dropdown menu -->
        <div
            v-if="isOpen"
            @click="isOpen = false"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="md:absolute right-0 z-20 w-56 py-2 mt-2 overflow-hidden origin-top-right bg-[#310058] rounded-md shadow-xl"
        >
            <a
                href="#"
                class="flex items-center p-3 -mt-2 text-sm text-gray-600 transition-colors duration-300 transform hover:bg-[#510a8b]"
            >
                <img
                    class="flex-shrink-0 object-cover mx-1 rounded-full w-9 h-9"
                    src="../../components/assets/avatar.png"
                />
                <div class="mx-1">
                    <h1 class="text-sm font-semibold text-gray-400 capitalize">
                        {{ $store.getters.user.name }}
                    </h1>
                    <p class="text-sm text-gray-400">
                        {{ $store.getters.user.email }}
                    </p>
                </div>
            </a>

            <hr class="border-gray-200 dark:border-gray-700" />

            <a
                href="#"
                class="block px-4 py-3 text-sm text-gray-400 capitalize transition-colors duration-300 transform hover:bg-[#510a8b] cursor-pointer"
            >
                view profile
            </a>

            <hr class="border-gray-200 dark:border-gray-700" />

            <a
                @click="logout"
                class="block px-4 py-3 text-sm text-gray-400 capitalize transition-colors duration-300 transform hover:bg-[#510a8b] cursor-pointer"
            >
                Sign Out
            </a>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
export default {
    setup() {
        const router = useRouter();
        const store = useStore();
        let isOpen = ref(false);
        function logout() {
            router.push({ name: "Home" });
            store.dispatch("removeToken");
        }
        return {
            isOpen,
            logout,
        };
    },
};
</script>

<style></style>
