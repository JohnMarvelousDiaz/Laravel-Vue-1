<template>
  <div class="w-full h-auto flex flex-col">
    <input
      :type="type"
      :id="id"
      v-model="value"
      :placeholder="placeholderText"
      class="w-full px-2 py-1 mb-1 text-sm rounded-sm outline-none focus:ring-2 focus:border-transparent border border-gray-400"
    />
  </div>
</template>

<script setup>
import { defineProps, defineModel } from "vue";

const props = defineProps({
  id: {
    type: String,
    default: "inputField",
  },
  type: {
    type: String,
    default: "text",
  },
  placeholderText: {
    type: String,
    default: "inputField",
  },
});

const value = defineModel();
</script>

<style scoped>
input::placeholder {
  font-size: 12px;
  font-weight: 500;
}
</style>
