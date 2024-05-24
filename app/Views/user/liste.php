<?php
$privileges = $privileges;
?>
<script>
  function remove(uuid) {
    if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
      $.ajax({
        method: "POST",
        url: "/user/delete",
        data: {
          'uuid': uuid
        },
      }).done(function(response) {
        response = JSON.parse(response);
        if (response.status == "success") {
          $("#".uuid).remove();
        } else {
          alert("Une erreur s'est produite lors de la suppression de l'utilisateur.");
        }
      });
    }
  }
</script>
<div class="container">
  <div class="row">
    <div class="col-md-11">
      <h4>Utilisateurs</h4>
    </div>
    <div class="col-md-1">
      <a title="Nouveau utilisateur" href="/user/create" class="btn btn-outline-info"><i class="fa fa-plus"></i></a>
    </div>
  </div>
  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Nom</th>
        <th scope="col">Prénom</th>
        <th scope="col">Email</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($users as $user) :
      ?>
        <tr id="<?php echo $user['uuid']; ?>">
          <td><?php echo $user['nom']; ?></th>
          <td><?php echo $user['prenom']; ?></td>
          <td><?php echo $user['email']; ?></td>
          <td>
            <a href="/user/update?id=<?php echo $user['uuid']; ?>" title="Modifier utilisateur" class="text-info"><i class="fa fa-lg fa-edit"></i></a>
            <a onclick="remove('<?php echo $user['uuid']; ?>')" title="Supprimer utilisateur" class="text-info"><i class="fa fa-lg fa-trash"></i></a>
          </td>
        </tr>
      <?php
      endforeach;
      ?>
    </tbody>
  </table>
  <?php echo $pagination; ?>
</div>