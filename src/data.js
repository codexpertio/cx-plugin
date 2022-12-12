import Dashboard from './pages/Dashboard';
import About from './pages/About';

export const routes = [
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

export const buttons = [
    {
        id      : 'changelog',
        url     : 'https://wordpress.org/plugins/cx-plugin/#developers',
        label   : 'Changelog',
    },
    {
        id      : 'community',
        url     : 'https://facebook.com/groups/codexpert.io',
        label   : 'Community',
    },
    {
        id      : 'website',
        url     : 'https://codexpert.io/',
        label   : 'Official Website',
    },
    {
        id      : 'support',
        url     : 'https://help.codexpert.io/',
        label   : 'Ask Support',
    },
];