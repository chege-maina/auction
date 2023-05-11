<template>
    <div
        class="py-3.5 px-6 shadow md:flex justify-between items-center bg-white"
    >
        <div class="flex items-center cursor-pointer text-[#002D74]">
            <span class="text-4xl mr-1">
                <img
                    class="h-11 w-28"
                    src="../../components/assets/logo.png"
                    alt=""
                />
            </span>
        </div>
        <span
            class="absolute md:hidden right-6 top-1.5 cursor-pointer text-4xl"
            @click="openMenu()"
        >
            <i :class="[open ? 'bi bi-x' : 'bi bi-filter-left']"></i
        ></span>
        <ul
            class="md:flex md:items-center md:px-0 px-3 md:pb-0 pb-10 md:static absolute md:w-auto w-full top-14 duration-700 ease-in text-[#310058] bg-white"
            :class="[open ? 'left-0' : 'left-[-100%]']"
        >
            <li class="md:mx-4 md:my-0 my-6">
                <div
                    @click="setMenu('home'), closeMenu()"
                    class="text-xl hover:text-[#510a8b] duration-500 cursor-pointer"
                >
                    <router-link
                        :to="{ name: 'Home' }"
                        class="text-xl hover:text-[#510a8b] duration-500"
                        >Home</router-link
                    >
                </div>
            </li>
            <li class="md:mx-4 md:my-0 my-6" v-if="!$store.getters.user">
                <div
                    @click="setMenu('login'), closeMenu()"
                    class="text-xl hover:text-[#510a8b] duration-500 cursor-pointer"
                >
                    <router-link
                        :to="{ name: 'Login' }"
                        class="text-xl hover:text-[#510a8b] duration-500"
                        >Login</router-link
                    >
                </div>
            </li>
            <li class="md:mx-4 md:my-0 my-6" v-if="!$store.getters.user">
                <div
                    @click="setMenu('register'), closeMenu()"
                    class="text-xl hover:text-[#510a8b] duration-500 cursor-pointer"
                >
                    <router-link
                        :to="{ name: 'Register' }"
                        class="text-xl hover:text-[#510a8b] duration-500"
                        >Register</router-link
                    >
                </div>
            </li>
            <li
                class="md:mx-4 md:my-0 my-6"
                v-if="$store.getters.user && $store.getters.user.role < 3"
            >
                <div
                    @click="setMenu('products'), closeMenu()"
                    class="text-xl hover:text-[#510a8b] duration-500 cursor-pointer"
                >
                    <router-link
                        :to="{ name: 'Dashboard' }"
                        class="text-xl hover:text-[#510a8b] duration-500"
                        >Products</router-link
                    >
                </div>
            </li>
            <li
                class="md:mx-4 md:my-0 my-6"
                v-if="$store.getters.user && $store.getters.user.role < 3"
            >
                <div
                    @click="setMenu('users'), closeMenu()"
                    class="text-xl hover:text-[#510a8b] duration-500 cursor-pointer"
                >
                    <router-link
                        :to="{ name: 'Dashboard' }"
                        class="text-xl hover:text-[#510a8b] duration-500"
                        >Users</router-link
                    >
                </div>
            </li>
            <li v-if="$store.getters.user"><Dropdown /></li>
        </ul>
    </div>
</template>
<script>
import Dropdown from "../../components/includes/Dropdown.vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import { ref } from "vue";
export default {
    components: { Dropdown },
    setup() {
        const router = useRouter();
        const store = useStore();
        let open = ref(false);
        function logout() {
            router.push({ name: "Login" });
            store.dispatch("removeToken");
        }
        function setMenu(menu) {
            store.dispatch("dashMenus", menu);
        }
        function openMenu() {
            open.value = !open.value;
        }
        function closeMenu() {
            open.value = false;
        }
        return {
            logout,
            setMenu,
            open,
            openMenu,
            closeMenu,
        };
    },
};
</script>
