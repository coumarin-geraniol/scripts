var $menuTrigger = $('.js-menuToggle');
var $topNav = $('.js-topPushNav');
var $openLevel = $('.js-openLevel');
var $closeLevel = $('.js-closeLevel');
var $closeLevelTop = $('.js-closeLevelTop');
var $navLevel = $('.js-pushNavLevel');

function updateBreadcrumbs(level) {
    var breadcrumbs = [];
    level.parentsUntil($topNav, $navLevel).each(function() {
        var openLevel = $(this).find('> .js-openLevel').text().trim();
        breadcrumbs.unshift(openLevel);
    });

    var $breadcrumbList = level.find('> .breadcrumb');
    $breadcrumbList.empty();
    breadcrumbs.forEach(function(crumb) {
        var $crumbElement = $('<li></li>').text(crumb);
        $breadcrumbList.append($crumbElement);
    });
}

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
    var $nextLevel = $(this).next($navLevel);
    $nextLevel.addClass('isOpen');
    updateBreadcrumbs($nextLevel);
});

$closeLevel.on('click touchstart', function(){
    var $currentLevel = $(this).closest($navLevel);
    $currentLevel.removeClass('isOpen');
});

$closeLevelTop.on('click touchstart', function(){
    closePushNav();
});


$openLevel.on('click touchstart', function(){
    var $thisNav = $(this).next($navLevel);
    $thisNav.addClass('isOpen');
    var breadcrumbs = [];
    var parent = $(this);

    while (parent.length > 0) {
        var crumbText = parent.text().trim();
        var crumb = $('<a>').text(crumbText).attr('href', '#').addClass('breadcrumb-item');
        (function($navLevel){
            crumb.on('click', function(e) {
                e.preventDefault();
                $('.pushNav_level').removeClass('isOpen');
                $navLevel.addClass('isOpen');
            });
        })($thisNav);
        breadcrumbs.unshift(crumb);
        parent = parent.closest('.pushNav_level').prev('.js-openLevel');
    }

    var $breadcrumbList = $thisNav.find('ul.breadcrumb').first();
    $breadcrumbList.empty();
    $.each(breadcrumbs, function(index, crumb) {
        var li = $('<li>').append(crumb);
        $breadcrumbList.append(li);
    });
});
