<?php
$privileges = $privileges;
?>
<div class="container">
    <div class="card col-md-8 mx-auto mt-4">
        <div class="card-body">
            <h5 class="card-title">Modifier utilisateur</h5>
            <form action="/user/add" method="POST" novalidate>
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
                <div class="row mx-auto">
                    <button type="submit" class="btn btn-info">Ajouter</button>
                    <a href="/user/liste" class="mx-1 btn btn-outline-info">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>