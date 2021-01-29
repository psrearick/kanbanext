import AllColumns from "./components/AllColumns";
import AddColumn from "./components/AddColumn";
import EditColumn from "./components/EditColumn";

export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllColumns
    },
    {
        name: 'add',
        path: '/add',
        component: AddColumn
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditColumn
    }
];
