import Dashboard from './pages/Dashboard';
import About from './pages/About';

const routes = [
    {
        path: '/',
        label: 'Dashboard',
        element: Dashboard
    },
    {
        path: '/about',
        label: 'About',
        element: About
    },
];

export default routes;
