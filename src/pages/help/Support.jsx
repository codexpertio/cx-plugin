import { useState } from 'react';
import Header from '../../components/Header';
import Footer from '../../components/Footer';
import apiFetch from "@wordpress/api-fetch";
import axios from "axios";
import $ from "jquery";


const Support = () => {


    const [firstName, setFirstName] = useState('');

    const raiseTicket = e => {
        e.preventDefault();
    
        alert('Hello there.. '+firstName)

        axios.defaults.headers.common['X-WP-Nonce'] = CXP.rest_nonce;

        axios
        .post('http://wp.wp/wp-json/wp/v2/posts', {
            title: 'another post from API',
            status: 'publish',
            content: 'this is a test post made using a rest API call'
        } )
        .then((res) => {
            console.log(res)
        });
    }

    return (
        <div className="wrap">
            <Header />

            <h1>Support Ticket</h1>

            <form onSubmit={raiseTicket} method="post">
                <p>
                    <input type="text" name="first_name" placeholder="Your Name" onChange={ (e) => setFirstName(e.target.value) } value={firstName} required />
                </p>
                <p>
                    <textarea placeholder="Please elaborate on the issue you're facing"></textarea>
                </p>
                <p>
                    <input type="submit" value="Send" />
                </p>
            </form>

            <Footer />
        </div>
    );
};

export default Support;
