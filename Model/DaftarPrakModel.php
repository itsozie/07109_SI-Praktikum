<?php
    class DaftarPrakModel{
        /**
         * mengambil data daftar praktikum
         */
        public function get(){
        $sql = "
        SELECT daftarprak.id as idDaftar, daftarprak.praktikan_id as idPraktikan,
        praktikan.nama as namaPraktikan, daftarprak.status as status, praktikum.nama as namaPraktikum
        FROM daftarprak
        JOIN praktikan
        ON praktikan.id = daftarprak.praktikan_id
        JOIN praktikum
        ON praktikum.id = daftarprak.praktikum_id
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
     * mengatur tampilan utama daftarprak
     */
    public function index(){
        $data = $this->get();
        extract($data);
        require_once("VIew/daftarprak/index.php");
    }
    /**
     * @param integer $id berisi id
     * @param integer $id_aslab berisi id aslab
     * function ini digunakan untuk mengupdate status daftarprak
     */
    public function prosesVerif($id,$idAslab){
        $sql = "
                UPDATE daftarprak SET status = 1,
                aslab_id = $idAslab WHERE id = $id";

        $query = koneksi()->query($sql);
        return $query;
    }

    /**
     * @param integer id berisi $id
     * @param integer idPraktikan berisi id praktikan
     * function unverif digunakan untuk meng un verif status dafarprak
     */
    public function prosesUnVerif($id, $idPraktikan){
        $sqlDelete = "DELETE FROM nilai WHERE praktikan_id = $idPraktikan";
        koneksi()->query($sqlDelete);

        $sqlUpdate = "UPDATE daftarprak SET status = 0, aslab_id = NULL
        WHERE id = $id";

        $query = koneksi()->query($sqlUpdate);
        return $query;
    }

    /**
     * function verif berfungsi untuk mengverifikasi praktikan 
     * yang sudah mendaftar praktikum
     */
    public function verif(){
        $id = $_GET['id'];
        $idAslab = $_SESSION['aslab']['id'];
        if($this->prosesVerif($id,$idAslab)) {
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
        if ($this->prosesUnVerif($id,$idPraktikan)) {
            header("location: index.php?page=daftarprak&aksi=view&pesan=Berhasil UnVerifikasi Praktikan");
        }else {
            header("location: index.php?page=daftarprak&aksi=view&pesan=Gagal UnVerifikasi Praktikan");
        }
    }
}



// $tes = new DaftarPrakModel();
// var_export($tes->prosesUnVerif(1,1));die();