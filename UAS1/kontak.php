
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
            html, body {
                height: 100%;
                margin: 0;
                }
                body {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                }
                .container {
                flex: 1;
                }
                .tentang {
                text-align: justify;
                }
                footer{
                    height: 20px;
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
                            <h2 class="card-title">Kontak</h2>
                            <p class="card-text">
                                <li>Email: <a href="#">WorldTravel@example.com</a></li>
                                <li>No WA: <a href="#">+62 852-1519-6211</a></li>
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
