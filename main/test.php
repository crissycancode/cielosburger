<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.js"></script>
<script src="https://rawgit.com/Eonasdan/bootstrap-datetimepicker/development/src/js/bootstrap-datetimepicker.js"></script>
<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/v4.0.0/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<html>
<head>

</head>
<body>

<select name="report_name" class="form-control" required>
    <option value="Sales">Sales</option>
    <option value="Commissions">Commissions</option>
</select>
<select name="report_type"
        onchange="if (this.value) window.location.href=this.value"
        class="form-control" required>
    <option value="">-=Select=-</option>
    <option value="generate-report.php?name=<?= $_GET['name']; ?>&type=Daily" <?php if (isset($_GET['type'])) {
        if ($_GET['type'] == 'Daily') {
            echo "selected";
        }
    } ?> >Daily
    </option>
    <option value="generate-report.php?name=<?= $_GET['name']; ?>&type=Weekly" <?php if (isset($_GET['type'])) {
        if ($_GET['type'] == 'Weekly') {
            echo "selected";
        }
    } ?>>Weekly
    </option>
    <option value="generate-report.php?name=<?= $_GET['name']; ?>&type=Monthly" <?php if (isset($_GET['type'])) {
        if ($_GET['type'] == 'Monthly') {
            echo "selected";
        }
    } ?>>Monthly
    </option>

</select>

                    <div class="col-sm-5">
                        <div class="input-group date" id="startdate">
                            <input type="text" class="form-control" />
                            <span class="input-group-addon">
                                    <span class="glyphicon-calendar glyphicon"></span>
                                </span>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group date" id="enddate">
                            <input type="text" class="form-control" />
                            <span class="input-group-addon">
                                    <span class="glyphicon-calendar glyphicon"></span>
                                </span>
                        </div>
                    </div>

    <script>


        </body>
        </html>

        $(function () {

            $('#startdate,#enddate').datetimepicker({
                useCurrent: false,
                format: 'MM-DD-YYYY'
            });


        });


    </script>