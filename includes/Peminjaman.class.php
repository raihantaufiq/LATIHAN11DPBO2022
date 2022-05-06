<?php

class Peminjaman extends DB
{
    function getPeminjaman()
    {
        $query = "SELECT * FROM peminjaman";
        return $this->execute($query);
    }

    function add($data)
    {
        $member = $data['tmember'];
        $buku = $data['tbuku'];

        $query = "INSERT INTO peminjaman VALUES ('', '$member', '$buku', 'Belum')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {
        $query = "DELETE FROM peminjaman WHERE id_peminjaman = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function statusPeminjaman($id)
    {
        $status = "Sudah";
        $query = "UPDATE peminjaman SET status='$status' WHERE id_peminjaman = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }
}
