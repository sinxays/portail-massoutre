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

    include "../include.php";

    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }

    include "../header.php";
    // NAV  
    // include "../../right_menubar.php";
    include "../menu_final.php";
    ?>



    <?php

    // Sécurité : seuls les admins peuvent accéder à cette page
    
    // echo $_SESSION['role_id'];
    if (!hasRole([1])) {
        header("Location: ../index.php");
        exit;
    }

    $users = get_all_users();

    ?>

    <!DOCTYPE html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Utilisateurs - Portail Massoutre</title>

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Boxicons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

        <!-- CSS -->
        <link rel="stylesheet" href="/assets/css/styles.css">
    </head>

    <body>

        <?php

        include "../header.php";
        include "../menu_final.php";

        ?>

        <main>

            <div class="container-fluid px-4 py-4">

                <!-- HEADER DE LA PAGE -->
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h2 class="mb-1">
                            <i class="bx bx-user"></i>
                            Utilisateurs
                        </h2>

                        <p class="text-muted mb-0">
                            Gestion des utilisateurs du portail
                        </p>
                    </div>

                    <a href="ajouter_utilisateur.php" class="btn btn-primary">
                        <i class="bx bx-plus"></i>
                        Ajouter un utilisateur
                    </a>

                </div>


                <!-- CARD TABLEAU -->
                <div class="card shadow-sm border-0">

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>
                                        <th class="px-4">Utilisateur</th>
                                        <th>Login</th>
                                        <th>Rôle</th>
                                        <th>Statut</th>
                                        <th class="text-end px-4">Actions</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php if (empty($users)): ?>

                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                Aucun utilisateur trouvé.
                                            </td>
                                        </tr>

                                    <?php else: ?>

                                        <?php foreach ($users as $user): ?>

                                            <tr>

                                                <!-- NOM / PRENOM -->
                                                <td class="px-4">

                                                    <div class="d-flex align-items-center">

                                                        <div class="rounded-circle bg-primary text-white
                                                        d-flex align-items-center justify-content-center me-3"
                                                            style="width: 42px; height: 42px;">

                                                            <?= strtoupper(substr($user['id'], 0, 1)) ?>

                                                        </div>

                                                        <div>

                                                            <div class="fw-semibold">
                                                                <?= htmlspecialchars($user['prenom']) ?>
                                                                <?= htmlspecialchars($user['nom']) ?>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </td>


                                                <!-- LOGIN -->
                                                <td>

                                                    <span class="text-muted">
                                                        <?= htmlspecialchars($user['login']) ?>
                                                    </span>

                                                </td>


                                                <!-- ROLE -->
                                                <td>

                                                    <?php

                                                    switch ($user['role_id']) {

                                                        case 1:
                                                            $role = "Administrateur";
                                                            $roleClass = "bg-danger";
                                                            break;

                                                        case 2:
                                                            $role = "Utilisateur";
                                                            $roleClass = "bg-warning text-dark";
                                                            break;

                                                        case 3:
                                                        case 4:
                                                        case 5:
                                                            $role = "Manager";
                                                            $roleClass = "bg-primary";
                                                            break;
                                                        default:
                                                            $role = "Inconnu";
                                                            $roleClass = "bg-secondary";

                                                    }

                                                    ?>

                                                    <span class="badge <?= $roleClass ?>">
                                                        <?= $user['libelle_role'] ?>
                                                    </span>

                                                </td>


                                                <!-- STATUT -->
                                                <td>

                                                    <?php if ($user['actif'] && $user['actif'] == 1): ?>

                                                        <span class="badge bg-success">
                                                            <i class="bx bx-check"></i>
                                                            Actif
                                                        </span>

                                                    <?php else: ?>

                                                        <span class="badge bg-secondary">
                                                            <i class="bx bx-x"></i>
                                                            Inactif
                                                        </span>

                                                    <?php endif; ?>

                                                </td>


                                                <!-- ACTIONS -->
                                                <td class="text-end px-4">

                                                    <a href="modifier_utilisateur.php?id=<?= $user['id'] ?>"
                                                        class="btn btn-sm btn-outline-primary" title="Modifier">

                                                        <i class="bx bx-edit"></i>

                                                    </a>


                                                    <a href="supprimer.php?id=<?= $user['id'] ?>"
                                                        class="btn btn-sm btn-outline-danger" title="Supprimer"
                                                        onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">

                                                        <i class="bx bx-trash"></i>

                                                    </a>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </main>


        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Main JS -->
        <script src="/assets/js/main.js"></script>

    </body>

    </html>