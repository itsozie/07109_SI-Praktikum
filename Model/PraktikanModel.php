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

    /**
     * @param string $nama berisi nama praktikan
     * @param string $npm berisi npm praktikan 
     * @param string $nama password password praktikan
     * @param string $no_hp berisi nomor_hp praktikan
     * @param integer $id berisi id
     * function ini digunakan untuk update  data praktikan
     */
    public function prosesUpdate($nama, $npm, $password, $no_hp, $id){
        $sql = "
               UPDATE praktikan SET 
               nama='$nama', npm='$npm', password='$password', nomor_hp='$no_hp'
               WHERE id = $id
        ";
        $query = koneksi()->query($sql);
        
        return $query;
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
        if ($this->prosesUpdate($nama, $npm, $password, $no_hp, $id)) {
            header("location: index.php?page=praktikan&aksi=view&pesan=berhasil ubah data");
        }else {
            header("location: index.php?page=praktikan&aksi=edit&pesan=gagal ubah data");
        }
    }

    /**
     * function edit untuk menampilkan halaman edit
     */
    public function edit(){
        $id = $_SESSION['praktikan']['id'];
        $data = $this->get($id);
        extract($data);
        require_once("View/praktikan/edit.php");
    }

    /**
     * @param integer $idPraktikan berisi id praktikan
     * @param integer $idPraktikum berisi id praktikum
     * function ini digukan untuk input data 
     * daftar praktikum
     */
    public function prosesStorePraktikum($idPraktikan, $idPraktikum){
        $sql = "
                INSERT INTO daftarprak(
                    praktikan_id, praktikum_id, status)
                VALUES(
                    $idPraktikan, $idPraktikum, 0
                )
        ";
        
        $query = koneksi()->query($sql);

        return $query;
    }

    /**
     * function store praktikan berfungsi untuk 
     * memproses data praktikum yang dipilih untuk ditambahkan
     */
    public function storePraktikum(){
        $praktikum = $_POST['praktikum'];
        $idPraktikan = $_SESSION['praktikan']['id'];
        if ($this->prosesStorePraktikum($idPraktikan, $idPraktikum)) {
            header("location: index.php?page=praktikan&aksi=praktikum&pesanBerhasil Daftar");
        }else {
            header("location: index.php?page=praktikan&aksi=daftarPraktikum&pesanGagal Daftar");
        }
    }
}

    // $coba = new PraktikanModel();
    // var_export($coba->prosesStorePraktikum(3,1));die;