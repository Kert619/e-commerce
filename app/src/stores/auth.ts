import { defineStore } from 'pinia';
import { Ref, ref } from 'vue';
import { api, web } from 'boot/axios';
import { Notify } from 'quasar';

export enum Role {
  User = 0,
  Admin = 1,
}

export type User = {
  name: string;
  email: string;
  role: Role;
};

export type LoginAuth = {
  email: string;
  password: string;
};

export const useAuthStore = defineStore('auth', () => {
  const user: Ref<User | null> = ref(null);

  const login = async (credentials: LoginAuth) => {
    await web.get('sanctum/csrf-cookie');

    return web
      .post('login', credentials)
      .then((response) => {
        user.value = response.data;
        return response;
      })
      .catch((error) => {
        Notify.create({
          message: error.response?.data.message,
          type: 'negative',
          position: 'top-right',
          progress: true,
        });

        throw error;
      });
  };

  const getUser = async () => {
    try {
      const response = await api.get('user');
      user.value = response.data;
    } catch (error) {}
  };

  return { user, login, getUser };
});
