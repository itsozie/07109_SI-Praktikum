<?php
    class AuthModel{
        

        
        public function prosesAuthAslab($npm,$password){
            $sql = "select * from aslab where npm='$npm' and password='$password'";
            $query = koneksi()->query($sql);
            return $query->fetch_assoc();
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

       
        /**
         * @param string $nama berisi nama
         * @param string $npm berisi npm
         * @param string $no_hp berisi no hp
         * @param string $password berisi password
         * function ini digunakan untuk menambahkan data praktikan
         */
        public function prosesStorePraktikan($nama, $npm, $no_hp, $password){
            $sql= "
                INSERT INTO praktikan(nama,npm,nomor_hp,password)
                VALUES('$nama','$npm','$no_hp','$password')
            ";
            return koneksi()->query($sql);
        }

    }

    // $tes = new AuthModel();
    // var_export($tes->prosesStorePraktikan('nyoba','06.2019.2.07111','123','123'))
    // ;die;