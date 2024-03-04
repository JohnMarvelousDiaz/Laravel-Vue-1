import AxiosClient from "@/AxiosClient";

export const actions = {
  async login({ commit }, user) {
    commit("showLoading", true);
    return AxiosClient.post("login", user)
      .then(({ data }) => {
        commit("setUser", data.user);
        commit("showLoading", false);
        return data;
      })
      .catch((apiMsg) => {
        commit("showLoading", false);
        console.log(apiMsg);
      });
  },
  async register({ commit }, formData) {
    commit("showLoading", true);
    return AxiosClient.post("register", formData)
      .then(({ data }) => {
        commit("showLoading", false);
        return data;
      })
      .catch((error) => {
        commit("showLoading", false);
        console.log(error);
      });
  },
  async logout({ commit }) {
    commit("logout");
  },
};
