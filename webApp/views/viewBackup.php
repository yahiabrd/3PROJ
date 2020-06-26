<?php

$this->_t = '3PROJ - Analysis';

?>

<p>Backup History <b>(<?= $nb ?> total)<b></p>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Date</th>
      <th scope="col">Comment</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach($backups as $backup)
    {
        ?>
            <tr>
                <th scope="row"><?= $backup['id'] ?></th>
                <td><?= $backup['date'] ?></td>
                <td><?= $backup['comment'] ?></td>
            </tr>
        <?php
    }
    ?>
  </tbody>
</table>