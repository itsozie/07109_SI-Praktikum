<?php
    class AslabModel{
        /**
         * @param integer $idAslab berisi aslab
         * funtion get berfungsi mengambil seluruh data praktikan
         */
        public function get($idAslab){
            $sql = "SELECT praktikan.id as idPraktikan, praktikan.nama as namaPraktikan, 
            praktikan.npm as npmPraktikan, 
            praktikan.nomor_hp as nohpPraktikan, praktikum.nama as 
            namaPraktikum FROM praktikan
            JOIN daftarprak ON daftarprak.praktikan_id = praktikan.id
            JOIN praktikum ON daftarprak.praktikum_id = praktikum.id
            WHERE daftarprak.status = 1
            AND daftarprak.aslab_id = $idAslab
            AND praktikum.status    = 1
            ";
            $query = koneksi()->query($sql);
            $hasil =[];
            while ($data = $query->fetch_assoc()) {
                $hasil [] = $data;
            }
            return $hasil;
        }

        /**
         * mengatur tampilan awal
         */
        public function index(){
            $idAslab = $_SESSION['aslab']['id'];
            $data = $this->get($idAslab);
            extract($data);
            require_once("View/aslab/index.php");
        }

        /**
         *mengambil seluruh data Modul 
         */
        public function getModul(){
            $sql ="
            SELECT modul.id as idModul, modul.nama as namaModul FROM modul
            JOIN praktikum on praktikum.id = modul.praktikum_id
            WHERE praktikum.status = 1
            ";
            $query = koneksi()->query($sql);
            $hasil =[];
            while ($data = $query->fetch_assoc()) {
                $hasil [] = $data;
            }
            return $hasil;
        }

        /**
         * @param integer $idPraktikan berisi id praktikan
         * mengambil nilai praktikan
         */
        public function getNilaiPraktikan($idPraktikan){
            $sql="
            SELECT * from nilai
            JOIN modul on modul.id = nilai.modul_id
            WHERE praktikan_id = $idPraktikan
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
         * mengatur tampilan nilai praktikan
         */
        public function nilai(){
            $idPraktikan = $_GET['id'];
            $modul       = $this->getModul();
            $nilai       = $this->getNilaiPraktikan($idPraktikan);
            extract($modul);
            extract($nilai);
            require_once("View/aslab/nilai.php");
        }

        /**
         * @param integer $idModul berisi id modul
         * @param integer $idPraktikan berisi id praktikan
         * @param integer $nilai berisi id nilai
         * function ini digunakan untuk mengisi nilai yang sesuai 
         * dengan id praktikan dan id per modul
         * kedalam database 
         */
        public function prosesStoreNilai($idModul,$idPraktikan,$nilai){
            $sqlCek = "
                        SELECT * FROM nilai WHERE modul_id=$idModul
                        and praktikan_id=$idPraktikan
                        ";

            $cek= koneksi()->query($sqlCek);

            if($cek->fetch_assoc()==null) {
                $sqlInsert= "
                             INSERT INTO nilai(modul_id,praktikan_id,nilai) 
                             VALUES($idModul,$idPraktikan,$nilai)
                             ";

                $query = koneksi()->query($sqlInsert);
            }else {
                $sqlUpdate = "
                              UPDATE nilai SET nilai='$nilai' 
                              WHERE modul_id=$idModul and praktikan_id=$idPraktikan
                              ";

                 $query = koneksi()->query($sqlUpdate);
            }
            return $query;
        }

        /**
         * function store nilai berfungsi untuk menyimpan data nilai
         * sesuai dengan id praktikan dari form yang telah diisi aslab
         * pada halaman create nilai
         */
        public function storeNilai(){
            $idModul        = $_POST['modul'];
            $idPraktikan    = $_GET['id'];
            $nilai          = $_POST['nilai'];
            if ($this->prosesStoreNilai($idModul,$idPraktikan,$nilai)) {
                header("location: index.php?page=aslab&aksi=nilai&pesan=Berhasil Tambah Data&id=$idPraktikan");
            }else {
                header("location: index.php?page=aslab&aksi=nilai&pesan=Gagal Tambah Data&id=$idPraktikan");
            }
        }

        /**
         * function createNilai berfungsi untuk mengatur halaman nilai
         */
        public function createNilai(){
            $modul = $this->getModul();
            extract($modul);
            require_once("View/aslab/createNilai.php");
        }

    }

// $coba = new AslabModel();
// var_export($coba->prosesStoreNilai(1,1,50));
// die();