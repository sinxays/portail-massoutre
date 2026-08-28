<!DOCTYPE html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--========== BOX ICONS ==========-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <!--========== CSS ==========-->
    <link rel="stylesheet" href="assets/css/styles.css">

    <title>Portail Massoutre</title>
</head>

<body>
    <!--========== HEADER ==========-->

    <?php
    session_start();

    include "include.php";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);

        if ($login === '' || $password === '') {
            $error = "Veuillez renseigner tous les champs";
        }
        //connexion
        else {
            $user = get_user($login, $password);
            // Pour le moment, juste pour tester
            if ($user) {

                echo "Login : " . htmlspecialchars($user['login']);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role_id'] = $user['role_id'];
                $_SESSION['prenom'] = $user['prenom'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['role_libelle'] = $user['libelle_role'];
                // Connexion réussie
                header('Location: index.php');
                exit;

            } else {
                $login_error = "Login ou mot de passe incorrect";
                echo "<p class='error_msg' id='login_error'>" . $login_error . "</p>";
            }


        }
    }

    include "header.php";

    // NAV
    // include "right_menubar.php";
    include "menu_final.php";
    ?>





    <!--========== CONTENTS ==========-->
    <main>



        <div class="login-container">
            <div class="login-box">

                <div class="login-header">
                    <div class="login-icon">🔐</div>
                    <h1>Connexion</h1>
                </div>

                <form action="login.php" method="POST">

                    <div class="login-field">
                        <label for="login">Login</label>
                        <input type="login" id="login" name="login" required autocomplete="username">
                    </div>

                    <div class="login-field">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required autocomplete="current-password">
                    </div>

                    <div class="login-options">
                        <a href="mot-de-passe-oublie.php">
                            Mot de passe oublié ?
                        </a>
                    </div>

                    <button type="submit" class="login-button">
                        Se connecter
                    </button>

                </form>

            </div>
        </div>

    </main>

    <!--========== MAIN JS ==========-->
    <script src="assets/js/main.js"></script>
</body>

</html>