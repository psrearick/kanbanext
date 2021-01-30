import AllColumns from "./components/AllColumns";
import AddColumn from "./components/AddColumn";
import EditColumn from "./components/EditColumn";
import RouteNotFound from "./components/RouteNotFound";
import AddCard from "./components/AddCard";
import EditCard from "./components/EditCard";
import Card from "./components/Card";

export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllColumns
    },
    {
        name: 'add-column',
        path: '/column/add',
        component: AddColumn
    },
    {
        name: 'edit-column',
        path: '/column/edit/:id',
        component: EditColumn
    },
    {
        name: 'card',
        path: '/card/get/:id',
        component: Card

    },
    {
        name: 'add-card',
        path: '/card/add/:id',
        component: AddCard,
    },
    {
        name: 'edit-card',
        path: '/card/edit/:id',
        component: EditCard,
        props: route => ({ column: route.query.column })
    },
    {
        name: '404',
        path: '*',
        component: RouteNotFound
    }
];
