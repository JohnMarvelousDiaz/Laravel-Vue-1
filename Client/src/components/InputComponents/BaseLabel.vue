<template>
  <div class="w-max h-auto flex flex-col">
    <label :for="id" class="cursor-pointer mb-1 text-sm font-medium">{{
      text
    }}</label>
  </div>
</template>

<script setup>
import { defineProps } from "vue";

const props = defineProps({
  text: {
    type: String,
    default: "Input Field",
  },
  id: {
    type: String,
    default: "inputField",
  },
});
</script>
