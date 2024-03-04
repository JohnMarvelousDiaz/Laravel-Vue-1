<template>
  <button
    :type="type"
    class="w-full h-auto py-2 text-sm rounded-sm flex justify-center border border-red-900 bg-red-900 hover:bg-white text-white hover:text-red-900 hover:font-medium font-normal my-2"
  >
    <Loader v-if="loading"></Loader>
    <span v-else>{{ text }}</span>
  </button>
</template>

<script setup>
import { computed } from "vue";
import { useStore } from "vuex";
import Loader from "./LoadingButton2.vue";
const store = useStore();
const loading = computed(() => store.state.loading.showLoading);

defineProps({
  type: {
    type: String,
    default: "button",
  },
  text: {
    type: String,
    default: "button",
  },
});
</script>
