<?php
class ModulController {
    private $model;
    /**function ini adalah constructor untuk menginisialisasi
         * objek modul model
         */
    public function __construct(){
        $this->model=new ModulModel;
    }
    /**
        * mengatur tampilan awal modul
        */
        public function index(){
            $data = $this->model->get();
            extract($data);
            require_once("VIew/modul/index.php");
        }
         /**
         * function create menambah modul
         */ 
        public function create(){
            $data = $this->model->getPraktikum();
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
            $getLastData = $this->model->getLastData();
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
                    $post = $this->model->prosesStore($nama, $praktikum);
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
            if ($this->model->prosesDelete($id)) {
                header("Location: index.php?page=modul&aksi=view&pesan=Berhasil Delete data");
            }else {
                header("Location: index.php?page=modul&aksi=view&pesan=Gagal Delete data");
            }
        }

}
