<?php
function TampilBulan($date){
  $bulan = substr($date, 5);
  $tahun = substr($date, 0, 4);
  if ($bulan == '01') {
    $hasil = "Januari $tahun";
  }
  if ($bulan == '02') {
    $hasil = "Februari $tahun";
  }
  if ($bulan == '03') {
    $hasil = "Maret $tahun";
  }
  if ($bulan == '04') {
    $hasil = "April $tahun";
  }
  if ($bulan == '05') {
    $hasil = "Mei $tahun";
  }
  if ($bulan == '06') {
    $hasil = "Juni $tahun";
  }
  if ($bulan == '07') {
    $hasil = "Juli $tahun";
  }
  if ($bulan == '08') {
    $hasil = "Agustus $tahun";
  }
  if ($bulan == '09') {
    $hasil = "September $tahun";
  }
  if ($bulan == '10') {
    $hasil = "Oktober $tahun";
  }
  if ($bulan == '11') {
    $hasil = "Novemer $tahun";
  }
  if ($bulan == '12') {
    $hasil = "Desember $tahun";
  }
  return $hasil;
}
//form input
function Input($label, $id, $value='', $type='text'){
  print "<div class='form-group'>
          <label>$label</label>
          <input type='$type' id='$id' name='$id' value='$value' class='form-control'>
          </div>
        ";
}
//form select
function Select($label, $id, $tabel, $value, $tampil){
  include 'sys/db.php';
  print "<div class='form-group'>
          <label>$label</label>
            <select class='form-control select-tunggal' id='$id' name='$id'>
              <option value='' hidden disabled>$label</option>
        ";
        $query = $koneksi->query("SELECT * FROM $tabel");
        while($data = $query->fetch()){
          print "<option value='".$data->$value."'>".$data->$tampil."</option>";
        }
        print "</select>
              </div>
              <script type='text/javascript'>
                  var singlePresetOpts = new Choices('.select-tunggal', {
                      placeholder: true,
                  });
              </script>
              ";
}
//tabel
function Tabel($query, $td, $th, $kondisi, $menus=null, $act=null){ ?>
  <table class="table table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <?php 
          foreach ($th as $key => $th) { ?>
            <th><?php print $th; ?></th>
         <?php  } ?>
        </tr>
        </thead>
        <tbody>
  <?php
  include 'sys/db.php';
  $count = str_replace("*", "count(*)", $query);
  $query = $koneksi->query($query);
  while ($data = $query->fetch(PDO::FETCH_BOTH)) {
    $isi = count($td);
    ?>

      <tr id="pilih<?php print $data[0]; ?>">
        <script type="text/javascript">
            $(document).ready(function () {
                $("#pilih<?php print $data[0]; ?>").dblclick(function(){
                    $('#Info<?php print $data[0]; ?>').click();
                });
                $("#pilih<?php print $data[0]; ?>").contextMenu({
                menuSelector: "#pilihan<?php print $data[0]; ?>",
                menuSelected: function (invokedOn, selectedMenu) {}
            });
            });
        </script>
        <?php for ($i=0; $i<$isi; $i++) {  $val = $td[$i]; ?>
          <td><?php print $data[$val]; ?></td>
        <?php } ?>
      </tr>
        <div class="dropdown-menu dropdown-menu2" id="pilihan<?php print $data[0]; ?>">
          <a class="dropdown-item dropdown-item2" href="#" data-toggle="modal" onclick="modal(encodeURI('modul?modul=edit<?php print $kondisi; ?>&id=<?php echo $data[0]; ?>'));" data-target="#modal"><i class="fas fa-edit"></i> Edit</a>
          <a class="dropdown-item dropdown-item2" href="#" data-toggle="modal" onclick="modal(encodeURI('modul?modul=info<?php print $kondisi; ?>&id=<?php echo $data[0]; ?>'), 'modal-lg');" id="Info<?php echo $data[0]; ?>" data-target="#modal"><i class="fas fa-info"></i> Info</a>
          <a class="dropdown-item dropdown-item2" href="#" data-toggle="modal" onclick="modal(encodeURI('modul?modul=Hapus&halaman=<?php print strtolower($kondisi); ?>&tabel[]=<?php print strtolower($kondisi); ?>&where[]=id_<?php print strtolower($kondisi); ?>=<?php echo $data[0]; ?>'));" data-target="#modal"><i class="fas fa-trash"></i> Hapus</a>
          <?php
            if($menus != null){
            foreach ($menus as $key => $menu) { ?>
            <a class="dropdown-item dropdown-item2" href="#" data-toggle="modal" data-target="#modal" onclick="modal(encodeURI('<?php print $act[$key].$data[0]; ?>'));"><i class="fas fa-edit"></i> <?php print $menu; ?></a>  
          <?php  } } ?>
        </div>
  <?php } ?>
      <tr>
        <td colspan='<?php print $isi-1; ?>'>Total</td>
        <td><?php print $jml = $koneksi->query($count)->fetchColumn(); ?> Data</td>
      </tr>
    </tbody>
  </table><!-- 
  <ul class="pagination">
      <?php for ($i=1; $i<=$jml ; $i++){ ?>
          <li class="page-item"><button class="page-link" onclick="pagination('pelanggan', <?php echo $i; ?>)"><?php echo $i; ?></button></li>
      <?php } ?>
  </ul> -->
<?php } 

//menampilkan limit
function tampilLimit($tabel, $halaman){
  error_reporting(0);
  include 'sys/db.php';
  $query = $koneksi->query("SELECT count(*) FROM `$tabel`")->fetchColumn();
  $a = round($query/2);?>
  <a class="dropdown-item" onclick="limit('<?php print $tabel; ?>', '<?php print $halaman; ?>', '<?php echo $query; ?>')"><?php echo $query; ?> Data</a>
  <a class="dropdown-item" onclick="limit('<?php print $tabel; ?>', '<?php print $halaman; ?>', '<?php echo $a; ?>')"><?php echo $a; ?> Data</a>
  <?php if($a >1){ $b = round($a/2); ?>
  <a class="dropdown-item" onclick="limit('<?php print $tabel; ?>', '<?php print $halaman; ?>', '<?php echo $b; ?>')"><?php echo $b; ?> Data</a>
  <?php } if($b >1){ $c = round($b/2); ?>
  <a class="dropdown-item" onclick="limit('<?php print $tabel; ?>', '<?php print $halaman; ?>', '<?php echo $c; ?>')"><?php echo $c; ?> Data</a>
  <?php } if($c >1){ $d = round($c/2); ?>
  <a class="dropdown-item" onclick="limit('<?php print $tabel; ?>', '<?php print $halaman; ?>', '<?php echo $d; ?>')"><?php echo $d; ?> Data</a>
  <?php } if($d >1){ $e = round($d/2); ?>
  <a class="dropdown-item" onclick="limit('<?php print $tabel; ?>', '<?php print $halaman; ?>', '<?php echo $e; ?>')"><?php echo $e; ?> Data</a>
  <?php }
}
//fungsi untuk cek inputan
function cekData($data){
  require "sys/db.php";
  $data = trim($data);
    //$data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $koneksi->quote($data);
    return $data;
}
//fungsi untuk tampilkan jumlah data
function JmlData(string $query){
    require "sys/db.php";
    $jmlRow = $koneksi->query("$query")->fetchColumn(); 
    return $jmlRow;
    $koneksi = null;
}
//fungsi untuk menampilkan data
function Data(string $query){
    require "sys/db.php";
    $query = $koneksi->query("$query"); 
    $data = $query->fetch(PDO::FETCH_OBJ);
    return $data;
    $koneksi = null;
}
//fungsi untuk menampilkan data
function DataAll(string $query){
    require "sys/db.php";
    $query = $koneksi->query("$query"); 
    return $query;
    $koneksi = null;
}
//fungsi untuk tampilkan jumlah data
function tampilJmlData(string $tabel, $where = 1){
    require "sys/db.php";
    $jmlRow = $koneksi->query("SELECT count(*) FROM $tabel WHERE $where")->fetchColumn(); 
    return $jmlRow;
    $koneksi = null;
}
//fungsi untuk menampilkan data
function tampilData(string $tabel, $where = 1){
    require "sys/db.php";
    $query = $koneksi->query("SELECT * FROM $tabel WHERE $where"); 
    $data = $query->fetch(PDO::FETCH_OBJ);
    return $data;
    $koneksi = null;
}
//fungsi untuk menampilkan data
function tampilDataAll(string $tabel, $where = 1, $urut = 1, $batas = 1000000){
    require "sys/db.php";
    $query = $koneksi->query("SELECT * FROM $tabel WHERE $where ORDER BY $urut LIMIT $batas"); 
    return $query;
    $koneksi = null;
}
//fungsi untuk merubah tanggal ke indonesia
function TanggalIndo($date){
  $BulanIndo = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agust", "Sept", "Okt", "Nov", "Des");
 
  $tahun = substr($date, 0, 4);
  $bulan = substr($date, 5, 2);
  $tgl   = substr($date, 8, 2);
 
  $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;   
  return($result);
}
//fungsi untuk merubah nilai ke huruf
function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
      $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
      $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
      $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
      $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
      $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
      $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
      $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
      $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
      $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
      $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
  }
 
  function terbilang($nilai) {
    if($nilai<0) {
      $hasil = "minus ". trim(penyebut($nilai));
    } else {
      $hasil = trim(penyebut($nilai));
    }         
    return $hasil;
  }

//insert log
function kegiatan($kegiatan, $keterangan, $notifikasi = 'null'){
  include "db.php";
  $id_user = $_COOKIE['id_user'];
  $sekarang = date('Y-m-d H:i:s');
  $log = $koneksi->query('INSERT INTO log(waktu_log, id_user, kegiatan, keterangan_log) VALUES ("'.$sekarang.'","'.$id_user.'","'.htmlspecialchars($kegiatan).'", "'.htmlspecialchars($keterangan).'")');
  if($notifikasi != 'null'){
    $noti = $koneksi->query('INSERT INTO notifikasi(id_user, notifikasi, link, tanggal_notifikasi) VALUES ("'.$_COOKIE["id_user"].'","'.htmlspecialchars($keterangan).'","'.htmlspecialchars($notifikasi).'","'.date("Y-m-d").'")');
  }
  return $log;
}
//fungsi untuk kirim notifikasi
function pesan($device, $pesan, $dari){
    
    $registrationIds = $device;
    #prep the bundle
     $msg = array (
              'body'  => $pesan,
              'title' => $dari
          );

      $fields = array
          (
            'to'    => $registrationIds,
            'notification'  => $msg
          );
  
  
      $headers = array
      (
        'Authorization: key= AAAAUya0OJw:APA91bGTzUJ2JUfIFXILXUAkrSgS52NiAnjlkkLI0iZi759_KdUkByFZbUx635AevSBVSbstIn0_sK128bpWK0bGvbaGN6xhcYNYfTtHiAUJur0KId0HgKigGflg9pq1DTF5sb--5Xij',
        'Content-Type: application/json'
        );

    #Send Reponse To FireBase Server  
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ));
    $result = curl_exec($ch);
    curl_close( $ch );
    #Echo Result Of FireBase Server
    //echo $result;
    }
    function IPnya() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'IP Tidak Dikenali';
      // print "IP : ".$ipaddress." Browser : ".$_SERVER['HTTP_USER_AGENT']." Sistem Operasi :".php_uname();
      return $ipaddress;
    }
    $ipaddress = $_SERVER['REMOTE_ADDR'];
?>