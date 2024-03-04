import { state } from "./state";

export const mutations = {
  setUser: (state, username) => {
    state.data.username = username;
  },
  setAuth: (state, isAuth) => {
    state.data.isAuth = isAuth;
  },
  showLoading: (state, showLoading) => {
    state.loading.showLoading = showLoading;
  },
  logout: (state) => {
    state.data.username = "";
    state.data.isAuth = false;
  },
};
