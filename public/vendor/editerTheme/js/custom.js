$(document).ready(function() {
    // Wrapper top space
    $(window).on('load resize orientationchange', function() {
        var header_hright = $('site-header').outerHeight();
        $('site-header').next('.wrapper').css('margin-top', header_hright + 'px');
    });

    /********* Multi-level accordion nav  ********/

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
    $(".categories-sidebar-popup-menu-row" ).each(function (){
        $(this).click(function(){
          clearStyle();
          $(this).addClass("active");
        });
      });

      function clearStyle(){
        buttonWithActive = $('.categories-sidebar-popup-menu-row.active');
        buttonWithActive.removeClass('active');
      }

    $(".menu-item").click(function () {
        $(".menu-item.active").removeClass('active')
        $(this).addClass('active')
    });

    $(".sider-button").click(function(){
        $(".left-bar").toggleClass("leftbar-collapsed");
    });

    $(".menu-btn").click(function(){
        $(".left-bar").toggleClass("leftbar-visible");
    });

    if ($(".right-inner-content").length > 0) {
        jQuery(function ($) {
            var topMenuHeight = $("#right-inner-nav").outerHeight();
            $("#right-inner-nav").menuScroll(topMenuHeight);
            $(".right-inner-list li:first-child").addClass("active");
        });
        jQuery.fn.extend({
            menuScroll: function (offset) {
                // Declare all global variables
                var topMenu = this;
                var topOffset = offset ? offset : 0;
                var menuItems = $(topMenu).find("a");
                var lastId;
                // Save all menu items into scrollItems array
                var scrollItems = $(menuItems).map(function () {
                    var item = $($(this).attr("href"));
                    if (item.length) {
                        return item;
                    }
                });
                // When the menu item is clicked, get the #id from the href value, then scroll to the #id element
                $(topMenu).on("click", "a", function (e) {
                    var href = $(this).attr("href");
                    var offsetTop = href === "#" ? 0 : $(href).offset().top - topOffset;
                    function checkWidth() {
                        var windowSize = $(window).width();
                        if (windowSize <= 767) {
                            $('html, body').stop().animate({
                                scrollTop: offsetTop - 200
                            }, 300);
                        }
                        else {
                            $('html, body').stop().animate({
                                scrollTop: offsetTop - 100
                            }, 300);
                        }
                    }
                    // Execute on load
                    checkWidth();
                    // Bind event listener
                    $(window).resize(checkWidth);
                    e.preventDefault();
                });
                // When page is scrolled
                $(window).scroll(function () {
                    function checkWidth() {
                        var windowSize = $(window).width();
                        if (windowSize <= 767) {
                            var nm = $("html").scrollTop();
                            var nw = $("body").scrollTop();
                            var fromTop = (nm > nw ? nm : nw) + topOffset;
                            // When the page pass one #id section, return all passed sections to scrollItems and save them into new array current
                            var current = $(scrollItems).map(function () {
                                if ($(this).offset().top - 250 <= fromTop)
                                    return this;
                            });
                            // Get the most recent passed section from current array
                            current = current[current.length - 1];
                            var id = current && current.length ? current[0].id : "";
                            if (lastId !== id) {
                                lastId = id;
                                // Set/remove active class
                                $(menuItems)
                                    .parent().removeClass("active")
                                    .end().filter("[href='#" + id + "']").parent().addClass("active");
                            }
                        }
                        else {
                            var nm = $("html").scrollTop();
                            var nw = $("body").scrollTop();
                            var fromTop = (nm > nw ? nm : nw) + topOffset;
                            // When the page pass one #id section, return all passed sections to scrollItems and save them into new array current
                            var current = $(scrollItems).map(function () {
                                if ($(this).offset().top <= fromTop)
                                    return this;
                            });
                            // Get the most recent passed section from current array
                            current = current[current.length - 1];
                            var id = current && current.length ? current[0].id : "";
                            if (lastId !== id) {
                                lastId = id;
                                // Set/remove active class
                                $(menuItems)
                                    .parent().removeClass("active")
                                    .end().filter("[href='#" + id + "']").parent().addClass("active");
                            }
                        }
                    }
                    // Execute on load
                    checkWidth();
                    // Bind event listener
                    $(window).resize(checkWidth);
                });
            }
        });
    }
});

$(document).ready(function () {
    $(function () {
        var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $(".acnav-list li a").each(function () {
            if ($(this).attr("href") == pgurl || $(this).attr("href") == '') {
                $(this).addClass("active");
            }
        })
    });
});

$(document).ready(function () {
    $(function () {
        var pgurl = window.location.href.substr(window.location.href.lastIndexOf("/") + 1);
        $(".acnav-list li .acnav-label a").each(function () {
            if ($(this).attr("href") == pgurl || $(this).attr("href") == '') {
                $(this).addClass("active");
            }
        })
    });
});
