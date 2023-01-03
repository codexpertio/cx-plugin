import { useState, useEffect } from 'react';
import axios from "axios";
import Header from '../components/Header';
import Footer from '../components/Footer';
import { buttons } from '../data';

const Dashboard = () => {

    const [ posts, setPosts ] = useState([]);
    const [ loading, setLoading ] = useState(true);

    useEffect( () => {
        axios.get('https://codexpert.io/wp-json/wp/v2/posts?per_page=3').then((res) => {
            setPosts(res.data);
            setLoading(false);
        });
    }, [] );

    const postsHtml = [];

    { posts.map(post => {
        postsHtml.push(
            <div id={`cx-plugin-help-`+post.id} className="cx-plugin-help">
                <h2 className="cx-plugin-help-heading" data-target={`#cx-plugin-help-text-`+post.id}>
                    <a href={post.link} target="_blank">
                    <span className="dashicons dashicons-admin-links"></span></a>
                    <span className="heading-text">{post.title.rendered}</span>
                </h2>
                <div id={`cx-plugin-help-text-`+post.id} className="cx-plugin-help-text">
                    {post.excerpt.rendered}
                </div>
            </div>
        )
    })}

    const buttonsHtml = [];

    {buttons.map(button => {
        buttonsHtml.push(<a target="_blank" href={button.url} className="cx-plugin-help-link">{button.label}</a>)
    })}

    return (
        <>
            <div className="cx-plugin-help-tab">
                <div className="cx-plugin-documentation">
                     <div className="wrap">
                        <div id="cx-plugin-helps">
                        { ! loading ? postsHtml : 'Still loading..' }
                        </div>
                    </div>
                </div>
                <div className="cx-plugin-help-links">
                    {buttonsHtml}
                </div>
            </div>
        </>
    );
};

export default Dashboard;
