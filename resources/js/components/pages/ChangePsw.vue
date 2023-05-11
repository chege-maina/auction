<template>
    <section class="min-h-full mt-20 flex items-center justify-center">
        <div
            class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg lg:max-w-4xl"
        >
            <div class="hidden bg-cover lg:block lg:w-1/2 loginBG"></div>

            <div
                class="w-full px-6 py-8 md:px-8 lg:w-1/2"
                v-for="option in data"
                :key="option.id"
                :value="option.id"
            >
                <p class="mt-3 text-xl text-center text-gray-600s">
                    Sign in to Log &amp; Bid
                </p>
                <p class="mt-3 text-center" v-if="option.status === 0">
                    Create Password {{ option.name }}
                </p>
                <p class="mt-3 text-center" v-else>
                    Change Password - {{ option.name }}
                </p>
                <p
                    class="text-red-700 font-bold text-xs mt-4 text-center"
                    v-if="error"
                >
                    {{ error }}
                </p>
                <form @submit.prevent="changePassword">
                    <div class="mt-4">
                        <div class="flex justify-between">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-600"
                                for="password"
                                >Password</label
                            >
                        </div>
                        <div class="relative">
                            <input
                                id="password"
                                class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300"
                                v-model="form.password"
                                :type="[passView ? 'text' : 'password']"
                            />
                            <svg
                                v-if="passView"
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="gray"
                                class="bi bi-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"
                                viewBox="0 0 16 16"
                                @click="togglePass"
                            >
                                <path
                                    d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"
                                />
                                <path
                                    d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"
                                />
                                <path
                                    d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"
                                />
                            </svg>

                            <svg
                                v-else
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="gray"
                                class="bi bi-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"
                                viewBox="0 0 16 16"
                                @click="togglePass"
                            >
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"
                                />
                                <path
                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"
                                />
                            </svg>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div class="flex justify-between">
                            <label
                                class="block mb-2 text-sm font-medium text-gray-600"
                                for="c_password"
                                >Confirm Password</label
                            >
                        </div>
                        <div class="relative">
                            <input
                                id="c_password"
                                class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300"
                                v-model="form.c_password"
                                :type="[passView ? 'text' : 'password']"
                            />
                            <svg
                                v-if="passView"
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="gray"
                                class="bi bi-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"
                                viewBox="0 0 16 16"
                                @click="togglePass"
                            >
                                <path
                                    d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z"
                                />
                                <path
                                    d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z"
                                />
                                <path
                                    d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12-.708.708z"
                                />
                            </svg>

                            <svg
                                v-else
                                xmlns="http://www.w3.org/2000/svg"
                                width="16"
                                height="16"
                                fill="gray"
                                class="bi bi-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"
                                viewBox="0 0 16 16"
                                @click="togglePass"
                            >
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"
                                />
                                <path
                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"
                                />
                            </svg>
                        </div>
                        <p>
                            <router-link
                                class="text-xs text-gray-500 hover:underline"
                                :to="{ name: 'Login' }"
                                ><i class="bi bi-arrow-left-circle-fill"></i>
                                Back to Sign in?</router-link
                            >
                        </p>
                    </div>

                    <div class="mt-6">
                        <button
                            type="submit"
                            class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50"
                        >
                            Submit Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>
<script>
import { onMounted, ref, reactive } from "vue";
import { useRouter } from "vue-router";
export default {
    props: ["id"],

    setup(props) {
        let passView = ref(false);
        let email = "";
        let data = ref([]);
        let date = ref([]);
        let error = ref("");
        let string = "";
        const router = useRouter();
        let form = reactive({
            password: "",
            c_password: "",
        });
        onMounted(() => {
            //check update
            try {
                string = atob(props.id);
                string = string.split(" ");
                email = string.at(0);
                axios
                    .post("/api/getuser/" + email)
                    .then((resp) => {
                        data.value = resp.data.user;
                        if (data.value.length == 0) {
                            logout();
                        }
                    })
                    .catch((e) => {
                        console.log(e);
                    });
            } catch (err) {
                logout();
            }
        });
        const togglePass = () => {
            passView.value = !passView.value;
        };
        const getDateCur = async () => {
            axios
                .get("/api/CurrentDate/")
                .then((resp) => {
                    date.value = resp.data.date;
                    var sentDate = new Date(string.at(2) + " " + string.at(3));
                    var present_date = new Date(date.value);

                    var Difference_In_Time =
                        (present_date.getTime() - sentDate.getTime()) /
                        (1000 * 3600);
                    if (data.value.at(0).status === 1) {
                        error.value =
                            "You Have Been Disabled. Contact Tech Support";
                    } else if (
                        string.at(1) == "new" &&
                        data.value.at(0).status === 2
                    ) {
                        error.value =
                            "You Have Already Used This Link to Create Password";
                    } else if (Difference_In_Time > 1) {
                        error.value = "Change Password Link has Expired";
                    } else {
                        axios
                            .post("/api/changepsw/" + data.value.at(0).id, form)
                            .then((res) => {
                                if (res.data.success) {
                                    router.push({ name: "Login" });
                                }
                            })
                            .catch((e) => {
                                error.value = e.response.data.message;
                            });
                    }
                })
                .catch((e) => {
                    console.log(e);
                });
        };
        const changePassword = async () => {
            getDateCur();
        };
        function logout() {
            router.push({ name: "Login" });
        }

        return {
            email,
            data,
            error,
            form,
            passView,
            changePassword,
            togglePass,
        };
    },
};
</script>

<style scoped>
.loginBG {
    background-image: url("../assets/login.png");
}
</style>
