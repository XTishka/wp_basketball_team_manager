<?php
function staff_member_data_form(  ) { ?>

    <h1>Staff member</h1>

    <script>
        jQuery('#game_date').datetimepicker(
            {
                timepicker: false,
                format: 'Y-m-d'
            }
        );

        jQuery('#game_time').datetimepicker({
            datepicker: false,
            format: 'H:i'
        });
    </script>

	<?php
}
