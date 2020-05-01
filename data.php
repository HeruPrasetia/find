<?php
date_default_timezone_set("Asia/Bangkok");
session_start();
if($_COOKIE['fm_login']==1 && ISSET($_COOKIE['usernameFm'])){
$user = $_COOKIE['usernameFm'];
$sekarang = date('Y-m-d');
if(ISSET($_GET['act'])){
$act = strip_tags($_GET['act']);
switch ($act) { 
  case 'index':
  ?>
  <!-- Dashboard -->
  <script src="assets/js/jquery-form.js"></script>
  <form method='post' action='modul.php?modul=upload' enctype='multipart/form-data'>

    <div class="input-group mb-3">
      <input type="text" id="location" name="lokasi" placeholder="Location" class="form-control" value="/">
      <div class="input-group-append">
        <button class="btn btn-dark" type="button" onclick="cekLocation();">Go</button>
      </div>
    </div>
    <div class="upload-btn-wrapper">
      <button class="btn2">Choose a file</button>
      <input type="file" name="file[]" id="file" multiple/>
    </div>
    <br>
    <button class="btn btn-dark">Upload</button>
    <button type="button" class="btn btn-dark" data-toggle="modal" onclick="modal(encodeURI('modul?modul=modalBackup'));" data-target="#modal">Backup DB</button>
    <button type="button" class="btn btn-dark" data-toggle="modal" onclick="modal(encodeURI('modul?modul=modalMkdir'));" data-target="#modal">New Folder</button>
    </form>
    
    <div class="progress">
      <div class="progress-bar bg-dark" id="baro" ><div id='percent'></div></div>
    </div>
    <div id='status'></div>
    <div id="viewLocation"></div>
  <script type="text/javascript">
      $(function() {
        $(document).ready(function(){
          var percent = $('#percent');
          var status = $('#status');

          $('form').ajaxForm({
              beforeSend: function() {
              status.empty();
              var percentVal = '0%';
              percent.html(percentVal);
            },
              uploadProgress: function(event, position, total, percentComplete) {
              var percentVal = percentComplete + '%';
              percent.html(percentVal);
              document.getElementById('baro').style.width = percentVal;
            },
              complete: function(xhr) {
              $("#viewLocation").html(xhr.responseText);
              document.getElementById("file").value="";
            }
          });
        });
      });
    function cekLocation(){
      var location = document.getElementById("location").value;
      $("#viewLocation").load("modul.php?modul=ViewLocation&location="+location);
    }
    $("#viewLocation").load("modul.php?modul=ViewLocation&location=/server/root/filemanager/");
    document.getElementById("loading").style.display="none";
  </script>
  <?php break; ?>
    
  <?php default: ?>
    <?php echo "tidak ada perintah $act"; ?>
    <script type="text/javascript">
      document.getElementById("loading").style.display = "none";
    </script>
    <?php 
    break;
  }

}
}else{
    header('location:sys/index.php');
}
?>