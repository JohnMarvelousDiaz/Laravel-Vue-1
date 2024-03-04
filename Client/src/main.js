import "./assets/styles/style.css";

import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";

library.add(fas);

const app = createApp(App);

app.use(router);
app.use(store);
app.component("icon", FontAwesomeIcon);
app.mount("#app");
