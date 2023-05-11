<template>
    <section class="min-h-full mt-32 flex items-center justify-center">
        <div
            class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg lg:max-w-4xl"
        >
            <div class="hidden bg-cover lg:block lg:w-1/2 loginBG"></div>

            <div class="w-full px-6 py-8 md:px-8 lg:w-1/2">
                <div class="flex justify-center mx-auto">
                    <img
                        class="w-auto h-7 sm:h-8"
                        src="../../components/assets/logo.png"
                        alt=""
                    />
                </div>

                <p class="mt-3 text-xl text-center text-gray-600s">
                    Change Password
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
                <form @submit.prevent="changePassword">
                    <div class="mt-4">
                        <label
                            class="block mb-2 text-sm font-medium text-gray-600"
                            for="email"
                            >Email Address</label
                        >
                        <input
                            id="email"
                            class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300"
                            type="email"
                            v-model="form.email"
                        />
                    </div>

                    <div class="mt-6">
                        <button
                            type="submit"
                            :disabled="!buttonsActive"
                            class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50"
                        >
                            Send Password
                        </button>
                    </div>
                    <p class="mt-3">
                        <router-link
                            :to="{ name: 'Login' }"
                            class="text-xs text-gray-500 hover:underline"
                            ><i class="bi bi-arrow-left-circle-fill"></i> Back
                            to Login</router-link
                        >
                    </p>
                </form>
            </div>
        </div>
    </section>
</template>
<script>
import { ref, reactive } from "vue";
import { useRouter } from "vue-router";
export default {
    setup() {
        let email = "";
        const buttonsActive = ref(true);
        let data = ref([]);
        let error = ref("");
        let success = ref("");
        const router = useRouter();
        let form = reactive({
            email: "",
        });

        const changePassword = async () => {
            buttonsActive.value = false;
            await axios.post("/api/forgotpsw", form).then((resp) => {
                if (resp.data.success) {
                    form.email = "";
                    error.value = "";
                    success.value = resp.data.message;
                    close();
                } else {
                    error.value = resp.data.message;
                    buttonsActive.value = true;
                }
            });
        };

        const close = () => {
            setTimeout(() => {
                router.push({ name: "Login" });
            }, 4 * 1000);
        };

        return {
            email,
            data,
            error,
            success,
            form,
            changePassword,
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
