import axios from "axios";
import store from "../store";

export const authClient = axios.create({
  baseURL: process.env.MIX_API_URL,
  withCredentials: true, // required to handle the CSRF token
});

/*
 * Add a response interceptor
 */
authClient.interceptors.response.use(
  (response) => {
    return response;
  },
  function (error) {
    if (
      error.response &&
      [401, 419].includes(error.response.status) &&
      store.getters["auth/authUser"] &&
      !store.getters["auth/guest"]
    ) {
      store.dispatch("auth/logout");
    }
    return Promise.reject(error);
  }
);

export default {
  async login(payload) {
    await authClient.get("/sanctum/csrf-cookie");
    return authClient.post("/login", payload);
  },
  logout() {
    return authClient.post("/logout");
  },
  async forgotPassword(payload) {
    await authClient.get("/sanctum/csrf-cookie");
    return authClient.post("/forgot-password", payload);
  },
  getAuthUser() {
    return authClient.get("/users/auth");
  },
  async resetPassword(payload) {
    await authClient.get("/sanctum/csrf-cookie");
    return authClient.post("/reset-password", payload);
  },
  updatePassword(payload) {
    return authClient.put("/user/password", payload);
  },
  async registerUser(payload) {
    await authClient.get("/sanctum/csrf-cookie");
    return authClient.post("/register", payload);
  },
  sendVerification(payload) {
    return authClient.post("/email/verification-notification", payload);
  },
  updateUser(payload) {
    return authClient.put("/user/profile-information", payload);
  },


  // Comapnies
  createCompany(payload) {
    return authClient.post("/companies", payload);
  },
  updateCompany(payload) {
    return authClient.put(`/companies/${payload.id}`, payload);
  },

  // Orders
  fetchRecipients() {
    return authClient.get("/recipients");
  },
  fetchOrders(params) {
    return authClient.get("/orders", params);
  },
  fetchOrder(id) {
    return authClient.get(`/orders/${id}`);
  },
  createOrder(payload) {
    return authClient.post("/orders", payload);
  },

  // Clients
  getClients() {
    return authClient.get("/clients");
  },
  getClient(id) {
    return authClient.get(`/clients/${id}`);
  },
  createClient(params) {
    return authClient.post('/clients', params);
  },
  updateClient(id, params) {
    return authClient.post(`/clients/${id}`, params);
  },
  removeClient(id) {
    return authClient.delete(`/clients/${id}`);
  }
};
