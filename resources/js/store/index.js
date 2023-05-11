import { createStore } from "vuex";

const store = createStore({
    state: {
        //define variables
        user: JSON.parse(localStorage.getItem("user")),
        menu: localStorage.getItem("menu"),
    },

    mutations: {
        // update variable value
        UPDATE_USER(state, payload) {
            state.user = payload;
        },
        UPDATE_MENU(state, payload) {
            state.menu = payload;
        },
    },

    actions: {
        // action to be performed
        setUser(context, payload) {
            localStorage.setItem("user", JSON.stringify(payload));
            context.commit("UPDATE_USER", payload);
        },
        removeToken(context) {
            localStorage.removeItem("menu");
            context.commit("UPDATE_MENU", null);
            localStorage.removeItem("user");
            context.commit("UPDATE_USER", 0);
        },
        dashMenus(context, payload) {
            localStorage.setItem("menu", payload);
            context.commit("UPDATE_MENU", payload);
        },
    },

    getters: {
        // get state variable value
        user(state) {
            return state.user;
        },
        menu(state) {
            return state.menu;
        },
    },
});

export default store;
