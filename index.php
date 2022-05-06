<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Buku.class.php");
include("includes/Author.class.php");

$buku = new Buku($db_host, $db_user, $db_pass, $db_name);
$author = new Author($db_host, $db_user, $db_pass, $db_name);
$buku->open();
$author->open();
$buku->getBuku();
$author->getAuthor();

$status = false;
$alert = null;

if (isset($_POST['add'])) {
    //memanggil add
    $buku->add($_POST);
    header("location:index.php");
}

if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $id = $_GET['id_hapus'];

    $buku->delete($id);
    header("location:index.php");
}

if (!empty($_GET['id_edit'])) {
    //memanggil add
    $id = $_GET['id_edit'];

    $buku->statusBuku($id);
    header("location:index.php");
}

$data = null;
$dataAuthor = null;
$no = 1;

while (list($id, $judul, $penerbit, $deskripsi, $status, $id_author) = $buku->getResult()) {
    if ($status == "Best Seller") {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $judul . "</td>
            <td>" . $penerbit . "</td>
            <td>" . $deskripsi . "</td>
            <td>" . $status . "</td>
            <td>" . $id_author . "</td>
            <td>
            <a href='index.php?id_hapus=" . $id . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
    else {
        $data .= "<tr>
            <td>" . $no++ . "</td>
            <td>" . $judul . "</td>
            <td>" . $penerbit . "</td>
            <td>" . $deskripsi . "</td>
            <td>" . $status . "</td>
            <td>" . $id_author . "</td>
            <td>
            <a href='index.php?id_edit=" . $id .  "' class='btn btn-warning' '>Edit</a>
            <a href='index.php?id_hapus=" . $id . "' class='btn btn-danger' '>Hapus</a>
            </td>
            </tr>";
    }
}

while (list($id, $nama, $status) = $author->getResult()) {
    $dataAuthor .= "<option value='".$id."'>".$nama."</option>
                ";
}

$author->close();
$buku->close();
$tpl = new Template("templates/index.html");
$tpl->replace("OPTION", $dataAuthor);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
