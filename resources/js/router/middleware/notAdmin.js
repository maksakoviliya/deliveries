export default function notAdmin({ to, next, store }) {
    const loginQuery = { path: "/login", query: { redirect: to.fullPath } };
    if (!store.getters["auth/isAdmin"]) {
        store.dispatch("auth/getAuthUser").then(() => {
            if (!store.getters["auth/authUser"]) {
                next(loginQuery)
            }
            else next();
        });
    }
    else {
        next({ name: "clients" })
        // next({ name: "dashboard" })
    }
}