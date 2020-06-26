<?php
//special page because I'm using MVC
$bdd = new PDO('mysql:host=localhost;dbname=3proj;charset=utf8', 'root', '');

$query = $bdd->query("SELECT * FROM sections");
while($data = $query->fetch())
{
?>
    <div id="blocks">
        <div class="block">
            <div class="title"><?= $data["sectionName"] ?></div>
            <div class="img">
                <img src="views/images/<?= $data["id"] ?>.png">
            </div>
            <div class="status">
                <?php
                    if($data["sectionStatus"] == 0)
                        echo "<span class='online'></span> <span class='msgStatus'>Online</span>";
                    else
                        echo "<span class='offline'></span> <span class='msgStatus'>Offline</span>";
                ?>
            </div>

            <?php if($data["sectionStatus"] == 1) { ?>
                <div class="warning">
                    <img src="views/images/warning.png">WARNING<img src="views/images/warning.png">
                </div>
            <?php }else echo '<div class="nothing">Nothing</div>'; ?>
        </div>
    </div>
<?php
}