<?php
    session_start();
    if (!EMPTY($_COOKIE['fm_login'])) {
        header("Location: ../");
    }else{
    $sekarang = date('Y-m-d H:i:s');
  
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        
                if ($_POST['username'] == "root" && $_POST['password'] == "root") {
                    setcookie("usernameFm", "1", time() + (86400 * 30), "/");
                    setcookie("nameFm", "root", time() + (86400 * 30), "/");
                    setcookie("fm_login", '1', time() + (86400 * 30), "/");
                    setcookie("statusFm", '2', time() + (86400 * 30), "/");
                    header("Location: ../");
                } else {
                    echo "<script>
                            window.alert('Maaf Login Gagal, silahkan Coba Lagi');
                            window.location.href='index.php';
                        </script>";
                }
            } else {
                echo "<script>
                        window.alert('Maaf Akun anda belum terdaftar');
                        window.location.href='index.php';
                    </script>";
            }
    
    }
?>