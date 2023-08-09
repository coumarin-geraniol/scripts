var $menuTrigger = $('.js-menuToggle');
var $topNav = $('.js-topPushNav');
var $openLevel = $('.js-openLevel');
var $closeLevel = $('.js-closeLevel');
var $closeLevelTop = $('.js-closeLevelTop');
var $navLevel = $('.js-pushNavLevel');
var $breadcrumb = $('.breadcrumb');

function openPushNav() {
    $topNav.addClass('isOpen');
    $('body').addClass('pushNavIsOpen');
    $breadcrumb.empty();
    $breadcrumb.append('<li><a href="#" class="js-closeLevelTop">Close</a></li>');
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
    $breadcrumb.append('<li><a href="#" class="breadcrumb-link">' + $(this).text().trim() + '</a></li>');
    $('.breadcrumb-link').on('click', function(e) {
        e.preventDefault();
        var index = $(this).parent().index();
        $breadcrumb.children().slice(index + 1).remove();
        $openLevel.siblings().slice(index).removeClass('isOpen');
    });
});

$closeLevel.on('click touchstart', function(){
    var index = $(this).closest($navLevel).index('.js-pushNavLevel');
    $breadcrumb.children().slice(index + 1).remove();
    $(this).closest($navLevel).removeClass('isOpen');
});

$closeLevelTop.on('click touchstart', function(){
    closePushNav();
});

$('.screen').click(function() {
    closePushNav();
});
