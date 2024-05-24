<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script> <!-- Include moment.js with locales -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>


    <style>
        body {
            margin: 0;
            /* Supprime la marge par défaut du corps */
            padding: 0;
            font-family: "Lato", sans-serif;
            background-color: #f5f5f5;
            /* Ajoute une couleur de fond à la page */
        }

        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background-color: #17a2b8;
            /* Changez la couleur de fond de votre header selon votre préférence */
            z-index: 999;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .sidenav {
            height: 100%;
            width: 0;
            position: fixed;
            z-index: 1;
            top: 55px;
            /* Ajustez la position en fonction de la hauteur de votre header */
            left: 0;
            background-color: #111;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Ajoutez cette ligne pour l'ombre */
        }

        .sidenav a {
            padding: 0px 0px 0px 10px;
            text-decoration: none;
            font-size: 20px;
            color: #f0f0f0;
            display: block;
            transition: 0.3s;
        }

        .sidenav a:hover {
            color: lightsteelblue;
        }


        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }

            .sidenav a {
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-info navbar-dark">
            <a class="navbar-brand" href="#">Service Enote</a>
            <div class="ml-auto"> <!-- Utilisation de ml-auto pour déplacer le contenu à droite -->
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Bonjour, <?php echo $_SESSION['prenom']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="/user/profil">Mon profil</a>
                            <a class="dropdown-item" href="/user/deconnexion">Se déconnecter</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div id="mySidenav" class="sidenav bg-info" style="width: 200px;">
        <?php
        if (in_array("ADMIN_READ", $privileges)) {
            echo '<a href="/admin/index"><i class="fa fa-xs fa-link"></i> Espace Admin</a>';
        }
        if (in_array("PRISE_EN_CHARGE_WRITE", $privileges)) {
            echo '<a href="/priseencharge/index"><i class="fa fa-xs fa-link"></i> Prise en charge</a>';
        }
        if (in_array("REGISSEUR_READ", $privileges)) {
            echo '<a href="/regisseur/index"><i class="fa fa-xs fa-link"></i> Régisseur</a>';
        }
        if (in_array("ETABLISSEMENT_READ", $privileges)) {
            echo '<a href="/Etablissement/index"><i class="fa fa-xs fa-link"></i> Etablissement</a>';
        }
        if (in_array("CONTROLE_READ", $privileges)) {
            echo '<a href="/controle/index"><i class="fa fa-xs fa-link"></i> Controle</a>';
        }
        if (in_array("VALIDATION_READ", $privileges)) {
            echo '<a href="/validation/index"><i class="fa fa-xs fa-link"></i> Validation</a>';
        }
        if (in_array("BO_READ", $privileges)) {
            echo '<a href="/bo/index"><i class="fa fa-xs fa-link"></i> BO</a>';
        }
        if (in_array("REMISE_READ", $privileges)) {
            echo '<a href="/remise/index"><i class="fa fa-xs fa-link"></i> Remise</a>';
        }
        if (in_array("NOTE_READ", $privileges)) {
            echo '<a href="/note/index"><i class="fa fa-xs fa-link"></i> Notes traitées</a>';
        }
        ?>
    </div>
    <span style="font-size:30px;cursor:pointer" class="text-info" title="Cliquer pour développer le menu" onclick="openNav()">&#9776;</span>
    <div id="main" class="content" style="margin-left: 200px; padding-top: 30px;">
        <?php include_once(__DIR__ . $path); ?>

        <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Détails de la note</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div id="modalBody" class="modal-body">

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Fermer</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        /* Set the width of the side navigation to 250px and the left margin of the page content to 250px and add a black background color to body */
        function openNav() {
            document.getElementById("mySidenav").style.width = "200px";
            document.getElementById("main").style.marginLeft = "200px";
            //document.body.style.backgroundColor = "rgba(0,0,0,0.4)";
        }

        /* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
            document.body.style.backgroundColor = "white";
        }
    </script>
</body>


</html>