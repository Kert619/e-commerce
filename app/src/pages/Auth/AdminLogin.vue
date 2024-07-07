<template>
  <q-page class="flex flex-center">
    <q-card
      :style="
        $q.screen.lt.sm ? { width: '80%' } : { width: '30%', maxWidth: '400px' }
      "
    >
      <q-card-section>
        <q-avatar size="103px" class="absolute-center shadow-10">
          <img src="~/assets/profile.svg" />
        </q-avatar>
      </q-card-section>
      <q-card-section>
        <div class="text-center q-pt-lg">
          <div class="col text-h6 ellipsis">Log in</div>
        </div>
      </q-card-section>
      <q-card-section>
        <q-form class="q-gutter-md" @submit="onLogin">
          <q-input
            v-model="form.email"
            label="E-mail"
            lazy-rules
            :rules="emailRules"
          />
          <q-input
            type="password"
            v-model="form.password"
            label="Password"
            lazy-rules
            :rules="passwordRules"
          />
          <div>
            <q-btn
              label="Login"
              type="submit"
              color="primary"
              :loading="loading"
            />
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script setup lang="ts">
import { useAuthStore, LoginAuth } from 'src/stores/auth';
import { ref, Ref } from 'vue';
import { useRouter } from 'vue-router';
import { useValidation } from 'src/composables/useValidation';

const authStore = useAuthStore();
const loading = ref(false);

const form: Ref<LoginAuth> = ref({
  email: '',
  password: '',
});

const router = useRouter();

const { required, email } = useValidation();

const emailRules = [
  (val: string) => required(val, 'Please enter your email'),
  (val: string) => email(val, 'Please enter a valid email'),
];
const passwordRules = [
  (val: string) => required(val, 'Please enter your password'),
];

const onLogin = async () => {
  try {
    loading.value = true;
    await authStore.login(form.value);
    await authStore.getUser();
    router.replace('/admin');
  } catch (error) {
  } finally {
    loading.value = false;
  }
};
</script>
