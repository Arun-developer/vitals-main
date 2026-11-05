<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap DatePicker</title>
        <link rel="stylesheet" href="<?php echo base_url() . 'source/portfolio_assets/css/bootstrap.min.css'; ?>">
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/jquery-1.9.1.min.js'; ?>"></script>
        <script src="<?php echo base_url() . 'source/portfolio_assets/js/bootstrap.min.js'; ?>"></script>
        <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
        <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="container">
            <h2>Date  picker</h2>
            <div class="row">
                <div class="col-md-12">
                    <input id="datepicker" width="270" />
                </div>
            </div>
        </div>
        <script>

            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap'
            });

            function datepicker() {
                $('.dateCalendar').datepicker({
                    uiLibrary: 'bootstrap4',
                    format: "dd-mm-yyyy",
                    todayHighlight: true,
                    disableDates: function (date) {
                        const currentDate = new Date();
                        return date > currentDate ? true : false;
                    }
                });
            }
        </script>
    </body>
</html>