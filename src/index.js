import Help from "./Help";
import License from "./License";
import { render } from '@wordpress/element';

// render help page
if( window.location.search.includes('cx-plugin-help') ) {
	render(<Help />, document.getElementById('cx-plugin_help'));
}

if( window.location.search.includes('cx-plugin-license') ) {
	render(<License />, document.getElementById('cx-plugin_license'));
}