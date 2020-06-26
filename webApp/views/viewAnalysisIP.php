<?php

$this->_t = '3PROJ - Analysis';

?>

<p>Analysis By IP :  <b><?= $ip ?> (<?= $nb ?> total)</b></p>

<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Attack name</th>
      <th scope="col">Attack date</th>
      <th scope="col">Section ID</th>
      <th scope="col">Ip attacker</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach($filters as $filter)
    {
        ?>
            <tr>
                <th scope="row"><?= $filter["id"] ?></th>
                <td><?= $filter["attackName"] ?></td>
                <td><?= $filter["attackDate"] ?></td>
                <td><?= $filter["sectionId"] ?></td>
                <td><?= $filter["ip"] ?></td>
            </tr>
        <?php
    }
    ?>
  </tbody>
</table>