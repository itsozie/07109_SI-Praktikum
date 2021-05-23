<?php
class DaftarPrakController {

    private $model;
    /**function ini adalah constructor untuk menginisialisasi
         * objek daftarprak model
         */
    public function __construct(){
        $this->model=new DaftarPrakModel;
    }
/**
     * mengatur tampilan utama daftarprak
     */
    public function index(){
        $data = $this->model->get();
        extract($data);
        require_once("VIew/daftarprak/index.php");
    }
    
    /**
     * function verif berfungsi untuk mengverifikasi praktikan 
     * yang sudah mendaftar praktikum
     */
    public function verif(){
        $id = $_GET['id'];
        $idAslab = $_SESSION['aslab']['id'];
        if($this->model->prosesVerif($id,$idAslab)) {
            header("location: index.php?page=daftarprak&aksi=view&pesan=Berhasil Verifikasi Praktikan");
        }else {
            header("location: index.php?page=daftarprak&aksi=view&pesan=Gagal Verifikasi Praktikan");
        }
    }

     /**
     * function Unverif berfungsi untuk mengUnverifikasi praktikan 
     * yang sudah mendaftar praktikum
     */
    public function UnVerif(){
        $id = $_GET['id'];
        $idAslab = $_GET['idPraktikan'];
        if ($this->model->prosesUnVerif($id,$idPraktikan)) {
            header("location: index.php?page=daftarprak&aksi=view&pesan=Berhasil UnVerifikasi Praktikan");
        }else {
            header("location: index.php?page=daftarprak&aksi=view&pesan=Gagal UnVerifikasi Praktikan");
        }
    }
    
}
