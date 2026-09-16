<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!--========== CSS ==========-->
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/styles_parametres.css">

    <title>Portail Massoutre</title>
</head>

<body>
    <!--========== HEADER ==========-->

    <?php
    include "include.php";
    include "header.php";

    // NAV
    include "menu_final.php";
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../../login.php');
        exit;
    }
    ?>





    <!--========== CONTENTS ==========-->
    <main class="main_parametres">



        <div class="container-fluid">

            <div class="row g-4">

                <!-- Utilisateurs -->
                <div class="col-12 col-md-6 col-lg-2">

                    <a href="/parametres/utilisateurs.php" class="settings-card">

                        <div class="card shadow-sm">
                            <div class="card-body text-center">

                                <i class="bx bx-user fs-1 mb-3"></i>

                                <h5 class="card-title">
                                    Utilisateurs
                                </h5>

                                <p class="card-text">
                                    Gestion des utilisateurs
                                </p>

                            </div>
                        </div>

                    </a>

                </div>


                <!-- Sites -->
                <div class="col-12 col-md-6 col-lg-2">

                    <a href="/parametres/sites.php" class="settings-card">

                        <div class="card shadow-sm">
                            <div class="card-body text-center">

                                <i class="bx bx-buildings fs-1 mb-3"></i>

                                <h5 class="card-title">
                                    Sites
                                </h5>

                                <p class="card-text">
                                    Gestion des sites
                                </p>

                            </div>
                        </div>

                    </a>

                </div>


                <!-- Card 3 -->
                <div class="col-12 col-md-6 col-lg-2">

                    <a href="#" class="settings-card">

                        <div class="card shadow-sm">
                            <div class="card-body text-center">

                                <i class="bx bx-cog fs-1 mb-3"></i>

                                <h5 class="card-title">
                                    Card 3
                                </h5>

                                <p class="card-text">
                                    Description
                                </p>

                            </div>
                        </div>

                    </a>

                </div>


                <!-- Card 4 -->
                <div class="col-12 col-md-6 col-lg-2">

                    <a href="#" class="settings-card">

                        <div class="card shadow-sm">
                            <div class="card-body text-center">

                                <i class="bx bx-cog fs-1 mb-3"></i>

                                <h5 class="card-title">
                                    Card 4
                                </h5>

                                <p class="card-text">
                                    Description
                                </p>

                            </div>
                        </div>

                    </a>

                </div>


                <!-- Card 5 -->
                <div class="col-12 col-md-6 col-lg-2">

                    <a href="#" class="settings-card">

                        <div class="card shadow-sm">
                            <div class="card-body text-center">

                                <i class="bx bx-cog fs-1 mb-3"></i>

                                <h5 class="card-title">
                                    Card 5
                                </h5>

                                <p class="card-text">
                                    Description
                                </p>

                            </div>
                        </div>

                    </a>

                </div>


                <!-- Card 6 -->
                <div class="col-12 col-md-6 col-lg-2">

                    <a href="#" class="settings-card">

                        <div class="card shadow-sm">
                            <div class="card-body text-center">

                                <i class="bx bx-cog fs-1 mb-3"></i>

                                <h5 class="card-title">
                                    Card 6
                                </h5>

                                <p class="card-text">
                                    Description
                                </p>

                            </div>
                        </div>

                    </a>

                </div>

            </div>

        </div>

    </main>

    <!--========== MAIN JS ==========-->
    <script src="assets/js/main.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>