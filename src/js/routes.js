import VueRouter from 'vue-router';

let routes = [
    {
        path: '/login',
        component: require('./views/login/Login')
    },
    {
        path: '*',
        redirect: '/'
    }
];

let router =  new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (Vue.cookie.get('token')) {
            next();
        } else {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            });
        }
    } else {
        next();
    }
});

export default router;
