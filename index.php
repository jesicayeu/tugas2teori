<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tugas";

$koneksi = mysqli_connect($host,$user,$pass,$db);
if(!$koneksi){ //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nosurat       = "";
$tanggalsurat  = "";
$tanggalterima = "";
$pengirim      = "";
$perihal       = "";
$sukses        = "";
$error         = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}
if($op == 'delete'){
    $id   = $_GET['id'];
    $sql1 = "delete from datasurat where id = '$id'";
    $sq1  = mysqli_query($koneksi,$sql1);
}

if($op == 'edit'){
    $id            = $_GET['id'];
    $sql1          = "select * from datasurat where id = '$id'";
    $q1            = mysqli_query($koneksi,$sql1);
    $r1            = mysqli_fetch_array($q1);
    $nosurat       = $r1['nosurat'];
    $tanggalsurat  = $r1['tanggalsurat'];
    $tanggalterima = $r1['tanggalterima'];
    $pengirim      = $r1['pengirim'];
    $perihal       = $r1['perihal'];

    if($nosurat == ''){
        $error = "Data tidak ditemukan";
    }
}

if(isset($_POST['simpan'])){ //untuk create
    $nosurat       = $_POST['nosurat'];
    $tanggalsurat  = $_POST['tanggalsurat'];
    $tanggalterima = $_POST['tanggalterima'];
    $pengirim      = $_POST['pengirim'];
    $perihal       = $_POST['perihal'];

    if($nosurat && $tanggalsurat && $tanggalterima && $pengirim && $perihal){
        if($op == 'edit'){ //untuk update
            $sql1 = "update datasurat set nosurat = '$nosurat',tanggalsurat = '$tanggalsurat',tanggalterima = '$tanggalterima',pengirim = '$pengirim',perihal = '$perihal' where id = '$id'";
            $q1   = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses = "Data berhasil diupdate";
            }else{
                $error = "Data gagal diupdate";
            }
        } else { //untuk insert
                 $sql1 = "insert into datasurat(nosurat,tanggalsurat,tanggalterima,pengirim,perihal) values ('$nosurat','$tanggalsurat','$tanggalterima','$pengirim','$perihal')";
                 $q1   = mysqli_query($koneksi,$sql1);
                if($q1){
                   $sukses = "Berhasil memasukkan data baru";
                }else{
                   $error = "Gagal memasukkan data";
                  }
                }
           }else{
        $error = "Silahkan masukkan semua data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Surat Masuk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .mx-auto {
            width:800px
        }
        .card {
            margin-top:10px;
        }
    </style>
</head>
<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
    <div class="card">
  <div class="card-header text-white bg-info" >
    Masukkan Data Surat Masuk
  </div>
  <div class="card-body">
    <?php
    if($error) {
    ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
        </div>
    <?php
      header("refresh:5;url=index.php");
    }
    ?>
    
    <?php
    if($sukses) {
    ?>
        <div class="alert alert-succes" role="alert">
            <?php echo $sukses ?>
        </div>
    <?php
       header("refresh:5;url=index.php"); //5 : detik
    }
    ?>
    <form action="" method="POST">
    <form>
  <div class="mb-3 row">
    <label for="nosurat" class="col-sm-2 col-form-label">No. Surat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="nosurat" name="nosurat" value="<?php echo $nosurat ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="tanggalsurat" class="col-sm-2 col-form-label">Tanggal Surat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="tanggalsurat" name="tanggalsurat" value="<?php echo $tanggalsurat ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="tanggalterima" class="col-sm-2 col-form-label">Tanggal Terima</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="tanggalterima" name="tanggalterima" value="<?php echo $tanggalterima ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="pengirim" class="col-sm-2 col-form-label">Pengirim</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="pengirim" name="pengirim" value="<?php echo $pengirim ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="perihal" class="col-sm-2 col-form-label">Perihal</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="perihal" name="perihal" value="<?php echo $perihal ?>">
    </div>
  </div>
  <div class="col-12">
    <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
  </div>
</form>

    </form>
  </div>
</div>
        <!-- untuk mengeluarkan data -->
    <div class="card">
  <div class="card-header text-white bg-dark">
    Data Surat Masuk
  </div>
  <div class="card-body">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">No. Surat</th>
                <th scope="col">Tanggal Surat</th>
                <th scope="col">Tanggal Terima</th>
                <th scope="col">Pengirim</th>
                <th scope="col">Perihal</th>
                <th scope="col">Aksi</th>
            </tr>
            <tbody>
                <?php
                $sql2 = "select * from datasurat order by id desc";
                $q2  = mysqli_query($koneksi,$sql2);
                $urut = 1;
                while($r2 = mysqli_fetch_array($q2)){
                    $id             = $r2['id'];
                    $nosurat        = $r2['nosurat'];
                    $tanggalsurat   = $r2['tanggalsurat'];
                    $tanggalterima  = $r2['tanggalterima'];
                    $pengirim       = $r2['pengirim'];
                    $perihal        = $r2['perihal'];
                
                    ?>

                    <tr>
                        <th scope="row"><?php echo $urut++ ?></th>
                        <td scope="row"><?php echo $nosurat ?></td>
                        <td scope="row"><?php echo $tanggalsurat ?></td>
                        <td scope="row"><?php echo $tanggalterima ?></td>
                        <td scope="row"><?php echo $pengirim ?></td>
                        <td scope="row"><?php echo $perihal ?></td>
                        <td scope="row">
                            <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>
                            <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                        
                        </td>




                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </thead>
    </table>
  </div>
</div>
    </div>
</body>
</html>