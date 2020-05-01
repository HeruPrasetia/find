<?php
date_default_timezone_set("Asia/Bangkok");
session_start();
if($_COOKIE['fm_login']==1 && ISSET($_COOKIE['usernameFm'])){
$user = $_COOKIE['usernameFm'];
if(ISSET($_GET['modul'])){
$hari = date('Y-m-d');
$modul = htmlspecialchars($_GET['modul']);
switch ($modul) {
  case 'cari':
  $cari = $_GET['cari'];
  ?>
      <input type="hidden" id="actcari" value="<?php print $cari; ?>">
        <input class="form-control mr-sm-2 effect-5" type="text" placeholder="Search. . ." id="q" aria-label="Search" required="" onkeyup="cari(this.value)">
        <button class="btn btn-style my-2 my-sm-0" type="submit" id="cari">Seacrh</button>
    <?php break; ?>










    <?php case 'ViewLocation': ?>
        <input type="seacrh" name="q" class="form-control" id="myInput" placeholder="Search . . .">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Name</th>
              <th>Type</th>
              <th>Size</th>
              <th>Last Update</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody id="myTable">
        <?php
        $path = $_GET['location'];
        $d = dir($path);
        while (($file = $d->read()) !== false){ 
        $type = filetype($d->path.$file);
        ?>
        <?php if ($type == "dir"){ ?>
          <tr draggable="true" ondblclick="$('#viewLocation').load(encodeURI('modul.php?modul=ViewLocation&location=<?php print $d->path.$file; ?>/')); document.getElementById('location').value = '<?php print $d->path.$file; ?>/';">
        <?php }else{ ?>
          <tr draggable="true" ondblclick="document.getElementById('downloadfile<?php print $d->path.$file; ?>').click();">
        <?php } ?>
              <td><?php if ($type == "dir"){ ?><a onclick="$('#viewLocation').load(encodeURI('modul.php?modul=ViewLocation&location=<?php print $d->path.$file; ?>/')); document.getElementById('location').value = '<?php print $d->path.$file; ?>/';"><i class="fas fa-folder"></i> <?php print $file; ?></a><?php }else{ ?><i class="fas fa-file-alt"></i> <?php print $file; ?><?php } ?></td>
              <td><?php print filetype($d->path.$file); ?></td>
              <td><?php if ($type == "file"){ ?><?php print filesize($d->path.$file); ?><?php }else{?> - <?php } ?></td>
              <td><?php print date("F d Y H:i:s.", filemtime($d->path.$file)); ?></td>
              <td>
                <?php if ($type == "file"){ ?>
                  <a href="download.php?file=<?php print $d->path.$file; ?>" target="_blank" id="downloadfile<?php print $d->path.$file; ?>"><i class="fas fa-save"></i></a>
                  <i class="fas fa-trash" onclick="hapus('modul.php?modul=hapus&file=<?php print $d->path.$file; ?>');" style="cursor: pointer;"></i>
                <?php } ?>
              </td>
          </tr>
        <?php }
        $d->close();
        ?>
          </tbody>
        </table>
        <script type="text/javascript">
          function hapus(path) {
              var r = confirm("Are you sure to delete this File !!");
              if (r == true) {
                $('#viewLocation').load(encodeURI(path));
              }
          }
          $(document).ready(function(){
            $("#myInput").on("keyup", function() {
              var value = $(this).val().toLowerCase();
              $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
              });
            });
          });
        </script>
    <?php break; ?>










    <?php case 'upload' : ?>
        <?php
        $path = $_POST['lokasi']; 
        if(ISSET($_FILES['file'])){
            $file = $_FILES['file']['tmp_name'];
            $name = $_FILES['file']['name'];
            foreach ($file as $key => $value) {
                move_uploaded_file($value,$path.$name[$key]);
            }
        }
        ?>
        <input type="seacrh" name="q" class="form-control" id="myInput" placeholder="Search . . .">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Name</th>
              <th>Type</th>
              <th>Size</th>
              <th>Last Update</th>
              <th>Option</th>
            </tr>
          </thead>
          <tbody id="myTable">
        <?php
        $d = dir($path);
        while (($file = $d->read()) !== false){ 
        $type = filetype($d->path.$file);
        ?>
          <?php if ($type == "dir"){ ?>
          <tr draggable="true" ondblclick="$('#viewLocation').load(encodeURI('modul.php?modul=ViewLocation&location=<?php print $d->path.$file; ?>/')); document.getElementById('location').value = '<?php print $d->path.$file; ?>/';">
          <?php }else{ ?>
          <tr draggable="true" ondblclick="document.getElementById('downloadfile<?php print $d->path.$file; ?>').click();">
          <?php } ?>
              <td><?php if ($type == "dir"){ ?>
                <a onclick="$('#viewLocation').load(encodeURI('modul.php?modul=ViewLocation&location=<?php print $d->path.$file; ?>/')); document.getElementById('location').value = '<?php print $d->path.$file; ?>/';">
                  <i class="fas fa-folder"></i> <?php print $file; ?>
                </a><?php }else{ ?>
                  <i class="fas fa-file-alt"></i> <?php print $file; ?><?php } ?>
              </td>
              <td><?php print filetype($d->path.$file); ?></td>
              <td><?php if ($type == "file"){ ?><?php print filesize($d->path.$file); ?><?php }else{?> - <?php } ?></td>
              <td><?php print date("F d Y H:i:s.", filemtime($d->path.$file)); ?></td>
              <td>
                <?php if ($type == "file"){ ?>
                  <a href="download.php?file=<?php print $d->path.$file; ?>" target="_blank" id="downloadfile<?php print $d->path.$file; ?>"><i class="fas fa-save"></i></a>
                  <i class="fas fa-trash" onclick="hapus('modul.php?modul=hapus&file=<?php print $d->path.$file; ?>');" style="cursor: pointer;"></i>
                <?php } ?>
              </td>
          </tr>
        <?php }
        $d->close();
        ?>
          </tbody>
        </table>
        <script type="text/javascript">
          function hapus(path) {
              var r = confirm("Are you sure to delete this File !!");
              if (r == true) {
                $('#viewLocation').load(encodeURI(path));
              }
          }
          $(document).ready(function(){
            $("#myInput").on("keyup", function() {
              var value = $(this).val().toLowerCase();
              $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
              });
            });
          });
        </script>
    <?php break; ?>











    <?php case 'modalBackup' : ?>
    <form method="post" action="sys/crud.php" target="_blank">
        <input type="hidden" name="act" value="backup">
        <div class="modal-header">
            <h5 class="modal-title">Backup Database</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Host</label>
                <input type="text" class="form-control" name="host" id="host" placeholder="Field With Host" required="" value="localhost">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="user" id="user" placeholder="Field With USer Account" required="" value="root">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Field With Password" required="">
            </div>
            <button type="button" class="btn btn-dark" onclick="listDB();" id="btnChoose"><span id="loadDatabase"></span>Choose DataBase</button>
            <div class="form-group" id="listDb">
                <label>Database</label>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="tutupModal" data-dismiss="modal">Cancel</button>
            <button id="simpan" class="btn btn-dark"><span id="loadForm"></span>Save</button>
        </div>
    </form>
    <script type="text/javascript">
      function listDB() {
        var host      = document.getElementById("host").value;
        var user     = document.getElementById("user").value;
        var password = document.getElementById("password").value;
        $('#btnChoose').prop("disabled", true);
        $('#loadDatabase').addClass('spinner-border spinner-border-sm');
        $('#listDb').load(encodeURI('modul.php?modul=listDb&host='+host+'&user='+user+'&password='+password+''));
      }
    </script>
    <?php break; ?> 
      










    <?php case 'listDb' : ?>
      <span>Database</span>
      <select class="form-control" name="db">
      <?php
        $server   = $_GET['host'];
        $username = $_GET['user'];
        $password = $_GET['password'];
        try {
           $koneksi = new PDO("mysql:host=$server;", $username, $password);
           $koneksi->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
           $koneksi->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 
           $koneksi->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); 
           }
        catch (PDOException $e) {
           print "Koneksi atau query bermasalah: " . $e->getMessage() . "<br/>";
           die();
        }
        $result = $koneksi->query("SHOW DATABASES");
        while ($row = $result->fetch(PDO::FETCH_NUM)) { ?>
          <option value="<?php echo $row[0];?>"><?php echo $row[0];?></option>
        <?php } ?>
        </select>
        <script type="text/javascript">
          $('#btnChoose').prop("disabled", false);
          $('#loadDatabase').removeClass('spinner-border spinner-border-sm');
        </script>
    <?php break; ?>











    <?php case 'hapus': ?>
      <?php
      $file = $_GET['file'];
      unlink($file);
      ?>
      <script type="text/javascript">
        var lokasi = document.getElementById('location').value;
        $('#viewLocation').load(encodeURI('modul.php?modul=ViewLocation&location='+lokasi));
      </script>
    <?php break; ?>











    <?php case 'modalMkdir' : ?>
    <form method="post" action="sys/crud.php" target="_blank">
        <input type="hidden" name="act" value="backup">
        <div class="modal-header">
            <h5 class="modal-title">New Folder</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Folder Name</label>
                <input type="text" class="form-control" name="dir" id="dir" placeholder="Field With New Folder Name" required="">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="tutupModal" data-dismiss="modal">Cancel</button>
            <button id="simpan" class="btn btn-dark"><span id="loadForm"></span>Save</button>
        </div>
    </form>
    <script type="text/javascript">
      $("#simpan").on("click", function(){
        var lokasi = document.getElementById('location').value;
        var newdir = document.getElementById('dir').value;
        var mkdir  = lokasi+newdir+'/';
          var valid = this.form.checkValidity();
          if (valid) {
              event.preventDefault();
              $('#simpan').prop("disabled", true);
              $('#loadForm').addClass('spinner-border spinner-border-sm');
              var data = new FormData();
              data.append('modul', 'mkdir');
              data.append('dir', mkdir);
              $.ajax({ 
                  url: 'action.php', 
                  type: 'post', 
                  data: data, 
                  contentType: false, 
                  processData: false, 
                  success: function(response){ 
                      if(response == 'Folder created success'){ 
                          $('#viewLocation').load(encodeURI('modul.php?modul=ViewLocation&location='+lokasi));
                          $('#tutupModal').click();
                          pesan(response, 3000);
                      } 
                      else{ 
                          $('#loadForm').removeClass('spinner-border spinner-border-sm');
                          $('#simpan').prop("disabled", false);
                          alert(response);
                      } 
                  }, 
              });
          }
      });
    </script>
    <?php break; ?> 











    <?php case 'mkdir': ?>
      <?php
      $dir = $_GET['dir'];
      if (!mkdir($dir, true))  
        { 
           echo('Folder Failed to create'); 
        } else { 
           echo('Folder created success'); 
        } 
      ?>
    <?php break; ?>











    <?php case 'loading': ?>
        <button class="btn" disabled>
            <div class="spinner-grow text-primary spinner-grow-xl"></div>
            Loading..
        </button>
    <?php break; ?>











  <?php default: ?>
    <button class="btn" disabled>
            <div class="spinner-grow text-primary spinner-grow-lg"></div>
            Tidak ada Menu <?php print $modul; ?>
        </button>
  <?php break;
}
}
}else{
    header('location:sys/index.php');
}
?>