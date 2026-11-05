$('.scroll-company').css({ 'height': (($(window).height()) - 250) + 'px' });
$('.plan-structure-new').css({ 'height': (($(window).height()) - 250) + 'px' });
jQuery(function($) {

    $(".sidebar-dropdown > a").click(function() {
        $(".sidebar-submenu").slideUp(200);
        if (
            $(this)
            .parent()
            .hasClass("active")
        ) {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .parent()
                .removeClass("active");
        } else {
            $(".sidebar-dropdown").removeClass("active");
            $(this)
                .next(".sidebar-submenu")
                .slideDown(200);
            $(this)
                .parent()
                .addClass("active");
        }
    });

    $(".inner-dropdown > a").click(function() {
        $(".inner-submenu").slideUp(200);
        if (
            $(this)
            .parent()
            .hasClass("active")
        ) {
            $(".inner-dropdown").removeClass("active");
            $(this)
                .parent()
                .removeClass("active");
        } else {
            $(".inner-dropdown").removeClass("active");
            $(this)
                .next(".inner-submenu")
                .slideDown(200);
            $(this)
                .parent()
                .addClass("active");
        }
    });

    $("#close-sidebar").click(function() {
        $(".page-wrapper").removeClass("toggled");
    });
    $("#show-sidebar").click(function() {
        $(".page-wrapper").addClass("toggled");
    });

});


$("document").ready(function() {
    $(".tab-slider--body").hide();
    $(".tab-slider--body:first").show();
});

$(".tab-slider--nav li").click(function() {
    $(".tab-slider--body").hide();
    var activeTab = $(this).attr("rel");
    $("#" + activeTab).fadeIn();
    if ($(this).attr("rel") == "tab2") {
        $('.tab-slider--tabs').addClass('slide');
    } else {
        $('.tab-slider--tabs').removeClass('slide');
    }
    if ($(this).attr("rel") == "tab3") {
        $('.tab-slider--tabs').addClass('slide');
    } else {
        $('.tab-slider--tabs').removeClass('slide');
    }
    $(".tab-slider--nav li").removeClass("active");
    $(this).addClass("active");
});

function existingTag(text) {
    var existing = false,
        text = text.toLowerCase();

    $(".tags").each(function() {
        if ($(this).text().toLowerCase() == text) {
            existing = true;
            return "";
        }
    });

    return existing;
}

$(function() {
    $(".tags-new input").focus();

    $(".tags-new input").keyup(function() {

        var tag = $(this).val().trim(),
            length = tag.length;

        if ((tag.charAt(length - 1) == ',') && (tag != ",")) {
            tag = tag.substring(0, length - 1);

            if (!existingTag(tag)) {
                $('<li class="tags"><span>' + tag + '</span><i class="fa fa-times"></i></i></li>').insertBefore($(".tags-new"));
                $(this).val("");
            } else {
                $(this).val(tag);
            }
        }
    });

    $(document).on("click", ".tags i", function() {
        $(this).parent("li").remove();
    });

});

/*============= All forms ========== */
$("document").ready(function() {
    $(".tab-slider--body").hide();
    $(".tab-slider--body:first").show();
});

$(".tab-slider--navform li").click(function() {
    $(".tab-slider--body").hide();
    var activeTab = $(this).attr("rel");
    $("#" + activeTab).fadeIn();
    if ($(this).attr("rel") == "tab2") {
        $('.tab-slider--tabsform').addClass('slide');
    } else {
        $('.tab-slider--tabsform').removeClass('slide');
    }
    if ($(this).attr("rel") == "tab3") {
        $('.tab-slider--tabsform').addClass('slide');
    } else {
        $('.tab-slider--tabsform').removeClass('slide');
    }
    $(".tab-slider--navform li").removeClass("active");
    $(this).addClass("active");
});