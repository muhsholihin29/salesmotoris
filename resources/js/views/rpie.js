$(function() {

    //income
    var $ppc = $('.progress-pie-chart.income'),
        percent = parseInt($ppc.data('percent')),
        deg = 360 * percent / 100;
    if (percent > 50) {
        $ppc.addClass('gt-50');
    }
    $('.ppc-progress .income').css('transform', 'rotate(' + deg + 'deg)');
    $('.ppc-percents span.income').html(percent + '%');

    //eff-call
    var $ppc = $('.progress-pie-chart.eff-call'),
        percent = parseInt($ppc.data('percent')),
        deg = 360 * percent / 100;
    if (percent > 50) {
        $ppc.addClass('gt-50');
    }
    $('.ppc-progress .eff-call').css('transform', 'rotate(' + deg + 'deg)');
    $('.ppc-percents span.eff-call').html(percent + '%');

    //product-focus
    var $ppc = $('.progress-pie-chart.product-focus'),
        percent = parseInt($ppc.data('percent')),
        deg = 360 * percent / 100;
    if (percent > 50) {
        $ppc.addClass('gt-50');
    }
    $('.ppc-progress .product-focus').css('transform', 'rotate(' + deg + 'deg)');
    $('.ppc-percents span.product-focus').html(percent + '%');

});