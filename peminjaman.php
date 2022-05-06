<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Peminjaman.class.php");
include("includes/Member.class.php");
include("includes/Buku.class.php");

$peminjaman = new Peminjaman($db_host, $db_user, $db_pass, $db_name);
$peminjaman->open();
$peminjaman->getPeminjaman();

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();

$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$buku->open();

if (isset($_POST['add'])) {
    //memanggil add
    $peminjaman->add($_POST);
    header("location:peminjaman.php");
}

//mengecek apakah ada id_hapus, jika ada maka memanggil fungsi delete
if (!empty($_GET['id_hapus'])) {
    //memanggil delete
    $id_peminjaman = $_GET['id_hapus'];

    $peminjaman->delete($id_peminjaman);
    header("location:peminjaman.php");
}

if (!empty($_GET['id_edit'])) {
    //memanggil edit
    $id_peminjaman = $_GET['id_edit'];

    $peminjaman->statusPeminjaman($id_peminjaman);
    header("location:peminjaman.php");
}

//data pada tabel
$data = null;
$no = 1;

while (list($id_peminjaman, $member_inpeminjaman, $buku_inpeminjaman, $status) = $peminjaman->getResult()) {

    $member->getMember_byNIM($member_inpeminjaman);
    list($nim, $nama_member, $jurusan) = $member->getResult();

    $buku->getBuku_byId($buku_inpeminjaman);
    list($id_buku, $judul, $penerbit, $deskripsi, $status_buku, $id_author) = $buku->getResult();

    if ($status == 'Sudah') {
        $data .= "<tr>
                <td>" . $no++ . "</td>
                <td>" . $nim . " - " . $nama_member . "</td>
                <td>" . $judul . "</td>
                <td>" . $status . "</td>
                <td>
                <a href='peminjaman.php?id_hapus=" . $id_peminjaman . "' class='btn btn-danger''>Hapus</a>
                </td>
                </tr>";
    } else {
        $data .= "<tr>
                <td>" . $no++ . "</td>
                <td>" . $nim . " - " . $nama_member . "</td>
                <td>" . $judul . "</td>
                <td>" . $status . "</td>
                <td>
                <a href='peminjaman.php?id_edit=" . $id_peminjaman .  "' class='btn btn-warning''>Edit</a>
                <a href='peminjaman.php?id_hapus=" . $id_peminjaman . "' class='btn btn-danger''>Hapus</a>
                </td>
                </tr>";
    }
}

//data pada form
$data_optionMember = null;
$data_optionBuku = null;

$member->getMember();
$buku->getBuku();

while (list($nim, $nama_member, $jurusan) = $member->getResult()) {
    
    $data_optionMember .= "<option value='".$nim."'>".$nim." - ".$nama_member."</option>";
    
}

while (list($id, $judul, $penerbit, $deskripsi, $status, $id_author) = $buku->getResult()) {
    
    $data_optionBuku .= "<option value='".$id."'>".$judul."</option>";
    
}



$peminjaman->close();
$member->close();
$buku->close();
$tpl = new Template("templates/peminjaman.html");
$tpl->replace("DATA_OPTION_MEMBER", $data_optionMember);
$tpl->replace("DATA_OPTION_BUKU", $data_optionBuku);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
