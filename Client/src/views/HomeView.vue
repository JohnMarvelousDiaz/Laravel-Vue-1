<template>
  <main>
    <ScreenLoader v-if="loading" />
    <div class="w-screen h-screen bg">
      <div class="w-screen h-screen bg1">
        <div class="h-auto flex flex-col items-center justify-center py-16">
          <div class="flex flex-col justify-center items-center">
            <img src="../assets/images/bulsu_logo.png" class="w-16" />
            <span class="text-white text-2xl font-semibold"
              >Bulacan State University</span
            >
            <span class="text-white text-lg font-light tracking-wider mb-4"
              >Research Management System</span
            >
          </div>
          <div
            class="max-sm:w-3/4 max-md:w-2/4 max-lg:w-2/5 max-xl:w-2/5 w-1/4 h-auto px-12 py-6 flex flex-col bg-white rounded-xl"
          >
            <span class="text-2xl font-bold mb-4">LOGIN</span>
            <span class="text-sm text-slate-500 mb-4"
              >Enter your registered BulSU email address and password to access
              the RMO Management<br />
              System</span
            >
            <form @submit.prevent="submitForm">
              <BaseLabel id="email" text="Email Address" />
              <BaseInput
                type="text"
                id="email"
                v-model="formData.email"
                placeholderText="Enter Your BulSU Email Address"
                @input="clearError('email')"
              />
              <BaseError v-for="error in $v.email.$errors" :key="error.$uid">{{
                error.$message
              }}</BaseError>

              <BaseLabel id="password" text="Password" />
              <BaseInput
                type="password"
                id="password"
                v-model="formData.password"
                placeholderText="Enter Your Password"
                @input="clearError('password')"
              />
              <BaseError
                v-for="error in $v.password.$errors"
                :key="error.$uid"
                >{{ error.$message }}</BaseError
              >

              <span class="text-slate-500 text-sm my-2"
                >Forgot your password?</span
              >

              <FormButton
                type="submit"
                text="SIGN IN"
                :class="loading ? 'bg-transparent' : ''"
              ></FormButton>
            </form>
            <span class="text-slate-500 text-sm"
              >Don't have an account?&nbsp;<span
                class="text-red-900 text-sm font-semibold"
                >Request Now.</span
              ></span
            >
          </div>
          <!-- <div class="w-full border-2 absolute bottom-0 flex border-white py-4">
            <img src="../assets/images/bulsu_logo.png" class="w-16" />
          </div> -->
        </div>
      </div>
    </div>
  </main>
</template>

<script setup>
import ScreenLoader from "@/components/ScreenLoader.vue";
import BaseLabel from "@/components/InputComponents/BaseLabel.vue";
import BaseInput from "@/components/InputComponents/BaseInput.vue";
import BaseError from "@/components/InputComponents/BaseError.vue";
import FormButton from "@/components/FormButton.vue";
import { reactive, computed } from "vue";
import { minLength, required, helpers } from "@vuelidate/validators";
import { useVuelidate } from "@vuelidate/core";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
import Swal from "sweetalert2";

const formData = reactive({
  email: "",
  password: "",
});

const rules = computed(() => {
  return {
    email: {
      required: helpers.withMessage("Email required", required),
      /*  minLength: minLength(6), */
    },
    password: {
      required: helpers.withMessage("Password required", required),
      /* strongPassword: helpers.withMessage(
        "Password must contain 8-32 characters, with uppercase and lowercase letters, and at least one number",
        helpers.regex(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,32}$/)
      ), */
    },
  };
});

const loading = computed(() => store.state.loading.showLoading);

const clearError = (field) => {
  $v[field].$touch();
};

const $v = useVuelidate(rules, formData);
const store = useStore();
const router = useRouter();

const submitForm = async (ev) => {
  ev.preventDefault();
  const result = await $v.value.$validate();
  if (result) {
    loginUser(ev);
  }
};

function loginUser(ev) {
  ev.preventDefault();
  store
    .dispatch("login", formData)
    .then((data) => {
      console.log(data);
      if (data.message == "wrong credentials") {
        console.log(data.message);
        Swal.fire({
          text: "ih mali",
          icon: "error",
          timer: 1000,
          showConfirmButton: false,
        }).then(() => {
          store.commit("setAuth", false);
          (formData.email = ""), (formData.password = ""), $v.value.$reset();
        });
      } else {
        const userName = store.getters.getUser;

        Swal.fire({
          text: "Welcome, " + userName,
          icon: "success",
          padding: "2rem",
          width: "auto",
          timer: 1000,
          showConfirmButton: false,
        }).then(() => {
          store.commit("setAuth", true);
          alert("Welcome, " + userName);
          /* router.push({
            path: "/dashboard",
          }); */
        });
      }
    })
    .catch((error) => {
      console.log(error);
    });
}
</script>

<style scoped>
.bg {
  background-image: url("../assets/images/BackgroundImage.png");
  background-size: cover;
  background-attachment: fixed;
  background-position: center;
  background-repeat: no-repeat;
}

.bg1 {
  background-color: rgba(127, 29, 29, 0.8);
}
</style>
