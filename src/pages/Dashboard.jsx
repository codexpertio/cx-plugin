import { useState, useEffect } from 'react';
import axios from "axios";
import Header from '../components/Header';
import Footer from '../components/Footer';

const Dashboard = () => {

    const [ posts, setPosts ] = useState([]);

    useEffect( () => {
        axios.get('https://codexpert.io/wp-json/wp/v2/posts').then((res) => {
            setPosts(res.data);
        });
    }, [] );

    const html = [];

    { posts.map(post => {
        html.push(<h1>{post.title.rendered}</h1>)
    })}

    return (
        <>
            <Header />
            <h1>Dashboard</h1>
            {html}
            <Footer />
        </>
    );
};

export default Dashboard;
