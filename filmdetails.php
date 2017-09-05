<?php


$filmid = filter_input(INPUT_GET, 'filmid', FILTER_VALIDATE_INT) //a. Read the GET parameter filmid
or die('Missing/illegal filmid paramter');

require_once('includes/conn.php');
$sql = 'SELECT film.film_id, film.title, film.description, film.release_year, film.language_id, film.rating, film.length, film.special_features, category.name, category.category_id 
FROM film, category, film_category where film.film_id=film_category.film_id AND category.category_id=film_category.category_id AND film.film_id=?'; //b. Use the filmid to select and list various detail about the film

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $filmid);
$stmt->execute();
$stmt->bind_result($film_id, $title, $description, $release_year, $language_id, $rating, $length, $special_features, $name, $categoryid);
while($stmt->fetch()) { ?>
  <table border='1'>
       <tr>
           <th>Title</th>
           <th>Description</th>
           <th>Releasse Year</th>
           <th>Language ID</th>
           <th>Rating</th>
           <th>Lenght</th>
           <th>Special Features</th>
           <th>Film Categories</th>
         </tr>
         <tr>
           <td><?= $title ?></td>
           <td><?= $description?></td>
           <td><?= $release_year ?></td>
           <td><?= $language_id ?></td>
           <td><?= $rating ?></td>
           <td><?= $length?></td>
           <td><?= $special_features ?></td>
           <td><a href="filmlist.php?categoryid=<?=$categoryid?>"><?=$name?></a></td> <!-- c. Select and list all the categories the film is in - link to filmlist.php?categoryid= -->
         </tr>

      </table>
<?php } ?>
<?php
$act = 'SELECT actor.actor_id,actor.first_name, actor.last_name
FROM film_actor, actor, film WHERE actor.actor_id=film_actor.actor_id AND film.film_id=film_actor.film_id AND film.film_id=?'; //d. Select and list all the actors staring in the film - link to actordetails.php?actorid=
$stmt = $conn->prepare($act);
$stmt->bind_param('i', $filmid);
$stmt->execute();
$stmt->bind_result($actorid, $firstname, $lastname);
echo '<ul>';
while($stmt->fetch()) { ?>
  <li><a href="actordetails.php?actorid=<?= $actorid ?>"><?= $firstname?> <?= $lastname ?></a></li>
<?php } ?>
</ul>

<hr>

