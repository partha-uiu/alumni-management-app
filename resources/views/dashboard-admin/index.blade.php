@extends('layouts.master')

@section('title', 'Dashboard | Admin')

@section('styles')
    <link href="{{asset('lib/owl.carousel/dist/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/owl.carousel/dist/assets/owl.theme.default.min.css')}}" rel="stylesheet">
@endsection

<!-- Main stylesheet and color file-->

@section('content')

    @include('common.nav-section')

    <hr class="color-9 mt-0">
    <section class="font-1 py-4">
        <div class="container">
            @include('common.notifications')
            <h6>Dashboard</h6>
            <div class="row  mb-3">

                <div class="col-lg-12" style="border: 1px solid #ccc">
                    <div class="text-center" id="chart_reg_activity"></div>
                </div>

            </div>
            <div class="row justify-content-left mb-3">

                <div class="col-lg-6 col-12" style="border: 1px solid #ccc">
                    <div id="chart_div_registered"></div>
                </div>

                <div class="col-lg-6 col-12" style="border: 1px solid #ccc">
                    <div id="chart_div_activity"></div>
                </div>
            </div>

            <div class="row text-center">
                <div class="col-12 mb-5 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h6>Alumni</h6>
                        </div>
                        <div class="card-block">
                            <h5 class="text-success"><span class="text-info">     {{' '. $totalAlumni->count()}} </span></h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-5 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h6>Student</h6>
                        </div>
                        <div class="card-block">
                            <h5 class="text-success"><span class="text-info"> {{' '. $totalStudent->count()}} </span></h5>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-5 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h6>Mentors</h6>
                        </div>
                        <div class="card-block">
                            <h5 class="text-success"><span class="text-info">  {{' '. $totalMentors->count()}} </span></h5>

                        </div>
                    </div>
                </div>

                <div class="col-12 mb-5 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h6>Job Posted</h6>
                        </div>
                        <div class="card-block">
                            <h5 class="text-success"><span class="text-info">  {{' '. $totalJobs->count()}} </span></h5>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-5 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h6>Donation Created</h6>
                        </div>
                        <div class="card-block">
                            <h5 class="text-success"><span class="text-info">  {{' '. $totalDonations->count()}} </span></h5>

                        </div>
                    </div>
                </div>
                <div class="col-12 mb-5 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h6>News Published</h6>
                        </div>
                        <div class="card-block">
                            <h5 class="text-success"><span class="text-info">  {{' '. $totalNews->count()}} </span></h5>
                        </div>
                    </div>
                </div>


                <div class="col-12 mb-5 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h6> Events Published</h6>
                        </div>
                        <div class="card-block">
                            <h5 class="text-success"><span class="text-info">  {{' '. $totalEvents->count()}} </span></h5>
                        </div>
                    </div>
                </div>


                <div class="h-200 mt-5"></div>
            </div>

        </div>
        <!--/.container-->
    </section>

@endsection

<!--  -->
<!--    JavaScripts-->
<!--    =============================================-->
@section('scripts')

    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
            crossorigin="anonymous"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

        // Load the Visualization API and the corechart package.
        google.charts.load('current', {'packages': ['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChartRegistered);
        google.charts.setOnLoadCallback(drawChartActivity);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChartRegistered() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
                ['Alumni', <?php echo $totalAlumni->count(); ?>],
                ['Student',<?php echo $totalStudent->count(); ?>],
                ['Faculty-Stuff', <?php echo $totalFacultyStuff->count(); ?>],

            ]);

            // Set chart options
            var options = {
                'title': 'Total Registered',
                'width': 500,
                'height': 300
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div_registered'));
            chart.draw(data, options);
        }

        function drawChartActivity() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
                ['Job', <?php echo $totalJobs->count(); ?>],
                ['Donation',<?php echo $totalDonations->count(); ?>],
                ['Event', <?php echo $totalEvents->count(); ?>],
                ['News', <?php echo $totalNews->count(); ?>],
                ['Polls', <?php echo $totalPolls->count(); ?>],

            ]);

            // Set chart options
            var options = {
                'title': 'Current Activity',
                'width': 500,
                'height': 300
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div_activity'));
            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load("current", {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Month", "Registered Users"],

                <?php  for ($i = 0; $i < count($registerGraphArray); $i++) {
                echo "['" . $registerGraphArray[$i][0] . "', " . $registerGraphArray[$i][1] . "],";
            }
                ?>


            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                {
                    calc: "stringify",
                    sourceColumn: 1,
                    type: "string",
                    role: "annotation"
                },
            ]);


            var options = {
                title: "User Registration Activity",
                width: 800,
                height: 400,
                bar: {groupWidth: "95%"},
                legend: {position: "none"},
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("chart_reg_activity"));
            chart.draw(view, options);
        }
    </script>

@endsection