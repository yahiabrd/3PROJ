<?php

$this->_t = '3PROJ - Users';

?>

<p>Users Data <b>(<?= $nb ?> total)<b></p>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Firstname</th>
      <th scope="col">Lastname</th>
      <th scope="col">Nb documents</th>
      <th scope="col">Documents</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach($users as $user)
    {
        ?>
            <tr>
                <th scope="row"><?= $user['id'] ?></th>
                <td><?= $user['firstName'] ?></td>
                <td><?= $user['lastName'] ?></td>
                <td><?= $user['nbDocs'] ?></td>
                <td>
                  <?php
                    foreach($user['documents'] as $doc)
                    {
                      echo $doc. '<br>';
                    }
                  ?>
                </td>
            </tr>
        <?php
    }
    ?>
  </tbody>
</table>