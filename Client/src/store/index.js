import { createStore } from "vuex";
import { state } from "./state";
import { mutations } from "./mutations";
import { actions } from "./actions";
import { getters } from "./getters";
import createPersistedState from "vuex-persistedstate";

const store = createStore({
  state,
  mutations,
  actions,
  getters,
  plugins: [createPersistedState()],
});

export default store;
