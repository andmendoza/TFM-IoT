/*
Template Name: onRumbo
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: ecommerce cart Js File
*/

var defaultOptions = {
};

$('[data-toggle="touchspin"]').each(function (idx, obj) {
    var objOptions = $.extend({}, defaultOptions, $(obj).data());
    $(obj).TouchSpin(objOptions);
});