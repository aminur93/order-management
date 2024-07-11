import Index from "@/views/admin/product/Index.vue";
import Create from "@/views/admin/product/Create.vue";
import Edit from "@/views/admin/product/Edit.vue";

export default [

    {
        path: '/product',
        name: 'Product',
        component: Index
    },

    {
        path: '/add-product',
        name: 'AddProduct',
        component: Create
    },

    {
        path: '/edit-product/:id',
        name: 'EditProduct',
        component: Edit
    }
];