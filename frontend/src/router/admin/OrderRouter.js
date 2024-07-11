import Index from "@/views/admin/order/Index.vue";
import Create from "@/views/admin/order/Create.vue";
import Edit from "@/views/admin/order/Edit.vue";

export default [

    {
        path: '/order',
        name: 'Order',
        component: Index
    },

    {
        path: '/add-order',
        name: 'AddOrder',
        component: Create
    },

    {
        path: '/edit-order/:id',
        name: 'EditOrder',
        component: Edit
    }
];