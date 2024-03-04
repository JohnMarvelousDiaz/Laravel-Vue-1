import { state } from "./state";

export const getters = {
  getUser: (state) => {
    return state.data.username;
  },
  getStatus: (state) => {
    return state.data.status;
  },
};
