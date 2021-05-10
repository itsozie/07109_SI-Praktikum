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

       /**
        * function proses Store berfungsi untuk menginput data praktikum
         *@param String $nama berisi nama praktikum
         *@param String $tahun berisi tahun praktikum 
        */
        public function prosesStore($nama, $tahun){
            $sql ="
                    INSERT INTO praktikum(nama, tahun)
                    VALUES('$nama','$tahun')
            ";
            return koneksi()->query($sql);
        }

        /**
        * function proses Store berfungsi untuk mengubah data di database
         *@param String $nama berisi nama praktikum
         *@param String $tahun berisi tahun praktikum
         *@param String $id berisi id data database 
         */
        public function storeUpdate($nama, $tahun, $id){
            $sql= "
                    UPDATE praktikum
                    SET nama='$nama', tahun='$tahun' WHERE id='$id';
            ";
            return koneksi()->query($sql);
        }

        /**
        * function aktifkan untuk merubah salah satu field di database
         *@param String $id berisi id suatu data
        */
        public function prosesAktifkan($id){
            koneksi()->query(("UPDATE praktikum SET status=0"));
            $sql = "UPDATE praktikum SET status=1 WHERE id=$id";
            return koneksi()->query($sql);
        } 
        
        /**
        * function nonaktif untuk merubah salah satu field di database
         *@param String $id berisi id suatu data
        */

        public function prosesNonAktifkan($id){
            $sql = "UPDATE praktikum SET status=0 WHERE id=$id";
            return koneksi()->query($sql); 
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

            if ($this->prosesStore($nama, $tahun)) {
                header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil Menambah Data");
            }else {
                header("location: index.php?page=praktikum&aksi=create&pesan=gagal Menambah Data");
            }
        }

        /**
         * function getID berfungsi utuk mengambil data suatu dari database
         * @param integer $id berisi id suatu database
         */
        public  function getById($id){
            $sql = "SELECT * FROM praktikum WHERE id=$id";
            $query = koneksi()->query($sql);
            return $query->fetch_assoc();
        }

        /**
         * function update berfungsi utuk merubah data suatu dari database
         * mengambil data POST nama, tahun
         */
        public function update(){
            $id   = $_POST['id'];  
            $nama = $_POST['nama'];
            $tahun= $_POST['tahun'];

            if ($this->storeUpdate($nama, $tahun, $id)) {
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
            if ($this->prosesAktifkan($id)) {
                header("location: index.php?page=praktikum&aksi=view&pesan=Berhasil mengaktifkan Data");
            }else {
                header("location: index.php?page=praktikum&aksi=view&pesan=gagal mengaktifkan Data");
            }
        }

        /**
         * function ini berfungsi untuk memproses update salah satu field data
         * mengambil data GET dari id
         */
        public function nonAktifkan($id){
            $id = $_GET['id'];
            if ($this->prosesNonAktifkan($id)) {
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
        $data = $this->getById($id);
        extract($data);
        require_once("View/praktikum/edit.php");
        }

    }


    
    // $coba = new PraktikumModel();
    // var_export($coba->prosesNonAktifkan(2));die;