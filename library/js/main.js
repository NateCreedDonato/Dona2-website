import $ from 'jquery';  
window.jQuery = $; window.$ = $;

import './functions';
import { preloadImages } from './utils';




// Preload  images and fonts
Promise.all([preloadImages('img')]).then(() => {

    $("body").addClass("loaded");

});