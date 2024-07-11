import Edit from "@/views/admin/customer/Edit.vue";
import index from "@/views/admin/customer/Index.vue";
import create from "@/views/admin/customer/Create.vue";

export default [

    {
        path: '/customer',
        name: 'Customer',
        component: index
    },

    {
        path: '/add-customer',
        name: 'AddCustomer',
        component: create
    },

    {
        path: '/edit-customer/:id',
        name: 'EditCustomer',
        component: Edit
    }
];