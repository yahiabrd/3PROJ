<?php

$this->_t = '3PROJ - Analysis';

?>

<p>Analysis <b>(<?= $nb ?> total)<b></p>

<form class="form-inline" method="post" action="<?= URL ?>Monitoring/5">
    <div class="form-group mb-2">
        <input type="text"  class="form-control-plaintext inputM" name="ip" placeholder="Filter IP">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Filter</button>
</form>


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
    foreach($threats as $threat)
    {
      ?>
          <tr>
              <th scope="row"><?= $threat["id"] ?></th>
              <td><?= $threat["attackName"] ?></td>
              <td><?= $threat["attackDate"] ?></td>
              <td><?= $threat["sectionId"] ?></td>
              <td><?= $threat["ip"] ?></td>
          </tr>
      <?php
    }
    ?>
  </tbody>
</table>