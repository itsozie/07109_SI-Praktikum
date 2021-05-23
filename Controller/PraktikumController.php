<?php
class PraktikumController {
    private $model;
     /**
     * function construct mengambil objek dari
     * praktikum model
     */
    public function __construct(){
        $this->model = New PraktikumModel;
    }
    /**
         * mengatur tampilan awal
         */
        public function index(){
            $data = $this->model->get();
            extract($data);
            require_once("View/praktikum/index.php");
        }
         /**
         * function create berfungsi untuk menambah data
         */
        public function create(){
            require_once("View/praktikum/create.php");
        }

        /**
         * function store berfungsi untuk memproses data untuk ditambahkan
         * mengambil data dari post nama dan tahun
         */
        public function store(){
            $nama = $_POST['nama'];
            $tahun= $_POST['tahun'];

            if ($this->model->prosesStore($nama, $tahun)) {
                header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil Menambah Data");
            }else {
                header("location: index.php?page=praktikum&aksi=create&pesan=gagal Menambah Data");
            }
        }
/**
         * function update berfungsi utuk merubah data suatu dari database
         * mengambil data POST nama, tahun
         */
        public function update(){
            $id   = $_POST['id'];  
            $nama = $_POST['nama'];
            $tahun= $_POST['tahun'];

            if ($this->model->storeUpdate($nama, $tahun, $id)) {
                header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil mengubah Data");
            }else {
                header("location: index.php?page=praktikum&aksi=edit&pesan=gagal mngubah Data");
            }
        }

        /**
         * function ini berfungsi untuk memproses salah satu field data
         * mengambil data GET dari id
         */
        public function aktifkan(){
            $id = $_GET['id'];
            if ($this->model->prosesAktifkan($id)) {
                header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil mengaktifkan Data");
            }else {
                header("location: index.php?page=praktikum&aksi=view&pesan=gagal mengaktifkan Data");
            }
        }

        /**
         * function ini berfungsi untuk memproses update salah satu field data
         * mengambil data GET dari id
         */
        public function nonAktifkan(){
            $id = $_GET['id'];
            if ($this->model->prosesNonAktifkan($id)) {
                header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil non aktifkan Data");
            }else {
                header("location: index.php?page=praktikum&aksi=view&pesan=gagal mengnonaktifkan Data");
            }  
        }

            /**
     * function untuk menampilkan halaman edit
     * ambil salah satu data dari database dengan param ID
     * ambil dari GET dengan ID
     */
    public function edit(){
        $id = $_GET['id'];
        $data = $this->model->getById($id);
        extract($data);
        require_once("View/praktikum/edit.php");
        }
    
}
