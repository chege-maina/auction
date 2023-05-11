<template>
    <!--Modal Backdrop-->
    <transition name="backdrop-transition">
        <div
            class="h-screen w-full fixed left-0 top-0 flex justify-center md:items-center bg-black bg-opacity-50 overflow-y-auto"
            v-show="modalActive"
        >
            <!--Modal-->
            <transition name="modal-transition">
                <div
                    class="bg-gray-200 rounded-lg shadow-lg w-fit h-fit m-4 md:m-0"
                    v-show="modalActive"
                >
                    <div
                        class="flex items-center justify-between border-b p-2 mx-4"
                    >
                        <h1 class="font-bold text-gray-600 text-2xl">
                            {{ heading }}
                        </h1>
                        <span
                            class="text-3xl text-gray-600 cursor-pointer hover:text-[#9A031E] ml-5"
                            @click="close"
                        >
                            <i class="bi bi-x-circle-fill"></i>
                        </span>
                    </div>

                    <!--Modal Content-->
                    <slot />
                </div>
            </transition>
        </div>
    </transition>
</template>
<script>
export default {
    props: ["modalActive", "heading"],
    setup(props, { emit }) {
        const close = () => {
            emit("close");
        };
        return { close };
    },
};
</script>

<style></style>
