import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: () => import("../views/HomeView.vue"),
    },
    {
      path: "/:catchAll(.*)",
      name: "pagenotfound",
      meta: { isAuthenticated: false },
      component: () => import("../views/PNFView.vue"),
    },
    {
      path: "/load",
      name: "load",
      meta: { isAuthenticated: false },
      component: () => import("../components/ScreenLoader.vue"),
    },
  ],
});

export default router;
