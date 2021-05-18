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

        /**
         * function create menambah modul
         */ 
        public function create(){
            $data = $this->getPraktikum();
            extract($data);
            require_once("View/modul/create.php");
        }

        /**
         * function store digunakan untuk menyimpan data modul
         *  yg telah diinputkan
         */
        public function store(){
            $modul = $_POST['modul'];
            $praktikum = $_POST['praktikum'];
            $getLastData = $this->getLastData();
            if ($getLastData==null) {
                for ($i=1; $i <= $modul; $i++) { 
                    $nama = 'modul ' . $i;
                    $post = $this->prosesStore($nama, $praktikum);
                }
            }else {
                $modulLast= explode(" ", $getLastData['nama']);
                for ($i=1; $i <= $modul; $i++) { 
                    $a = $modulLast['1'] += 1;
                    $nama = 'modul ' . $a;
                    $post = $this->prosesStore($nama, $praktikum);
                }
            }
            if($post){
                header("Location: index.php?page=modul&aksi=view&pesan=Berhasil Menambah data");
            }else {
                header("Location: index.php?page=modul&aksi=create&pesan=Gagal Menambah data");
            }
        }

        /**function delete berfungsi menghapus modul
         * 
         */
        public function delete(){
            $id = $_GET['id'];
            if ($this->prosesDelete($id)) {
                header("Location: index.php?page=modul&aksi=view&pesan=Berhasil Delete data");
            }else {
                header("Location: index.php?page=modul&aksi=view&pesan=Gagal Delete data");
            }
        }

    }

    
    // $coba = new ModulModel();
    // var_export($coba->prosesDelete(4));die;
    
