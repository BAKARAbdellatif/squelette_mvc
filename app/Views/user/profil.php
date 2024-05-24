<?php
$privileges = $privileges;
?>
<script>
    $(document).ready(function() {
        $("#old_password").blur(function() {
            old_password = $("#old_password").val();
            if (old_password) {
                $.ajax({
                    method: "POST",
                    url: "/user/isOldPassword",
                    data: {
                        "old_password": old_password
                    }
                }).done(function(response) {
                    data = JSON.parse(response);
                    if (data.invalid) {
                        $("#old_password").removeClass("is-valid");
                        $("#old_password").addClass("is-invalid");
                        $("#valid_old_password").html("");
                        $("#invalid_old_password").html(data.message)
                    }
                    if (data.valid) {
                        $("#old_password").removeClass("is-invalid");
                        $("#old_password").addClass("is-valid");
                        $("#invalid_old_password").html("")
                        $("#valid_old_password").html(data.message)
                    }
                });
            } else {
                $("#old_password").removeClass("is-valid");
                $("#old_password").addClass("is-invalid");
                $("#valid_old_password").html("");
                $("#invalid_old_password").html("Ce champ est obligatoire");
            }
        });

        $("#password1").keyup(function() {
            password = $("#password1").val();
            if (password.length >= 6) {
                $("#password2").removeAttr("disabled");
            } else {
                $("#password2").prop("disabled", true);
            }
        });

        $("#password2").keyup(function() {
            password = $("#password1").val();
            password2 = $("#password2").val();
            if (password == password2) {
                $("#password1, #password2").addClass('is-valid');
                $("#password1, #password2").removeClass('is-invalid');
                $("#validBtn").removeAttr("disabled");
            } else {
                $("#password1, #password2").removeClass('is-valid');
                $("#password1, #password2").addClass('is-invalid');
                $("#validBtn").prop("disabled", true);
            }
        });
    })

    function updatePassword() {
        password1 = $("#password1").val();
        password2 = $("#password2").val();
        old_password = $("#old_password").val();
        if ($("#old_password").hasClass("is-valid") && password1 == password2) {
            $.ajax({
                method: "POST",
                url: "/user/updatePassword",
                data: {
                    "password1": password1,
                    "password2": password2,
                    "old_password": old_password
                }
            }).done(function(response) {
                if (response) {
                    alert("Mot de passe modifié avec succés");
                    location.reload();
                } else {
                    alert("Formulaire invalide");
                }
            });
        } else {
            alert("Formulaire invalide");
        }
    }
</script>
<div class="container">
    <div class="row col-md-8 mx-auto">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th scope="row">Nom</th>
                    <td><?php echo $user['nom'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Prénom</th>
                    <td><?php echo $user['prenom'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Email</th>
                    <td><?php echo $user['email'] ?></td>
                </tr>
                <tr>
                    <th scope="row">Profil</th>
                    <td><?php echo $user['libelle'] ?></td>
                </tr>
                <tr>
                    <th colspan="2">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Modifier mon mot de passe
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-5">Ancien mot de passe</div>
                                            <div class="col-md-7">
                                                <input type="password" class="form-control" id="old_password" name="old_password">
                                                <span class="text-danger" id="invalid_old_password"></span>
                                                <span class="text-success" id="valid_old_password"></span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">Nouveau mot de passe</div>
                                            <div class="col-md-7">
                                                <input type="password" class="form-control" id="password1" name="password1">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">Confirmation mot de passe</div>
                                            <div class="col-md-7">
                                                <input type="password" class="form-control" id="password2" name="password2" disabled>
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-info btn-block mt-2" id="validBtn" onclick="updatePassword()" disabled>Valider</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
            </tbody>
        </table>
    </div>
</div>