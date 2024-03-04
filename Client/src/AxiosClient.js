import axios from "axios";

const AxiosClient = axios.create({
  baseURL: "http://localhost:8000/api/",
  headers: {
    "Content-Type": "application/json",
    // Authorization: "Bearer ${store.state.user.token}",
  },
});
// AxiosClient.defaults.withCredentials = false;
export default AxiosClient;
