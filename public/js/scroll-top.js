jQuery(function($) {
    let scroll = window.scrollY;
    let button = $("a[href='#top']");
    /*if (scroll === 0) {
        button.hide();
    }*/
    button.click(function () {
        $("html, body").animate({scrollTop: 0}, "slow");
        return false;
    });
});