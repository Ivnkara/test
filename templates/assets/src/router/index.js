import CompanyList from '@/components/CompanyList.vue';
import CompanyForm from '@/components/CompanyForm.vue';
import { createRouter, createWebHistory } from "vue-router";

const routes = [
    {
        path: '',
        name: 'CompanyList',
        component: CompanyList,
    },
    {
        path: '/new',
        methods: ['POST'],
        name: 'CompanyNew',
        component: CompanyForm
    },
    {
        path: '/:id/edit',
        methods: ['PUT'],
        name: 'CompanyEdit',
        component: CompanyForm,
    },
    {
        path: '/:id',
        name: 'CompanyShow',
        component: CompanyForm,
    },
    {
        path: '/:id',
        methods: ['DELETE'],
        name: 'CompanyDelete',
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
