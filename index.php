<?php
$apiKey = '043a56a418d0437f89e54639233105';
$city = (isset($_POST['currentCity'])) ? $_POST['currentCity'] : 'Dubai';
$url = "http://api.weatherapi.com/v1/current.json?key=$apiKey&q=".urlencode($city);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);
if ($response !== false) {
    $data = json_decode($response, true);
    // echo "<pre>";
    // print_r($data);
    if (isset($data['current'])) {
        $weather = $data['current']['condition']['text'];
        $temperature = $data['current']['temp_c'];
        $humidity = $data['current']['humidity']."%";
        $windSpeed = $data['current']['wind_kph']." km/h";
        $temperature_f = $data['current']['temp_f'];
        $weather_icon =  $data['current']['condition']['icon'];
        $location = $data['location']['name'] . ", ".$data['location']['country'] ;
        $pressurein = $data['current']['pressure_in'];
        $windgust = $data['current']['gust_mph'].' MPH';
        $feelslike_c = $data['current']['feelslike_c']."  <span>&#8451;</span>";
        $localtime = $data['location']['localtime'] ;
    } else {
        //echo "Error: Unable to fetch weather data.";
        $weather = $temperature =$humidity = $windSpeed = $temperature_f =   $pressurein = $windgust = $feelslike_c = $localtime = "-" ;
        $location = '<span class="text-danger">Location Not Found using API</span>';
        $weather_icon =  "https://cdn-icons-png.flaticon.com/512/173/173617.png";
    }
} else {
    echo "Error: Unable to connect to the Weather API.";
}
curl_close($curl);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Weather Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-text mx-3">Weather Dashboard<sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

           
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"  action="" method="POST">
                        <div class="input-group">
                            <label><strong>City Name:&nbsp;&nbsp; </strong></label>
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Enter Your City.."
                                aria-label="Search" aria-describedby="basic-addon2" name="currentCity">
                            <div class="input-group-append">
                                <input class="btn btn-primary" type="submit" value="Look for Weather"></input>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                     
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard - <span id="currentLocation"><?php echo $location;?></span></h1>
                        
                    </div>

                    <!-- Content Row -->
                    <div class="row" id="errorBlock">
                    </div>
                    <div class="row" id="weatherblock">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Weather Condition</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="condition"><?php echo $weather ;?></div>
                                        </div>
                                        <div class="col-auto" id="conditionicon">
                                            <img src="<?php echo $weather_icon;?>" style="width:50px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Humidity</div>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="humidity"><?php echo $humidity;?>%</div>
                                                </div>
                                           
                                        </div>
                                        <div class="col-auto" id="humidityicon">
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Wind Speed
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="windspeed"><?php echo $windSpeed;?></div>
                                            </div>
                                        </div>
                                        <div class="col-auto" id="windicon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Current temperature</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="temperature"><?php echo $temperature;?> <span>&#8451;</span> , <?php echo $temperature_f;?> <span>&#8457;</span></div>
                                            
                                        </div>
                                        <div class="col-auto" id="tempicon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Feels Like</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="feelslike"><?php echo $feelslike_c;?></div>
                                        </div>
                                        <div class="col-auto" id="feelsicon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Pressure in inches</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="pressurein"><?php echo $pressurein;?></div>
                                        </div>
                                        <div class="col-auto" id="pressureicon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Wind gust in miles per hour</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="windgust"><?php echo $windgust;?></div>
                                        </div>
                                        <div class="col-auto" id="windgusticon">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Local Time</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="localtime"><?php echo $localtime;?></div>
                                        </div>
                                        <div class="col-auto" id="localtimeicon">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>

                    <!-- Content Row -->


                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Developed by Sudhir Dadwal</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script> 
    <script>
  $( function() { 
                    $('#humidityicon').html("<img src='img/humidity.png'>");
                    $('#windicon').html("<img src='img/wind.png'>");
                    $('#tempicon').html("<img src='img/tempc.png'>");
                    $('#feelsicon').html("<img src='img/feels.png'>");
                    $('#localtimeicon').html("<img src='img/time.png'>");
                    $('#windgusticon').html("<img src='img/windgust.png'>");
                    $('#pressureicon').html("<img src='img/pressure.png'>");
                    
  });
  </script> 
</body>

</html>