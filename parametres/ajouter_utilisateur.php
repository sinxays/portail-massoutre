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
    use App\Connection;

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

    $pdo = Connection::getPDO();

    // ============================================================ // RÉCUPÉRATION DES RÔLES // ============================================================ 
    $request_roles = $pdo->query(" SELECT id, libelle_role FROM roles ");
    $roles = $request_roles->fetchAll(PDO::FETCH_ASSOC);
    // ============================================================ // TRAITEMENT DU FORMULAIRE // ============================================================ 
    $error = '';
    $success = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';
        $role_id = $_POST['role_id'] ?? '';
        $actif = isset($_POST['actif']) ? 1 : 0;
        // -------------------------------------------------------- // VALIDATION // -------------------------------------------------------- 
        if ($nom === '' || $prenom === '' || $email === '' || $login === '') {
            $error = "Veuillez renseigner tous les champs obligatoires.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "L'adresse email n'est pas valide.";
        } elseif (!ctype_digit($role_id)) {
            $error = "Le rôle sélectionné est invalide.";
        } else {
            // Vérification que le rôle existe réellement 
            $check_role = $pdo->prepare(" SELECT id FROM roles WHERE id = :role_id ");
            $check_role->execute(['role_id' => $role_id]);
            if (!$check_role->fetch()) {
                $error = "Le rôle sélectionné n'existe pas.";
            } else {
                // ------------------------------------------------ // VÉRIFICATION LOGIN DÉJÀ UTILISÉ // ------------------------------------------------ 
                $check_login = $pdo->prepare(" SELECT id FROM users WHERE login = :login AND id != :id ");
                $check_login->execute(['login' => $login, 'id' => $user_id]);
                if ($check_login->fetch()) {
                    $error = "Ce login est déjà utilisé par un autre utilisateur.";
                } else {
                    // ------------------------------------------------ // MODIFICATION // ------------------------------------------------ 
                    if ($password !== '') {
                        // Nouveau mot de passe fourni 
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);
                        $update = $pdo->prepare(" UPDATE users SET nom = :nom, prenom = :prenom, email = :email, login = :login, password_hash = :password_hash, role_id = :role_id, actif = :actif WHERE id = :id ");
                        $update = $pdo->prepare(" INSERT INTO users (nom, prenom,email,login,password_hash,role_id,actif) VALUES (:nom,:prenom,:email,:login,:password_hash,:role_id)   SET nom = :nom, prenom = :prenom, email = :, login = :login, password_hash = :, role_id = :role_id, actif = :actif WHERE id = :id ");
                        $update->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'login' => $login, 'password_hash' => $password_hash, 'role_id' => $role_id, 'actif' => $actif, 'id' => $user_id]);
                    } else {
                        // Pas de nouveau mot de passe : // on conserve l'ancien 
                        $update = $pdo->prepare(" UPDATE users SET nom = :nom, prenom = :prenom, email = :email, login = :login, role_id = :role_id, actif = :actif WHERE id = :id ");
                        $update->execute(['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'login' => $login, 'role_id' => $role_id, 'actif' => $actif, 'id' => $user_id]);
                    }
                    // ------------------------------------------------ // SUCCÈS // ------------------------------------------------ 
                    $success = "L'utilisateur a été modifié avec succès.";
                    // On recharge les données affichées 
                    $request = $pdo->prepare(" SELECT id, nom, prenom, email, login, password_hash, role_id, actif FROM users WHERE id = :id ");
                    $request->execute(['id' => $user_id]);
                    $user = $request->fetch(PDO::FETCH_ASSOC);
                }
            }
        }
    }

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

            <div class="container-fluid px-4 py-4"> <!-- ================================================= -->
                <!-- EN-TÊTE --> <!-- ================================================= -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-1"> <i class="bx bx-user"></i> Ajouter un utilisateur </h2>
                    </div> <a href="utilisateurs.php" class="btn btn-outline-secondary"> <i
                            class="bx bx-arrow-back"></i> Retour </a>
                </div> <!-- ================================================= --> <!-- MESSAGES -->
                <!-- ================================================= --> <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert"> <i
                            class="bx bx-error-circle"></i> <?= htmlspecialchars($error) ?> <button type="button"
                            class="btn-close" data-bs-dismiss="alert"> </button> </div> <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert"> <i
                            class="bx bx-check-circle"></i> <?= htmlspecialchars($success) ?> <button type="button"
                            class="btn-close" data-bs-dismiss="alert"> </button> </div> <?php endif; ?>
                <!-- ================================================= --> <!-- FORMULAIRE -->
                <!-- ================================================= -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <form method="POST">
                            <div class="row g-4">
                                <!-- =============================== --> <!-- NOM -->
                                <!-- =============================== -->
                                <div class="col-md-6"> <label for="nom" class="form-label"> Nom </label> <input
                                        type="text" class="form-control" id="nom" name="nom" value="" required> </div>
                                <!-- =============================== --> <!-- PRÉNOM -->
                                <!-- =============================== -->
                                <div class="col-md-6"> <label for="prenom" class="form-label"> Prénom </label> <input
                                        type="text" class="form-control" id="prenom" name="prenom" value="" required>
                                </div>
                                <!-- =============================== --> <!-- EMAIL -->
                                <!-- =============================== -->
                                <div class="col-md-6"> <label for="email" class="form-label"> Email </label> <input
                                        type="email" class="form-control" id="email" name="email" value="" required>
                                </div>
                                <!-- =============================== --> <!-- LOGIN -->
                                <!-- =============================== -->
                                <div class="col-md-6"> <label for="login" class="form-label"> Login </label> <input
                                        type="text" class="form-control" id="login" name="login" value="" required>
                                </div>
                                <!-- =============================== --> <!-- PASSWORD -->
                                <!-- =============================== -->
                                <div class="col-md-12"> <label for="password" class="form-label"> Nouveau mot de passe
                                    </label> <input type="password" class="form-control" id="password" name="password"
                                        autocomplete="new-password">
                                    <div class="form-text"> Laissez vide pour conserver le mot de passe actuel. </div>
                                </div>
                                <!-- =============================== --> <!-- RÔLE -->
                                <!-- =============================== -->
                                <div class="col-md-6"> <label for="role_id" class="form-label"> Rôle </label> <select
                                        class="form-select" id="role_id" name="role_id" required>
                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= htmlspecialchars($role['id']) ?>">
                                                <?= htmlspecialchars($role['libelle_role']) ?>
                                            </option> <?php endforeach; ?>
                                    </select> </div>
                                <!-- =============================== --> <!-- ACTIF -->
                                <!-- =============================== -->
                                <div class="col-md-6"> <label class="form-label"> Statut </label>
                                    <div class="form-check form-switch mt-2"> <input class="form-check-input"
                                            type="checkbox" role="switch" id="actif" name="actif"> <label
                                            class="form-check-label" for="actif"> Utilisateur
                                            actif </label> </div>
                                </div>
                            </div>
                            <!-- ================================================= --> <!-- BOUTONS -->
                            <!-- ================================================= -->
                            <hr class="my-4">
                            <div class="d-flex justify-content-end gap-2"> <a href="utilisateurs.php"
                                    class="btn btn-outline-secondary"> Annuler </a> <button type="submit"
                                    class="btn btn-primary"> <i class="bx bx-save"></i> Créer utilisateur
                                </button> </div>
                        </form>
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