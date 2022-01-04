(function ($) {

    $(document).ready(function () {

        $("#game_home_team").selectize({
            create: true,
            sortField: "text",
        });

        $("#game_guest_team").selectize({
            create: true,
            sortField: "text",
        });

        $("#game_arena").selectize({
            create: true,
            sortField: "text",
        });

        $("#game_sponsor").selectize({
            create: true,
            sortField: "text",
        });
    });

})(jQuery);


