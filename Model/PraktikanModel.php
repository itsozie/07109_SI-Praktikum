<?php
    class PraktikanModel{
        /**
         * mengambil data praktikan
         * @param integer id berisi id Praktikan
         * 
         */
        public function get($id){
        $sql= "
            SELECT * FROM praktikan
            WHERE id = $id
              ";
        $query=koneksi()->query($sql);
        return $query->fetch_assoc();
    }
    

    /**
     * mengatur tampilan awal halaman praktikan
     */
    public function index(){
        $id=$_SESSION['praktikan']['id'];
        $data = $this->get($id);
        extract($data);
        require_once("View/praktikan/index.php");
    }


    /**
     * mengambil seluruh data praktikum
     * 
     */
    public function getPraktikum(){
        $sql ="SELECT * FROM praktikum
        WHERE status =1
        ";
        $query = koneksi()->query($sql);
        $hasil =[];
        while ($data = $query->fetch_assoc()) {
            $hasil [] = $data;
        }
        return $hasil; 

    }


    /**
     * mengatur tampilan awal halam daftar praktikum
     * 
     */
    public function daftarPraktikum(){
        $data = $this->getPraktikum();
        extract($data);
        require_once("View/praktikan/daftarPraktikum.php");
    }


    /**
     * mengambil data pendaftaran praktikum
     * @param integer $idPraktikan berisi id praktikan
     */
    public function getPendaftaranPraktikum($idPraktikan){
        $sql="
        SELECT daftarprak.id as idDaftar, praktikum.nama as namaPraktikum, 
        praktikum.id as idPraktikum, daftarprak.status FROM daftarprak
        JOIN praktikum on praktikum.id = daftarprak.praktikum_id
        WHERE daftarprak.praktikan_id = $idPraktikan
        ";
        $query = koneksi()->query($sql);
        $hasil =[];
        while ($data = $query->fetch_assoc()) {
            $hasil [] = $data;
        }
        return $hasil; 
    }


    /**
     * mengatur halaman praktikum
     */
    public function praktikum(){
        $idPraktikan=$_SESSION['praktikan']['id'];
        $data = $this->getPendaftaranPraktikum($idPraktikan);
        extract($data);
        require_once("View/praktikan/praktikum.php");
    }



    /**
     * mengambil data praktikum yang aktif
     */
    public function getModul(){
        $sql= "
        SELECT modul.id as idModul, modul.nama as namaModul 
        FROM modul
        JOIN praktikum on praktikum.id = modul.praktikum_id
        WHERE praktikum.status = 1
        ";
        $query = koneksi()->query($sql);
        $hasil =[];
        while ($data = $query->fetch_assoc()) {
            $hasil []= $data;
        }
        return $hasil; 
    }


    /**
     * mengambil data nilai praktikan di tiap-tiap praktikum
     * @param integer $idPraktikan berisi id praktikan
     * @param integer $idPraktikum berisi id praktikum
     */
    public function getNilaiPraktikan($idPraktikan,$idPraktikum){
        $sql ="
        SELECT * FROM nilai
        JOIN modul on modul.id = nilai.modul_id
        WHERE praktikan_id = $idPraktikan
        AND praktikum_id = $idPraktikum
        ORDER BY modul.id
        ";
        $query = koneksi()->query($sql);
        $hasil =[];
        while ($data = $query->fetch_assoc()) {
            $hasil [] = $data;
        }
        return $hasil; 
    }


    /**
     * mengatur halaman nilai praktikum
     */
    public function nilaiPraktikan(){
        $idPraktikan = $_SESSION['praktikan']['id'];
        $idPraktikum = $_GET['idPraktikum'];
        $modul = $this->getModul();
        $nilai = $this->getNilaiPraktikan($idPraktikan,$idPraktikum);
        require_once("View/praktikan/nilaiPraktikan.php");
    }

}

    // $coba = new PraktikanModel();
    // var_export($coba->nilaiPraktikan());die;