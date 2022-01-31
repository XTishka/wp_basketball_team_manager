(function ($) {

    $(document).ready(function () {

        $("#taxonomy_game_home_team").selectize({
            create: true,
            sortField: "text",
        });

        $("#taxonomy_game_guest_team").selectize({
            create: true,
            sortField: "text",
        });

        $("#taxonomy_game_arena").selectize({
            create: true,
            sortField: "text",
        });

        // $("#taxonomy_game_sponsor").selectize({
        //     create: true,
        //     sortField: "text",
        // });

        $("#sponsors_category").selectize({
            create: true,
            sortField: "text",
            maxOptions: 3
        });

        $("#sponsors_category").selectize({
            create: true,
            sortField: "text",
            maxOptions: 3
        });

        $("#player_position").selectize({
            create: true,
            sortField: "text",
            delimiter: '/'
        });

        $("#video_category").selectize({
            create: true,
            sortField: "text",
            delimiter: '/',
            placeholder: 'No category selected'
        });

        $("#taxonomy_subcategory").selectize({
            create: true,
            sortField: "text",
            delimiter: '/',
            placeholder: 'No category selected'
        });
    });

})(jQuery);


