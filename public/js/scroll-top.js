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

jQuery(function($) {
    let button = $("a[href='#fresh']");
    let anchor = $("#fresh");
    button.click(function (e) {
        e.preventDefault();
        $("html, body").animate({scrollTop: anchor.offset().top}, "slow");
    });
});