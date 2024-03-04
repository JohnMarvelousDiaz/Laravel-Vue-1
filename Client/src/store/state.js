import { reactive } from "vue";

export const state = reactive({
  data: { username: "", isAuth: false },
  loading: {
    showLoading: false,
  },
  user: { data: [] },
});
