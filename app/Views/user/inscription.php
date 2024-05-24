<?php
$privileges = $privileges;
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="card col-md-8 mx-auto mt-4">
            <div class="card-header text-white font-weight-bold bg-info">
                Vérification du service E-note
            </div>
            <div class="card-body">
                <h5 class="card-title">Inscription</h5>
                <form action="/user/inscrire" method="POST" novalidate>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Nom</label>
                        <div class="col-sm-9">
                            <?php
                            $invalid_nom = "";
                            $error_nom = "";
                            if (isset($request['nom']['error']) and $request['nom']['error'] != "") {
                                $invalid_nom = "is-invalid";
                                $error_nom = $request['nom']['error'];
                            }
                            $nom = (isset($request['nom']['value'])) ? $request['nom']['value'] : ""
                            ?>
                            <input type="text" name="nom" class="form-control <?php echo $invalid_nom; ?>" id="nom" placeholder="Nom" value="<?php echo $nom; ?>">
                            <span class="text-danger"><?php echo $error_nom; ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Prénom</label>
                        <div class="col-sm-9">
                            <?php
                            $invalid_prenom = "";
                            $error_prenom = "";
                            if (isset($request['prenom']['error']) and $request['prenom']['error'] != "") {
                                $invalid_prenom = "is-invalid";
                                $error_prenom = $request['prenom']['error'];
                            }
                            $prenom = (isset($request['prenom']['value'])) ? $request['prenom']['value'] : ""
                            ?>
                            <input type="text" name="prenom" class="form-control <?php echo $invalid_prenom; ?>" id="prenom" placeholder="Prénom" value="<?php echo $prenom; ?>">
                            <span class="text-danger"><?php echo $error_prenom; ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <?php
                            $invalid_email = "";
                            $error_email = "";
                            if (isset($request['email']['error']) and $request['email']['error'] != "") {
                                $invalid_email = "is-invalid";
                                $error_email = $request['email']['error'];
                            }
                            $email = (isset($request['email']['value'])) ? $request['email']['value'] : ""
                            ?>
                            <input type="email" name="email" class="form-control <?php echo $invalid_email; ?>" id="inputEmail" placeholder="Email" value="<?php echo $email; ?>">
                            <span class="text-danger"><?php echo $error_email; ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Mot de passe</label>
                        <div class="col-sm-9">
                            <?php
                            $invalid_password = "";
                            $error_password = "";
                            if (isset($request['password']['error']) and $request['password']['error'] != "") {
                                $invalid_password = "is-invalid";
                                $error_password = $request['password']['error'];
                            }
                            $password = (isset($request['password']['value'])) ? $request['password']['value'] : ""
                            ?>
                            <input type="password" name="password" class="form-control <?php echo $invalid_password; ?>" id="password" placeholder="Mot de passe" value="<?php echo $password; ?>">
                            <span class="text-danger"><?php echo $error_password; ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Confirmation de mot de passe</label>
                        <div class="col-sm-9">
                            <?php
                            $invalid_password_confirm = "";
                            $error_password_confirm = "";
                            if (isset($request['password_confirm']['error']) and $request['password_confirm']['error'] != "") {
                                $invalid_password_confirm = "is-invalid";
                                $error_password_confirm = $request['password_confirm']['error'];
                            }
                            $password_confirm = (isset($request['password_confirm']['value'])) ? $request['password_confirm']['value'] : ""
                            ?>
                            <input type="password" name="password_confirm" class="form-control <?php echo $invalid_password_confirm; ?>" id="password_confirm" placeholder="Confirmation de mot de passe" value="<?php echo $password_confirm; ?>">
                            <span class="text-danger"><?php echo $error_password_confirm; ?></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="mx-auto btn btn-info">S'inscrire</button>
                    </div>
                    <div class="form-group row">
                        <a href="/user/index" class="mx-auto btn btn-outline-info">Annuler</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>

</html>