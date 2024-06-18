/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

$('.down-arrow').click(function() {
    var label = $(this);
    var parent = label.parent('.acnav-label');
    var list = parent.siblings('.acnav-list');
    if (parent.hasClass('is-open')) {
        list.slideUp('fast');
        parent.removeClass('is-open');
    } else {
        list.slideDown('fast');
        parent.addClass('is-open');
    }
});
