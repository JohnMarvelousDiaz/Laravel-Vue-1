<template>
  <div class="loader"></div>
</template>

<style scoped>
.loader {
  position: relative;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.loader::before,
.loader::after {
  border: 2.67px solid #7f1d1d;
  border-radius: 50%;
  position: absolute;
  content: "";
  display: block;
}

.loader::before {
  width: 13.4px; /* Adjusted width */
  height: 13.4px; /* Adjusted height */
  border-bottom-color: transparent;
  border-left-color: transparent;
  animation: loader-1o3y8q 1.1s infinite linear reverse;
}

.loader::after {
  animation: loader-1o3y8q 0.8s infinite linear;
  height: 20px; /* Adjusted height */
  width: 20px; /* Adjusted width */
  border-right-color: transparent;
  border-top-color: transparent;
}

@keyframes loader-1o3y8q {
  to {
    transform: rotate(360deg);
  }
}
</style>
