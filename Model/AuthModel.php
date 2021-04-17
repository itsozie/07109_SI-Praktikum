<?php
    class AuthModel{

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

        /**mengatur halaman login daftar praktikan */
        public function daftar_praktikan(){
            require_once("View/auth/daftar_praktikan.php");
        }


        public function prosesAuthAslab($npm,$password){
            $sql = "select * from aslab where npm='$npm' and password='$password'";
            $query = koneksi()->query($sql);
            return $query->fetch_assoc();
        }

        /**function login untuk authentikasi aslab */
        public function authAslab(){
            $npm = $_POST['npm'];
            $password = $_POST['password'];
            $data = $this->prosesAuthAslab($npm,$password);
            if ($data) {
                $_SESSION['role'] = 'aslab';
                $_SESSION['aslab'] = $data;

                header("location:index.php?page=aslab&aksi=view&pesan=berhasilLogin");
            }else {
                    header("location:index.php?page=aslab&aksi=loginAslab&pesan=password atau npm salah");
                }
        }

        /**
         * funtion untuk cek database berdasarkan
         * @param String $npm berisi npm
         * @param String $password berisi password
         */

        public function prosesAuthPraktikan($npm,$password){
           $sql = "select * from praktikan where npm='$npm' and password='$password'";
           $query = koneksi()->query($sql);
           return $query->fetch_assoc();
        }

                /**function login untuk authentikasi praktikan */        
        public function authPraktikan(){
            $npm = $_POST['npm'];
            $password = $_POST['password'];
            $data = $this->prosesAuthPraktikan($npm,$password);
            if ($data) {
                $_SESSION['role'] = 'praktikan';
                $_SESSION['praktikan'] = $data;

                header("location:index.php?page=praktikan&aksi=view&pesan=berhasilLogin");
            }else {
                    header("location:index.php?page=aslab&aksi=loginPraktikan&pesan=password atau npm salah");
                }
        }

        public function logout(){
            session_destroy();
            header("location:index.php?page=aslab&aksi=view&pesan=berhasilLogout");
        }

    }