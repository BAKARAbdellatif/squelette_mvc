<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card shadow-lg">
                    <div class="card-header bg-info text-white">
                        <h4 class="text-center">Se connecter</h4>
                    </div>
                    <div class="card-body">
                        <form action="/user/connexion" method="POST">
                            <?php
                            $invalid_email = "";
                            $old_email = "";
                            $error_email = "";
                            $invalid_password = "";
                            $old_password = "";
                            $error_password = "";
                            if (isset($request['email']['error'])) {
                                $invalid_email = "is-invalid";
                                $old_email = $request['email']['value'];
                                $error_email = $request['email']['error'];
                            }
                            if (isset($request['password']['error'])) {
                                $invalid_password = "is-invalid";
                                $old_password = $request['password']['value'];
                                $error_password = $request['password']['error'];
                            }

                            if (isset($error)) {
                                echo "<span class='text-danger'>$error</span>";
                            }
                            ?>

                            <div class="form-group">
                                <label for="username">Email</label>
                                <input type="text" class="form-control <?php echo $invalid_email; ?>" id="email" name="email" placeholder="Entrez votre adresse e-mail" value="<?php echo $old_email; ?>">
                                <span class="text-danger"><?php echo $error_email; ?></span>
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" class="form-control <?php echo $invalid_password; ?>" id="password" name="password" placeholder="Entrez votre mot de passe">
                                <span class="text-danger"><?php echo $error_password; ?></span>
                            </div>
                            <button type="submit" class="btn btn-info btn-block">Connexion</button>
                            <button type="button" onclick="inscription()" class="btn btn-light btn-block">Inscription</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
<script>
    function inscription() {
        alert('hello')
        window.location.href = "/user/create";
    }
</script>

</html>