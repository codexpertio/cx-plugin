import React from 'react'
import { Link } from 'react-router-dom';
import routes from '../data';

const Footer = () => {
    return (
        <div className='footer'>
            {routes.map((route, index) => (
                <Link to={route.path}>{route.label}</Link>
            ))}
        </div>
     );
}

export default Footer;