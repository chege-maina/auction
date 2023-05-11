<template>
    <Nav />
    <section class="min-h-full mt-20 flex items-center justify-center">
        <div
            class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg lg:max-w-4xl"
        >
            <div class="hidden bg-cover lg:block lg:w-1/2 loginBG"></div>

            <div class="w-full px-6 py-8 md:px-8 lg:w-1/2">
                <p class="mt-3 text-xl text-center text-gray-600s">
                    Create an Account to Log &amp; Bid
                </p>
                <p
                    class="text-red-700 font-bold text-xs mt-4 text-center"
                    v-if="error"
                >
                    {{ error }}
                </p>
                <p
                    class="text-green-700 font-bold text-xs mt-4 text-center"
                    v-if="success"
                >
                    {{ success }}
                </p>
                <form @submit.prevent="register">
                    <div class="mt-4">
                        <label
                            class="block mb-2 text-sm font-medium text-gray-600"
                            for="email"
                            >Email Address</label
                        >
                        <input
                            id="email"
                            placeholder="Your Email"
                            v-model="form.email"
                            required
                            class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300"
                            type="email"
                        />
                    </div>
                    <div class="mt-4">
                        <label
                            class="block mb-2 text-sm font-medium text-gray-600"
                            for="name"
                            >Full Name</label
                        >
                        <input
                            id="name"
                            v-model="form.name"
                            placeholder="Your Full Name"
                            required
                            class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300"
                            type="text"
                        />
                    </div>

                    <div class="mt-4">
                        <p>
                            <router-link
                                class="text-xs text-gray-500 hover:underline"
                                :to="{ name: 'Login' }"
                                >Already got Account? Sign In</router-link
                            >
                        </p>
                    </div>
                    <div class="mt-6">
                        <button
                            type="submit"
                            class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50"
                        >
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>
<script>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import Nav from "../../components/includes/Nav.vue";
export default {
    components: { Nav },
    setup() {
        const router = useRouter();
        const buttonsActive = ref(true);
        let initialState = {
            name: "",
            email: "",
            role_id: "3",
        };
        const form = reactive({ ...initialState });
        let error = ref("");
        let success = ref("");
        const close = () => {
            setTimeout(() => {
                router.push({ name: "Login" });
            }, 4 * 1000);
        };
        const register = async () => {
            buttonsActive.value = false;
            error.value = "";

            await axios
                .post("/api/register", form)
                .then((res) => {
                    if (res.data.success) {
                        error.value = "";
                        success.value = res.data.message;
                        close();
                    } else {
                        error.value = res.data.message;
                        console.log(error.value);
                        buttonsActive.value = true;
                    }
                })
                .catch((e) => {
                    buttonsActive.value = true;
                    error.value = e;
                });
        };
        return {
            register,
            form,
            error,
            success,
            buttonsActive,
        };
    },
};
</script>
<style scoped>
.loginBG {
    background-image: url("../assets/login.png");
}
</style>
