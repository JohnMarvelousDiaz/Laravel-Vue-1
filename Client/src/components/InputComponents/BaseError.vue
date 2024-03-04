<template>
  <div class="w-11/12 h-auto flex justify-center">
    <p class="text-red-700 text-xs" :key="key"><slot /></p>
  </div>
</template>

<script setup>
defineProps({
  key: {
    type: String,
  },
});
</script>
