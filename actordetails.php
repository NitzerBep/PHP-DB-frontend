<?php
$aid = filter_input(INPUT_GET, 'actorid', FILTER_VALIDATE_INT) or die('Missing category_id'); //a. Read the GET parameter actorid

require_once 'includes/conn.php';
$act = 'SELECT actor.first_name, actor.last_name, film.title, film.film_id
FROM film_actor, actor, film WHERE film_actor.actor_id=actor.actor_id AND film.film_id=film_actor.film_id AND actor.actor_id=?'; //b. Use the actorid to select and list various detail about the actor
$stmt = $conn->prepare($act);
$stmt->bind_param('i', $aid);
$stmt->execute();
$stmt->bind_result($firstname, $lastname, $title, $filmid);
echo '<ul>';
while($stmt->fetch()) { ?>
  <li><a href="filmdetails.php?filmid=<?= $filmid ?>"><?= $title ?></a> - BY <?= $firstname ?> <?= $lastname ?></li> <!-- c. Select and list all the films the actors is staring in – link to filmdetails.php?filmid= -->
<?php } ?>
</ul>
