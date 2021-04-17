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
         * mengatur tampilan awal
         */
        public function index(){
            $data = $this->get();
            extract($data);
            require_once("View/praktikum/index.php");
        }
    }
