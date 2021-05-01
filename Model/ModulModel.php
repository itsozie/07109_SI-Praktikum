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
        * mengatur tampilan awal modul
        */
       public function index(){
           $data = $this->get();
           extract($data);
           require_once("VIew/modul/index.php");
       }

    }

    
    // $coba = new ModulModel();
    // var_export($coba->get());die;
    
