<?php
class AuthController {
    private $model;
    /**function ini adalah constructor untuk menginisialisasi
         * objek aslab model
         */
    public function __construct(){
        $this->model = new AuthModel;
    } 
     /**mengatur tampiilan awal */
     public function index(){
        require_once("View/auth/index.php");
    }

    /**mengatur halaman login untuk aslab */
    public function login_aslab(){
        require_once("View/auth/login_aslab.php");
    }

    /**mengatur halaman login untuk praktikan */
    public function login_praktikan(){
        require_once("View/auth/login_praktikan.php");
    }

            /**function login untuk authentikasi aslab */
            public function authAslab(){
                $npm = $_POST['npm'];
                $password = $_POST['password'];
                $data = $this->model->prosesAuthAslab($npm,$password);
                if ($data) {
                    $_SESSION['role'] = 'aslab';
                    $_SESSION['aslab'] = $data;
    
                    header("location:index.php?page=aslab&aksi=view&pesan=berhasilLogin");
                }else {
                        header("location:index.php?page=aslab&aksi=loginAslab&pesan=password atau npm salah");
                    }
            }

            /**function login untuk authentikasi praktikan */        
            public function authPraktikan(){
                $npm = $_POST['npm'];
                $password = $_POST['password'];
                $data = $this->model->prosesAuthPraktikan($npm,$password);
                
                if ($data) {
                    $_SESSION['role'] = 'praktikan';
                    $_SESSION['praktikan'] = $data;
    
                    header("location:index.php?page=praktikan&aksi=view&pesan=berhasilLogin");
                }else {
                        header("location:index.php?page=auth&aksi=loginPraktikan&pesan=password atau npm salah");
                    }
            }
            /**mengatur halaman daftar praktikan */
        public function daftar_praktikan(){
            require_once("View/auth/daftar_praktikan.php");
        }

        /**
         * function ini digunakan untuk menambah data praktikan
         * fungsi ini mengambil data dari POST nama, 
         * npm,no hp, dan password
         */
        public function storePraktikan(){
            $nama = $_POST['nama'];
            $npm = $_POST['npm'];
            $no_hp = $_POST['no_hp'];
            $password = $_POST['password'];
            if ($this->model->prosesStorePraktikan($nama,$npm,$no_hp,$password)) {
                header("location: index.php?page=auth&aksi=view&pesan= Berhasil Daftar");
            }else {
                header("location: index.php?page=auth&aksi=daftarPraktikan&pesan=gagal Daftar");
            }
        }

         
        /**
         * mengatur halaman logout
         */
        public function logout(){
            session_destroy();
            header("location:index.php?page=auth&aksi=view&pesan=berhasilLogout");
        }

}
