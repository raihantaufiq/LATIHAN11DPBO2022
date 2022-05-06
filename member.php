<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Member.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();

if (isset($_POST['add'])) {
    //memanggil add
    $member->add($_POST);
    header("location:member.php");
}

if (isset($_POST['edit'])) {
    //memanggil edit
    $member->edit($_POST);
    header("location:member.php");
}

//mengecek apakah ada nim_hapus, jika ada maka memanggil fungsi delete
if (!empty($_GET['nim_hapus'])) {
    //memanggil delete
    $nim = $_GET['nim_hapus'];

    $member->delete($nim);
    header("location:member.php");
}


//data pada tabel
$data = null;

while (list($nim, $nama, $jurusan) = $member->getResult()) {
    
    $data .= "<tr>
            <td>" . $nim . "</td>
            <td>" . $nama . "</td>
            <td>" . $jurusan . "</td>
            <td>
            <a href='member.php?nim_edit=" . $nim .  "' class='btn btn-warning''>Edit</a>
            <a href='member.php?nim_hapus=" . $nim . "' class='btn btn-danger''>Hapus</a>
            </td>
            </tr>";
    
}

//data pada form
$data_judulForm = null;
$data_inputNIM = null;
$data_inputNama = null;
$data_inputJurusan = null;
$data_tombol = null;

if (!empty($_GET['nim_edit'])) {
    // form edit
    $nim = $_GET['nim_edit'];

    $member->getMember_byNIM($nim);
    list($nim, $nama, $jurusan) = $member->getResult();

    $data_judulForm = 'Edit Member';
    $data_inputNIM = '<input readonly type="text" class="form-control" name="tnim" value="'.$nim.'" required />';
    $data_inputNama = '<input type="text" class="form-control" name="tnama" value="'.$nama.'" required />';
    $data_inputJurusan = '<input type="text" class="form-control" name="tjurusan" value="'.$jurusan.'" required />';
    $data_tombol = '<button type="submit" name="edit" class="btn btn-success w-100">Edit</button>
                    <a href="member.php" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>';

}else{
    //form add
    $data_judulForm = "Input Member";
    $data_inputNIM = '<input type="text" class="form-control" name="tnim" required />';
    $data_inputNama = '<input type="text" class="form-control" name="tnama" required />';
    $data_inputJurusan = '<input type="text" class="form-control" name="tjurusan" required />';
    $data_tombol = '<button type="submit" name="add" class="btn btn-primary w-100">Add</button>';
}


$member->close();
$tpl = new Template("templates/member.html");
$tpl->replace("DATA_FORM_JUDUL", $data_judulForm);
$tpl->replace("DATA_FORM_NIM", $data_inputNIM);
$tpl->replace("DATA_FORM_NAMA", $data_inputNama);
$tpl->replace("DATA_FORM_JURUSAN", $data_inputJurusan);
$tpl->replace("DATA_FORM_TOMBOL", $data_tombol);
$tpl->replace("DATA_TABEL", $data);
$tpl->write();
