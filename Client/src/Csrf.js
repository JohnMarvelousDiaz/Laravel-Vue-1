import AxiosClient from "./AxiosClient";

export default {
  getCookie() {
    return AxiosClient.get("/csrf-cookie");
  },
};
