<?php

class Member extends DB {

    function getMember() {
        $query = "SELECT * FROM member";
        return $this->execute($query);
    }

    function getMember_byNIM($nim) {
        $query = "SELECT * FROM member WHERE nim='$nim'";
        return $this->execute($query);
    }

    function add($data) {
        $nim = $data['tnim'];
        $nama = $data['tnama'];
        $jurusan = $data['tjurusan'];

        $query = "INSERT INTO member values ('$nim', '$nama', '$jurusan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function edit($data) {
        $nim = $data['tnim'];
        $nama = $data['tnama'];
        $jurusan = $data['tjurusan'];

        $query = "UPDATE member SET nama='$nama', jurusan='$jurusan' WHERE nim='$nim'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($nim) {
        $query = "DELETE FROM member WHERE nim = '$nim'";
        // Mengeksekusi query
        return $this->execute($query);
    }
    
}
