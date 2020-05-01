<?php
date_default_timezone_set("Asia/Bangkok");
session_start();
if($_COOKIE['fm_login']==1){
$user = $_COOKIE['usernameFm'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>File Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="assets/images/pxamultiunit_Icon.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="PXA">
    <link rel="apple-touch-icon-precomposed" href="assets/images/pxamultiunit_Icon.png">
    <meta name="msapplication-TileImage" content="assets/images/pxamultiunit_Icon.png">
    <meta name="msapplication-TileColor" content="#3372DF">
    <link rel="shortcut icon" href="assets/images/pxamultiunit_Icon.png">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/naylatools.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/naylatools.js"></script>
    <style type="text/css">
        body::-webkit-scrollbar {
            display: none;
        } 
        body {
            font-family: "Tahoma, Geneva, sans-serif";
            -ms-overflow-style: none;
        }
        h5{
            font-family: "Tahoma, Geneva, sans-serif";
        }
        .upload-btn-wrapper {
          position: relative;
          overflow: hidden;
          display: inline-block;
        }

        .btn2 {
          border: 2px solid gray;
          color: gray;
          background-color: white;
          padding: 8px 20px;
          border-radius: 8px;
          font-size: 20px;
          font-weight: bold;
        }

        .upload-btn-wrapper input[type=file] {
          font-size: 100px;
          position: absolute;
          left: 0;
          top: 0;
          opacity: 0;
        }
    </style>
</head>

<body>
    <div class="se-pre-con" id="loading"></div>
    <div class="wrapper">
         <nav id="sidebar">
            <div class="sidebar-header">
                <h1> <a href="index">File Manager</a> </h1>
                <span>F</span>
            </div>
            <ul class="list-unstyled components">
                <li onclick="pilihMenu('index', 'Dashboard', false);" id="menuindex">
                    <a>Root</a>
                </li>
            </ul>
            <?php
            $d = dir("/");
            while (($file = $d->read()) !== false){ 
            $type = filetype($d->path.$file);
            if($type=="dir"){
            ?>
            <ul class="list-unstyled components">
                <li onclick="$('#viewLocation').load(encodeURI('modul.php?modul=ViewLocation&location=/<?php print $file; ?>/')); document.getElementById('location').value = '/<?php print $file; ?>/';">
                    <a><?php print $file; ?></a>
                </li>
            </ul>
           <?php } } ?>
        </nav>
        <script>
            $(document).ready(function () {
                <?php 
                if (ISSET($_GET['halaman'])) { 
                $halaman = htmlspecialchars($_GET['halaman']);
                ?>
                $('#tampil').load("data?act=<?php print $halaman; ?>");
                $('#menu<?php print $halaman; ?>').addClass("active");
                <?php }else{ ?>
                $('#tampil').load("data?act=index");
                $('#menuindex').addClass("active");
                <?php } ?>
            });
        </script>
        <div id="content">
            <nav class="navbar navbar-default mb-xl-5 mb-4">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <ul class="top-icons-agileits-w3layouts float-left">
                        <li class="nav-item dropdown">
                            <button type="button" id="sidebarCollapse" class="btn btn-info navbar-btn">
                            <i class="fas fa-bars"></i>
                        </button>
                        </li>
                        <li class="nav-item dropdown mx-3">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fas fa-spinner"></i>
                                <div id="peringatan1"></div>
                            </a>
                            <div class="dropdown-menu top-grid-scroll drop-2">
                                <h3 class="sub-title-w3-agileits">Activity</h3>
                                <span id="peringatan"></span>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="far fa-user"></i>
                            </a>
                            <div class="dropdown-menu drop-3">
                                <div class="profile d-flex mr-o">
                                    <div class="profile-r align-self-center">
                                        <h3 class="sub-title-w3-agileits"><?php print $_COOKIE['nameFm']; ?></h3>
                                    </div>
                                </div>
                                <a onclick="pilihMenu('setting', 'Setting Page', false);" id="menusetting" class="dropdown-item mt-3">
                                    <h4><i class="fas fa-link mr-3"></i>Setting</h4>
                                </a>
                                <a onclick="pilihMenu('support', 'Support Page', false);" id="menusupport" class="dropdown-item mt-3">
                                    <h4><i class="far fa-thumbs-up mr-3"></i>Support</h4>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="sys/logout.php">Logout</a>
                            </div>
                        </li>
                        <li>
                            <?php print $_COOKIE['nameFm']; ?>
                        </li>
                    </ul>
                    </div>
                </div>
            </nav>
            <section class="tables-section">
                <div class="outer-w3-agile mt-3">
                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" id="jenisModal" role="document">
                        <div class="modal-content">
                            <div id="tampilModal">
                                <button class="btn" disabled>
                                    <div class="spinner-grow text-primary spinner-grow-xl"></div>
                                    Loading..
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="table-responsive-xl" id="tampil">
                        
                    </div>
                </div>
            </section>
            <div class="copyright-w3layouts py-xl-3 py-2 mt-xl-5 mt-4 text-center">
                <p> File Manager </p>
            </div>
        </div>
    </div>
    <div id="snackbar"></div>
    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
        function pesan(pesan, delay) {
            if (pesan != ''){   
                document.getElementById("snackbar").innerHTML=pesan;    
            }
            var x = document.getElementById("snackbar");
            x.className = "show"; 
            setTimeout(function(){ 
                x.className = x.className.replace("show", ""); 
            }, delay); 
        }
    </script>
</body>
</html>
<?php
}else{
    header('location:sys/index.php');
}
?>