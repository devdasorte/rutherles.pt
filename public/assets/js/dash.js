"use strict";
var flg = "0";




if (typeof window.slideDown !== "function") {
    window.slideDown = function(target, duration = 0) {
        if (!target) return; // Verifica se o target é válido
        target.style.removeProperty("display");
        let display = window.getComputedStyle(target).display;

        if (display === "none") display = "block";

        target.style.display = display;

        let height = target.offsetHeight;
        target.style.overflow = "hidden";
        target.style.height = 0;
        target.style.paddingTop = 0;
        target.style.paddingBottom = 0;
        target.style.marginTop = 0;
        target.style.marginBottom = 0;
        target.offsetHeight; // Força o reflow para garantir que a transição ocorra

        target.style.boxSizing = "border-box";
        target.style.transitionProperty = "height, margin, padding";
        target.style.transitionDuration = `${duration}ms`;
        target.style.height = `${height}px`;
        target.style.removeProperty("padding-top");
        target.style.removeProperty("padding-bottom");
        target.style.removeProperty("margin-top");
        target.style.removeProperty("margin-bottom");

        window.setTimeout(() => {
            target.style.removeProperty("height");
            target.style.removeProperty("overflow");
            target.style.removeProperty("transition-duration");
            target.style.removeProperty("transition-property");
        }, duration);
    };
}


function horizontalmobilemenuclick() {
    var vw = window.innerWidth;
    var pcnavlinklist = document.querySelector(".dash-navbar li");
    if (pcnavlinklist) {
        pcnavlinklist.removeEventListener("click", function () {});
    }

    var pclinkclick = document.querySelectorAll(
        ".dash-navbar > li:not(.dash-caption)"
    );
    for (var i = 0; i < pclinkclick.length; i++) {
        pclinkclick[i].addEventListener("click", function (event) {
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            targetElement.parentNode.children[1].removeAttribute("style");
            if (targetElement.parentNode.classList.contains("dash-trigger")) {
                targetElement.parentNode.classList.remove("dash-trigger");
            } else {
                var tc = document.querySelectorAll("li.dash-trigger");
                for (var t = 0; t < tc.length; t++) {
                    var c = tc[t];
                    c.classList.remove("dash-trigger");
                }
                targetElement.parentNode.classList.add("dash-trigger");
            }
        });
    }
    var pcsublinkclick = document.querySelectorAll(
        ".dash-navbar > li:not(.dash-caption) > .dash-submenu > li"
    );
    for (var n = 0; n < pcsublinkclick.length; n++) {
        pcsublinkclick[n].addEventListener("click", function (event) {
            event.stopPropagation();
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            targetElement.parentNode.children[1].removeAttribute("style");
            if (targetElement.parentNode.classList.contains("dash-trigger")) {
                targetElement.parentNode.classList.remove("dash-trigger");
            } else {
                var tc = document.querySelectorAll(".dash-submenu li.dash-trigger");
                for (var t = 0; t < tc.length; t++) {
                    var c = tc[t];
                    c.classList.remove("dash-trigger");
                }
                targetElement.parentNode.classList.add("dash-trigger");
            }
        });
    }
    var pcsubchildlinkclick = document.querySelectorAll(
        ".dash-navbar > li:not(.dash-caption) > .dash-submenu >  li > .dash-submenu >  li"
    );
    for (var n = 0; n < pcsubchildlinkclick.length; n++) {
        pcsubchildlinkclick[n].addEventListener("click", function (event) {
            event.stopPropagation();
            var targetElement = event.target;
            if (targetElement.tagName == "SPAN") {
                targetElement = targetElement.parentNode;
            }
            targetElement.parentNode.children[1].removeAttribute("style");
            if (targetElement.parentNode.classList.contains("dash-trigger")) {
                targetElement.parentNode.classList.remove("dash-trigger");
            } else {
                var tc = document.querySelectorAll(
                    ".dash-submenu .dash-submenu li.dash-trigger"
                );
                for (var t = 0; t < tc.length; t++) {
                    var c = tc[t];
                    c.classList.remove("dash-trigger");
                }
                targetElement.parentNode.classList.add("dash-trigger");
            }
        });
    }
}

// Menu click start
function addscroller() {
    rmmini();
    menuclick();
    // Menu scrollbar start
    if (document.querySelector(".navbar-content")) {
        var px = new PerfectScrollbar(".navbar-content", {
            wheelSpeed: 0.5,
            swipeEasing: 0,
            suppressScrollX: !0,
            wheelPropagation: 1,
            minScrollbarLength: 40,
        });
    }
    // Menu scrollbar end
}
// Menu click start
function menuclick() {
    var vw = window.innerWidth;
    var elem = document.querySelectorAll(".dash-navbar li");
    for (var j = 0; j < elem.length; j++) {
        elem[j].removeEventListener("click", function () {});
    }

    var minimenu = document.querySelector("body.minimenu");
    if (!minimenu) {
        var elem = document.querySelectorAll(
            ".dash-navbar li:not(.dash-trigger) .dash-submenu"
        );


        for (var j = 0; j < elem.length; j++) {
            elem[j].style.display = "none";
        }
        var pclinkclick = document.querySelectorAll(
            ".dash-navbar > li:not(.dash-caption)"
        );
        for (var i = 0; i < pclinkclick.length; i++) {
            pclinkclick[i].addEventListener("click", function (event) {
                event.stopPropagation();
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                if (targetElement.parentNode.classList.contains("dash-trigger")) {
                    targetElement.parentNode.classList.remove("dash-trigger");
                    // targetElement.parentNode.children[1].style.display = "none";
                    slideUp(targetElement.parentNode.children[1], 200);
                } else {
                    var tc = document.querySelectorAll("li.dash-trigger");
                    for (var t = 0; t < tc.length; t++) {
                        var c = tc[t];
                        c.classList.remove("dash-trigger");
                        slideUp(c.children[1], 200);
                    }
                    targetElement.parentNode.classList.add("dash-trigger");
                    var tmp = targetElement.children[1];
                    console.log(tmp);
                    if (tmp) {
                        slideDown(targetElement.parentNode.children[1], 200);
                    }
                }
            });
        }
        var pcsublinkclick = document.querySelectorAll(
            ".dash-navbar > li:not(.dash-caption) li"
        );
        for (var i = 0; i < pcsublinkclick.length; i++) {
            pcsublinkclick[i].addEventListener("click", function (event) {
                var targetElement = event.target;
                if (targetElement.tagName == "SPAN") {
                    targetElement = targetElement.parentNode;
                }
                event.stopPropagation();
                if (targetElement.parentNode.classList.contains("dash-trigger")) {
                    targetElement.parentNode.classList.remove("dash-trigger");
                    slideUp(targetElement.parentNode.children[1], 200);
                } else {
                    var tc = targetElement.parentNode.parentNode.children;
                    for (var t = 0; t < tc.length; t++) {
                        var c = tc[t];
                        c.classList.remove("dash-trigger");
                        if (c.tagName == "LI") {
                            c = c.children[0];
                        }
                        if (c.parentNode.classList.contains("dash-hasmenu")) {
                            slideUp(c.parentNode.children[1], 200);
                        }
                    }
                    targetElement.parentNode.classList.add("dash-trigger");
                    var tmp = targetElement.parentNode.children[1];
                    if (tmp) {
                        tmp.removeAttribute("style");
                        slideDown(tmp, 200);
                    }
                }
            });
        }
    }
}

function rmdrp() {
    document
        .querySelector(".dash-header:not(.dash-mob-header) .dash-mob-drp")
        .classList.remove("mob-drp-active");
    document
        .querySelector(".dash-header:not(.dash-mob-header) .dash-md-overlay")
        .remove();
}

function rmthead() {
    document
        .querySelector(".dash-header:not(.dash-mob-header)")
        .classList.remove("mob-header-active");
    document
        .querySelector(".dash-header:not(.dash-mob-header) .dash-md-overlay")
        .remove();
}

function rmmenu() {
    var tempov = document.querySelector(".dash-sidebar");
    if (tempov) {
        document
            .querySelector(".dash-sidebar")
            .classList.remove("mob-sidebar-active");
    }
    if (document.querySelector(".topbar")) {
        document.querySelector(".topbar").classList.remove("mob-sidebar-active");
    }

    document.querySelector(".dash-sidebar .dash-menu-overlay").remove();
    if (document.querySelector(".topbar .dash-menu-overlay")) {
        document.querySelector(".topbar .dash-menu-overlay").remove();
    }
}

function rmovermenu() {
    document
        .querySelector(".dash-sidebar")
        .classList.remove("dash-over-menu-active");
    if (document.querySelector(".topbar")) {
        document.querySelector(".topbar").classList.remove("mob-sidebar-active");
    }
    document.querySelector(".dash-sidebar .dash-menu-overlay").remove();
    document.querySelector(".topbar .dash-menu-overlay").remove();
}

function rmactive() {
    document
        .querySelector(".dash-sidebar .dash-navbar li")
        .classList.remove("active");
    document
        .querySelector(".dash-sidebar .dash-navbar li")
        .classList.remove("dash-trigger");
    document.querySelector(".topbar .dropdown").classList.remove("show");
    document.querySelector(".topbar .dropdown-menu").classList.remove("show");
    document.querySelector(".dash-sidebar .dash-menu-overlay").remove();
    document.querySelector(".topbar .dash-menu-overlay").remove();
}

function rmmini() {
    // var vw = document.querySelector(window)[0].innerWidth;
    var vw = window.innerWidth;
    if (vw <= 1024) {
        if (document.querySelector("body").classList.contains("minimenu")) {
            document.querySelector("body").classList.remove("minimenu");
            flg = "1";
            2;
        }
    } else {
        if (vw > 1024) {
            if (flg == "1") {
                document.querySelector("body").classList.add("minimenu");
                flg = "0";
            }
        }
    }
}
var emailmorelink = document.querySelector(".email-more-link");
if (emailmorelink) {
    emailmorelink.addEventListener("click", function (e) {
        document.querySelector(this).children("span").slideToggle(1);
    });
}

// Menu click end
window.addEventListener("resize", function () {
    if (!document.querySelector("body").classList.contains("dash-horizontal")) {
        rmmini();
        // menuclick();
    }
    if (document.querySelector("body").classList.contains("dash-horizontal")) {
        rmactive();
    }
});

window.addEventListener("load", function () {
    var tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    var popoverTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="popover"]')
    );
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    var toastElList = [].slice.call(document.querySelectorAll(".toast"));
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl);
    });
});
// active menu item list start
var elem = document.querySelectorAll(".dash-sidebar .dash-navbar a");
for (var l = 0; l < elem.length; l++) {
    var pageUrl = window.location.href.split(/[?#]/)[0];
    if (elem[l].href == pageUrl && elem[l].getAttribute("href") != "") {
        elem[l].parentNode.classList.add("active");
        elem[l].parentNode.parentNode.parentNode.classList.add("active");
        elem[l].parentNode.parentNode.parentNode.classList.add("dash-trigger");
        elem[l].parentNode.parentNode.style.display = "block";

        elem[
            l
        ].parentNode.parentNode.parentNode.parentNode.parentNode.classList.add(
            "active"
        );
        elem[
            l
        ].parentNode.parentNode.parentNode.parentNode.parentNode.classList.add(
            "dash-trigger"
        );
        elem[l].parentNode.parentNode.parentNode.parentNode.style.display = "block";

        // elem[i].parentNode('li').parentNode().parentNode('.sidelink').classList.add("active");
        // elem[i].parentNodes('.dash-tabcontent').classList.add('active');
        if (document.body.classList.contains("tab-layout")) {
            var temp = document
                .querySelector(".dash-tabcontent.active")
                .getAttribute("data-value");
            document
                .querySelector(".tab-sidemenu > ul > li")
                .classList.remove("active");
            document
                .querySelector('.tab-sidemenu > ul > li > a[data-cont="' + temp + '"]')
                .parentNode.classList.add("active");
        }
    }
}

// Menu click for tab Layout start
var tablayclick = document.querySelector(".tab-sidemenu > ul > li");
if (tablayclick) {
    var tc = document.querySelectorAll(".tab-sidemenu > ul > li");
    for (var t = 0; t < tc.length; t++) {
        var c = tc[t];
        c.addEventListener("click", function (event) {
            var targetElement = event.target;
            if (targetElement.tagName == "A") {
                targetElement = targetElement.parentNode;
            }
            if (targetElement.tagName == "I") {
                targetElement = targetElement.parentNode.parentNode;
            }
            var tempcont = targetElement.children[0].getAttribute("data-cont");
            document
                .querySelector(".navbar-content .dash-tabcontent.active")
                .classList.remove("active");
            document
                .querySelector(".tab-sidemenu > ul > li.active")
                .classList.remove("active");
            targetElement.classList.add("active");
            document
                .querySelector(
                    '.navbar-content .dash-tabcontent[data-value="' + tempcont + '"]'
                )
                .classList.add("active");
        });
    }
}
// Menu click for tab Layout end
// nested Layout start
var pctogglesidemenu = document.querySelector(".dash-toggle-sidemenu");
if (pctogglesidemenu) {
    pctogglesidemenu.addEventListener("click", function () {
        if (
            !document
            .querySelector(".dash-toggle-sidemenu")
            .classList.contains("active")
        ) {
            document.querySelector(".dash-sideoverlay").classList.add("active");
            document.querySelector(".page-sidebar").classList.add("active");
            document.querySelector(".dash-toggle-sidemenu").classList.add("active");
        } else {
            document.querySelector(".dash-sideoverlay").classList.remove("active");
            document.querySelector(".page-sidebar").classList.remove("active");
            document
                .querySelector(".dash-toggle-sidemenu")
                .classList.remove("active");
        }
    });
}
var pcovelayclk = document.querySelector(
    ".dash-sideoverlay, .dash-toggle-sidemenu.active"
);
if (pcovelayclk) {
    pcovelayclk.addEventListener("click", function () {
        document.querySelector(".dash-sideoverlay").classList.remove("active");
        document.querySelector(".page-sidebar").classList.remove("active");
        document.querySelector(".dash-toggle-sidemenu").classList.remove("active");
    });
}
// nested Layout end


var layout_topbar = document.querySelector("body.layout-topbar");
if (layout_topbar) {
    var tplink = document.querySelectorAll(
        ".dash-header .list-unstyled > .dropdown"
    );
    for (var t = 0; t < tplink.length; t++) {
        var c = tplink[t];
        c.addEventListener("mouseenter", showmenu);
        c.addEventListener("mouseleave", hidemenu);
    }
}

function showmenu(event) {
    event.target.children[1].classList.add("show");
}

function hidemenu(event) {
    event.target.children[1].classList.remove("show");
}
// topbar Layout end
// horizontal submenu edge start
var dash_horizontal = document.querySelector("body.dash-horizontal");
if (dash_horizontal) {
    var hpx;
    var docH = window.innerHeight;
    var docW = window.innerWidth;

    if (docW > 1024) {
        var topbarhasmenu = document.querySelector(
            ".dash-horizontal .topbar .dash-submenu .dash-hasmenu"
        );
        if (topbarhasmenu) {
            topbarhasmenu.addEventListener(
                "mouseenter",
                function () {
                    var elm = targetElement.children[1];
                    var off = elm.getBoundingClientRect();
                    var l = off.left;
                    var t = off.top;
                    var w = off.width;
                    var h = off.height;
                    var scrw = document.documentElement.scrollTop;

                    var edgepos = l + w <= docW;
                    if (!edgepos) {
                        elm.classList.add("edge");
                    }
                    var isEntirelyVisible = t + h <= docH;
                    if (!isEntirelyVisible) {
                        var th = t - scrw;
                        elm.classList.add("scroll-menu");
                        elm.css("max-height", "calc(100vh - " + th + "px)");
                        hpx = new PerfectScrollbar(".scroll-menu", {
                            wheelSpeed: 0.5,
                            swipeEasing: 0,
                            suppressScrollX: !0,
                            wheelPropagation: 1,
                            minScrollbarLength: 40,
                        });
                    }
                },
                function () {
                    hpx.destroy();
                    document.querySelector(".scroll-menu").removeAttribute("style");
                    document
                        .querySelector(".scroll-menu")
                        .classList.remove("scroll-menu");
                }
            );
        }
    }
}
// horizontal submenu edge end
// Collapse meni edge start
function collapseedge() {
    var hpx;
    var docH = window.innerHeight;
    var docW = window.innerWidth;
    if (docW > 1024) {
        var minimenuhasmenu = document.querySelector(
            ".minimenu .dash-sidebar .dash-submenu .dash-hasmenu"
        );
        if (minimenuhasmenu) {
            minimenuhasmenu.addEventListener(
                "mouseenter",
                function (event) {
                    var targetElement = event.target;
                    var elm = targetElement.children[1];
                    var off = elm.getBoundingClientRect();
                    var l = off.left;
                    var t = off.top;
                    var w = off.width;
                    var h = off.height;
                    var scrw = document.documentElement.scrollTop;

                    var isEntirelyVisible = t + h <= docH;
                    if (!isEntirelyVisible) {
                        var th = t - scrw;
                        elm.classList.add("scroll-menu");
                        elm.css("max-height", "calc(100vh - " + th + "px)");
                        hpx = new PerfectScrollbar(".scroll-menu", {
                            wheelSpeed: 0.5,
                            swipeEasing: 0,
                            suppressScrollX: !0,
                            wheelPropagation: 1,
                            minScrollbarLength: 40,
                        });
                    }
                },
                function () {
                    hpx.destroy();
                    document.querySelector(".scroll-menu").removeAttribute("style");
                    document
                        .querySelector(".scroll-menu")
                        .classList.remove("scroll-menu");
                }
            );
        }
    }
}
// Collapse meni edge end
var tc = document.querySelectorAll(".prod-likes .form-check-input");
for (var t = 0; t < tc.length; t++) {
    var prodlike = tc[t];
    prodlike.addEventListener("change", function (event) {
        if (event.currentTarget.checked) {
            prodlike = event.target;
            prodlike.parentNode.insertAdjacentHTML(
                "beforeend",
                '<div class="dash-like"><div class="like-wrapper"><span><span class="dash-group"><span class="dash-dots"></span><span class="dash-dots"></span><span class="dash-dots"></span><span class="dash-dots"></span></span></span></div></div>'
            );
            prodlike.parentNode
                .querySelector(".dash-like")
                .classList.add("dash-like-animate");
            setTimeout(function () {
                prodlike.parentNode.querySelector(".dash-like").remove();
            }, 3000);
        } else {
            prodlike = event.target;
            prodlike.parentNode.querySelector(".dash-like").remove();
        }
    });
}

// =======================================================
// =======================================================

var slideToggle = (target, duration = 0) => {
    if (window.getComputedStyle(target).display === "none") {
        return slideDown(target, duration);
    } else {
        return slideUp(target, duration);
    }
};
// =======================================================
// =======================================================
