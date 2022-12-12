import { HashRouter, Routes, Route, Link } from 'react-router-dom';
import React from 'react';
import { routes } from './data';

const Help = () => {
    return (
        <>
            <HashRouter>
                <Routes>
                    {routes.map((route, index) => (
                        <Route
                            key={index}
                            path={route.path}
                            element={<route.element />}
                        />
                    ))}
                </Routes>
            </HashRouter>
        </>
    );
}

export default Help;