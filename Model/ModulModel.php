<?php
    class ModulModel{
        /**
         * untuk mengambil data modul
         */
       public function get(){
           $sql = "
            SELECT modul.id as id, praktikum.nama as praktikum, praktikum.status as status,
            modul.nama as nama
            From modul 
            JOIN praktikum
            ON modul.praktikum_id = praktikum.id
            WHERE praktikum.status = 1         
           ";
           $query = koneksi()->query($sql);
           $hasil = [];
           while ($data = $query->fetch_assoc()) {
               $hasil [] = $data;
           }
           return $hasil;
       }


       

       /**
        * function GetLastData berfungsi untuk mengambil data modul
        */
        public function getLastData(){
            $sql = "
            SELECT modul.id AS id, 
            modul.nama AS nama
            FROM modul
            JOIN praktikum ON
            modul.praktikum_id = praktikum.id
            WHERE praktikum.status = 1
            ORDER BY id DESC LIMIT 1
            ";

            $query = koneksi()->query($sql);
            return $query->fetch_assoc();
        }

        /**
         * function prosesStore untuk menambah data modul ke database
         * @param String modul berisi nama modul
         * @param String id praktikum berisi idpraktikum
         */
        public function prosesStore($modul, $id_praktikum){
            $sql = "
                    INSERT INTO modul(nama, praktikum_id)
                    VALUES ('$modul','$id_praktikum')
                   ";
            return koneksi()->query($sql);
        }

        /**
         * function prosesDelete untuk menghapus data modul di database
         * @param integer id berisi id modul
         */
        public function prosesDelete($id){
            $sql = "
                    DELETE FROM modul WHERE id=$id
                   ";
            return koneksi()->query($sql);
        }

        /**
         * function get mengambil data dari database
         */
        public function getPraktikum(){
            $sql = "SELECT * FROM praktikum WHERE status = 1";
            $query = koneksi()->query($sql);
            $hasil = [];
            while ($data = $query->fetch_assoc()) {
                $hasil [] = $data;
            }
            return $hasil;
        }

       
       

    }

    
    // $coba = new ModulModel();
    // var_export($coba->prosesDelete(4));die;
    
