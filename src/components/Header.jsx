import React from 'react'
import {routes} from '../data';
import { Link } from 'react-router-dom';

const Header = () => {
    return (
        <div className='header'>
            <div id="cx-plugin-tabs">
                {routes.map((route, index) => (
                    <Link to={route.path}>{route.label}</Link>
                ))}
            </div>
        </div>
    );
}

export default Header;