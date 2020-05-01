<?php
session_start();
if(!ISSET($_COOKIE['fm_login'])){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Page</title>
    <!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href="../assets/css/fontawesome-all.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
</head>
 
<body>
    <div class="bg-page py-5">
        <div class="container">
            <div class="form-body-w3-agile text-center w-lg-50 w-sm-75 w-100 mx-auto mt-5">
                <form action="cek_login.php" method="post">
                    <input type="hidden" name="act" value="hrd">
                    <input type="hidden" name="token" id="token">
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" name="username" class="form-control" placeholder="Enter Username" required="">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required="">
                    </div>
                    <div class="d-sm-flex justify-content-between">
                        <div class="form-check col-md-6 text-sm-left text-center">
                            
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary error-w3l-btn mt-sm-5 mt-3 px-4">Login</button>
                </form>
            </div>
            <div class="copyright-w3layouts py-xl-3 py-2 mt-xl-5 mt-4 text-center">
                 <p>File Manager</p>
            </div>
        </div>
    </div>
    <script src='../assets/js/jquery-2.2.3.min.js'></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var token = Website2APK.getFirebaseDeviceToken();
            $('#token').val(token);    
         });
    </script>
</body>

</html>
<?php
}else{
    header('location:../');
}
?>