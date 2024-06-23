import { defineStore } from 'pinia';
import { Ref, ref } from 'vue';
import { api, web } from 'boot/axios';
import { Notify } from 'quasar';

export enum Role {
  User = 0,
  Admin = 1,
  UserGuest = 2,
  AdminGuest = 3,
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

    return api
      .post('login', credentials)
      .then((response) => {
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
    return api
      .get('user')
      .then((response) => {
        user.value = response.data.data;
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

  const logout = async () => {
    return api
      .post('logout')
      .then((response) => {
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

  return { user, login, logout, getUser };
});
