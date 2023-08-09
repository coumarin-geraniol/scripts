var $menuTrigger = $('.js-menuToggle');
var $topNav = $('.js-topPushNav');
var $openLevel = $('.js-openLevel');
var $closeLevel = $('.js-closeLevel');
var $closeLevelTop = $('.js-closeLevelTop');
var $navLevel = $('.js-pushNavLevel');
function openPushNav() {
    $topNav.addClass('isOpen');
    $('body').addClass('pushNavIsOpen');
}

function closePushNav() {
    $topNav.removeClass('isOpen');
    $openLevel.siblings().removeClass('isOpen');
    $('body').removeClass('pushNavIsOpen');
}

$menuTrigger.on('click touchstart', function(e) {
    e.preventDefault();
    if ($topNav.hasClass('isOpen')) {
        closePushNav();
    } else {
        openPushNav();
    }
});

$openLevel.on('click touchstart', function(){
    $(this).next($navLevel).addClass('isOpen');
});

$closeLevel.on('click touchstart', function(){
    $(this).closest($navLevel).removeClass('isOpen');
});

$closeLevelTop.on('click touchstart', function(){
    closePushNav();
});

$('.screen').click(function() {
    closePushNav();
});

