<?php
require  'admin/function.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Home - World Travel</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <style type="text/css">
            .tentang{
                text-align:justify;
            }
        </style>
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">World Travel</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                        <li class="nav-item"><a class="nav-link" href="tentang.php">Tentang</a></li>
                        <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            <div class="container">
                <div class="text-center my-5">
                    <h1 class="fw-bolder">Travel around the World</h1>
                    <p class="lead mb-0">A simple blog to share stories from every corner of the world.</p>
                </div>
            </div>
        </header>
<!-- Page content-->
        <div class="container">
            <div class="row">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <!-- Featured blog post-->
                    <?php 
                    $id_kategori_terpilih=$_GET['id_kategori'];

                                        $sql = "SELECT 
                                            k.id_kontributor,
                                            k.id_category,
                                            a.date,
                                            a.title,
                                            a.content,
                                            au.author_name,
                                            c.category_name,
                                            c.id_category,
                                            a.picture
                                        FROM kontributor k
                                        JOIN article a ON k.id_article = a.id_article
                                        JOIN author au ON k.id_author = au.id_author
                                        JOIN category c ON k.id_category = c.id_category
                                        WHERE k.id_category='$id_kategori_terpilih'
                                        ORDER BY k.id_category DESC";
                                        $result = mysqli_query($conn, $sql);
                                        $nomor_urut=0;
                                        if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            $nomor_urut ++;
                                            $data_tanggal=$row['date'];
                                            $data_judul=$row['title'];
                                            $data_kategori=$row['category_name'];
                                            $data_penulis=$row['author_name'];
                                            $data_id_kategori=$row['id_category'];
                                            $data_idkategori=$row['id_category'];
                                            $data_gambar=$row['picture'];
                                            $data_isi=$row['content'];
                                            $data_id_kontributor=$row['id_kontributor'];
                                            $data_potongan_artikel=potong_artikel($data_isi,200);
                                        ?>
                    <div class="card mb-4">
                        <a href="#!"><img class="card-img-top" src="admin/<?php echo $data_gambar?>" alt="..." /></a>
                        <div class="card-body">
                            <div class="small text-muted"><?php echo $data_tanggal?></div>
                            <h2 class="card-title"><?php echo $data_judul?></h2>
                            <p class="card-text"><?php echo $data_potongan_artikel?></p>
                            <a class="btn btn-primary" href="detail.php?id_kontributor=<?php echo $data_id_kontributor; ?>&id_kategori=<?php echo $data_id_kategori; ?>">Baca Selengkapnya →</a>
                        </div>
                    </div>
                    <?php
                                        }}
                    ?>
                </div>
                <!-- Side widgets-->
                <div class="col-lg-4">
                    <!-- Search widget-->
                    <div class="card mb-4">
                        <div class="card-header">Pencarian</div>
                        <div class="card-body">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="masukkan kata kunci..." aria-label="Enter search term..." aria-describedby="button-search" />
                                <button class="btn btn-primary" id="button-search" type="button">Cari</button>
                            </div>
                        </div>
                    </div>
<!-- kategori-->
                    <div class="card mb-4">
                        <div class="card-header">Kategori</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="list-group">
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
                                        <a href="kategori.php?id_kategori=<?php echo $data_id_kategori;?>" class="list-group-item list-group-item-action"><?php echo $data_nama; ?></a>
                                        <?php }}?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Side widget-->
                    <div class="card mb-4">
                        <div class="card-header">Tentang</div>
                        <div class="card-body tentang">Sebuah blog sederhana untuk berbagi cerita perjalanan dari setiap sudut dunia.</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <?php
            date_default_timezone_set("Asia/Jakarta");
            ?>
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; World Travel <?php echo date("Y") ?></p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
