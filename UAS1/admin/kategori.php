<?php
require 'ceksession.php';
require_once 'function.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>admink/kategori</title>

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.0/dist/style.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">MENU UTAMA</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
                class="bi bi-list" style="font-size: 1.5rem;"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="bi bi-person-fill"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="login.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-speedometer"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="artikel.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-file-earmark-ruled"></i></i></div>
                            Artikel
                        </a>
                        <a class="nav-link" href="kategori.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-bookmark-check"></i></div>
                            Kategori
                        </a>
                        <a class="nav-link" href="penulis.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-person-fill"></i></div>
                            Penulis
                        </a>
                        <a class="nav-link" href="logout.php">
                            <div class="sb-nav-link-icon"><i class="bi bi-door-closed-fill"></i></div>
                            Logout
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION['email']; ?>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Kategori</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Data Kategori</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-header">
                    <i class="bi bi-bookmark-check"></i>
                    <button class="btn btn-primary" name="btn_artikel_baru" id="btn_artikel_baru" data-bs-toggle="modal" data-bs-target="#modalFormKategori">Kategori Baru</button>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT id_category, category_name, description FROM category ORDER BY id_category DESC";
                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                    $nomor_urut=0;
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $nomor_urut++;
                                        $data_id_kategori=$row['id_category'];
                                        $data_nama=$row['category_name'];
                                        $data_keterangan=$row['description'];
                                    ?>
                                    <tr>
                                        <td><?php echo $nomor_urut; ?></td>
                                        <td><?php echo $data_nama; ?></td>
                                        <td><?php echo $data_keterangan; ?></td>
                                        <td>
                                            <button class="btn btn-warning" name="btn_ubah_kategori" data-bs-toggle="modal" data-bs-target="#modalFormUpdateKategori<?php echo $data_id_kategori; ?>">Ubah</button>
                                            <button  class="btn btn-danger" name="btn_hapus_kategori" data-bs-toggle="modal" data-bs-target="#modalHapusKategori<?php echo $data_id_kategori; ?>">Hapus</button>
                                        </td>
                                    </tr>
<!-- Modal Form ubah kategori -->
                                    <div class="modal fade" data-bs-backdrop="static" id="modalFormUpdateKategori<?php echo $data_id_kategori; ?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Ubah Kategori</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" >
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama Kategori</label>
                                                <input type="text" class="form-control" id="nama" value="<?php echo $data_nama;?>" name="nama">
                                            </div>
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <textarea class="form-control" rows="5" id="keterangan" name="keterangan"><?php echo $data_keterangan;?></textarea>
                                            </div>
                                            <input type="hidden" name="id_kategori_update" value="<?php echo $data_id_kategori;?>">
                                            <div class="mb-3 mt-3 d-flex justify-content-end gap-2">
                                                <button class="btn btn-primary" name="btn_ubah_kategori">Ubah</button>
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                            </div>
                                            </form>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
<!-- MOdoal hapus data kategori -->
                                    <div class="modal fade" id="modalHapusKategori<?php echo $data_id_kategori;?>">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Hapus Kategori</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Modal body -->
                                        <form method="POST">
                                            <div class="modal-body mb-3">
                                                Apakah Kategori dengan nama <?php echo  "<b>".$data_nama ."</b>";?> akan dihapus?
                                            </div>
                                            <div class="mb-3 mt-3 d-flex justify-content-end gap-2 pe-3">
                                                <button  class="btn btn-danger" name="btn_hapus_kategori">Hapus</button>
                                                <input type="hidden" name="id_hapus_kategori" value="<?php echo $data_id_kategori; ?>">
                                                <button class="btn btn-primary" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                                    </div>
                                    </div>
                                    <?php
                                    }
                                    } else {
                                    echo "0 results";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <!-- Chart JS and examples -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>

    <!-- Datatables JS and examples -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.0/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    
<!-- The Modal Form kategori-->
    <div class="modal fade" data-bs-backdrop="static" id="modalFormKategori">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Tambah Kategori</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <form method="POST" >
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="nama" placeholder="Masukkan Nama Kategori..." name="nama">
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" rows="5" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan..."></textarea>
            </div>
            <div class="mb-3 mt-3 d-flex justify-content-end gap-2">
                <button  class="btn btn-primary" name="btn_simpan_kategori">Simpan</button>
                <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
    </body>

</html>