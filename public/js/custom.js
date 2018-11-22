$.nette.ext('spinner', {
    init: function () {
        spinner = $('<div></div>', { id: "ajax-spinner" });
        spinner.appendTo("body");
    },
    before: function (settings, ui, e) {
        $("#ajax-spinner").css({
            visibility: "visible",
            left: e.pageX,
            top: e.pageY
        });
    },
    complete: function () {
        $("#ajax-spinner").css({
            visibility: "hidden"
        });
    }
});

$(function () {
    $.nette.init();
});