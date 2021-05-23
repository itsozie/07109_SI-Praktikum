<?php
    /**
     * berfungsi untuk mengambil seluruh data
     */
    class PraktikumModel{
        public function get(){
            $sql ="SELECT * FROM praktikum";
            $query = koneksi()->query($sql);
            $hasil = [];
            while($data = $query->fetch_assoc()) {
                $hasil[] = $data;
            }
            return $hasil;
        }
        

       /**
        * function proses Store berfungsi untuk menginput data praktikum
         *@param String $nama berisi nama praktikum
         *@param String $tahun berisi tahun praktikum 
        */
        public function prosesStore($nama, $tahun){
            $sql ="
                    INSERT INTO praktikum(nama, tahun)
                    VALUES('$nama','$tahun')
            ";
            return koneksi()->query($sql);
        }

        /**
        * function proses Store berfungsi untuk mengubah data di database
         *@param String $nama berisi nama praktikum
         *@param String $tahun berisi tahun praktikum
         *@param String $id berisi id data database 
         */
        public function storeUpdate($nama, $tahun, $id){
            $sql= "
                    UPDATE praktikum
                    SET nama='$nama', tahun='$tahun' WHERE id='$id';
            ";
            return koneksi()->query($sql);
        }

        /**
        * function aktifkan untuk merubah salah satu field di database
         *@param String $id berisi id suatu data
        */
        public function prosesAktifkan($id){
            koneksi()->query(("UPDATE praktikum SET status=0"));
            $sql = "UPDATE praktikum SET status=1 WHERE id=$id";
            return koneksi()->query($sql);
        } 
        
        /**
        * function nonaktif untuk merubah salah satu field di database
         *@param String $id berisi id suatu data
        */

        public function prosesNonAktifkan($id){
            $sql = "UPDATE praktikum SET status=0 WHERE id=$id";
            return koneksi()->query($sql); 
        }

       
        /**
         * function getID berfungsi utuk mengambil data suatu dari database
         * @param integer $id berisi id suatu database
         */
        public  function getById($id){
            $sql = "SELECT * FROM praktikum WHERE id=$id";
            $query = koneksi()->query($sql);
            return $query->fetch_assoc();
        }

        

    }


    // $coba = new PraktikumModel();
    // var_export($coba->prosesAktifkan(4));die;