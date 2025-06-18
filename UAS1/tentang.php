
<?php
require 'admin/ceksession.php';
require_once  'admin/function.php';
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
            <div class="row justify-content-center">
                <!-- Blog entries-->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="small text-muted">@WorldTravel</div>
                            <h2 class="card-title">Tentang</h2>
                            <p class="card-text">
                                <p>Blog ini hadir sebagai wadah sederhana namun bermakna untuk berbagi cerita dan pengalaman perjalanan dari berbagai sudut dunia. Kami percaya bahwa setiap perjalanan membawa kisah unik yang layak untuk diceritakan mulai dari keindahan alam, keunikan budaya, hingga momen-momen tak terlupakan yang ditemukan saat menjelajah.</p>
                                <p>Lewat tulisan-tulisan di blog ini, kami ingin menginspirasi pembaca untuk berani melangkah keluar, mengeksplorasi tempat-tempat baru, dan merasakan langsung keajaiban dunia. Tidak hanya berfokus pada destinasi populer, kami juga menyajikan panduan praktis, tips perjalanan, serta kisah tentang tempat-tempat tersembunyi yang jarang diketahui.</p>
                                <p>Tujuan kami sederhana: menjadi teman perjalanan digital yang selalu memberikan informasi, inspirasi, dan motivasi agar setiap pembaca bisa merencanakan petualangan mereka sendiri dengan percaya diri dan penuh semangat.</p>
                                <p>Selamat membaca dan semoga cerita-cerita di blog ini bisa membawa Anda ke perjalanan berikutnya, ke tempat-tempat indah dan pengalaman yang luar biasa.</p>
                            </p>
                            </div>
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
