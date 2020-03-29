window.$ = require('jquery')
window.jQuery = window.$

require('jquery-lazy')
require('popper.js')
require('bootstrap')
require('jquery.cookie')
require('jquery-serializejson')
require('jquery-inputmask')
require('./components/sweetalert/sweetalert')
require('./components/sweetalert/sweetalert_functions')
require('./functions')
require('./modules/cart')
window.PhotoSwipe = require('photoswipe')
window.PhotoSwipeUI_Default = require('photoswipe').PhotoSwipeUI_Default

$(function ($) {
    $("img.lazy").Lazy();
});