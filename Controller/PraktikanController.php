<?php
class PraktikanController {
    private $model;
        /**function ini adalah constructor untuk menginisialisasi
         * objek modul model
         */
    public function __construct(){
        $this->model=New PraktikanModel;
    }
    /**
     * mengatur tampilan awal halaman praktikan
     */
    public function index(){
        $id=$_SESSION['praktikan']['id'];
        $data = $this->model->get($id);
        extract($data);
        require_once("View/praktikan/index.php");
    }
    /**
     * function edit untuk menampilkan halaman edit
     */
    public function edit(){
        $id = $_SESSION['praktikan']['id'];
        $data = $this->model->get($id);
        extract($data);
        require_once("View/praktikan/edit.php");
    }
    /**
     * function update untuk mempernbarui data praktikan
     */
    public function update(){
        $id = $_POST['id'];
        $nama = $_POST['nama'];
        $npm = $_POST['npm'];
        $no_hp = $_POST['nomor_hp'];
        $password = $_POST['password'];
        if ($this->model->prosesUpdate($nama,$npm,$password,$no_hp,$id)) {
            header("location: index.php?page=praktikan&aksi=view&pesan=berhasil ubah data");
        }else {
            header("location: index.php?page=praktikan&aksi=edit&pesan=gagal ubah data");
        }
    }

     /**
     * mengatur halaman praktikum
     */
    public function praktikum(){
        $idPraktikan=$_SESSION['praktikan']['id'];
        $data = $this->model->getPendaftaranPraktikum($idPraktikan);
        extract($data);
        require_once("View/praktikan/praktikum.php");
    }
    /**
     * mengatur tampilan awal halam daftar praktikum
     * 
     */
    public function daftarPraktikum(){
        $data = $this->model->getPraktikum();
        extract($data);
        require_once("View/praktikan/daftarPraktikum.php");
    }
    /**
     * function store praktikan berfungsi untuk 
     * memproses data praktikum yang dipilih untuk ditambahkan
     */
    public function storePraktikum(){
        $idPraktikum = $_POST['praktikum'];
        $idPraktikan = $_SESSION['praktikan']['id'];
        if ($this->model->prosesStorePraktikum($idPraktikan, $idPraktikum)) {
            header("location: index.php?page=praktikan&aksi=praktikum&pesanBerhasil Daftar");
        }else {
            header("location: index.php?page=praktikan&aksi=daftarPraktikum&pesanGagal Daftar");
        }
    }

     /**
     * mengatur halaman nilai praktikum
     */
    public function nilaiPraktikan(){
        $idPraktikan = $_SESSION['praktikan']['id'];
        $idPraktikum = $_GET['idPraktikum'];
        $modul = $this->model->getModul();
        $nilai = $this->model->getNilaiPraktikan($idPraktikan,$idPraktikum);
        require_once("View/praktikan/nilaiPraktikan.php");
    }
 
}
