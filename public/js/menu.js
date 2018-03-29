
function menuHamburger() {
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

$(function () {
    var debugMsgs = [];
    $.each($('pre'), function (key, value) {
        console.log(value.innerHTML);
        $(this).addClass('hidden');
        debugMsgs.push(value.innerHTML);
    });
    console.log(debugMsgs);
    var debug = $('.debug');
    console.log(debug);
    var p = $('<div></div>');
    debugMsgs.forEach(function (item) {
        var pre = $('pre').append(item);
        console.log(pre);
        debug.append(pre);
    });
    $('body').prepend(debug);
    $("body").prepend(p);
});