<?php include 'includes/conn.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

  if($cmd = filter_input(INPUT_POST, 'cmd')) {

    if($cmd == 'create_category') {
      $cnam = filter_input(INPUT_POST, 'categoryname') or die('missing/illegal categoryname parameter');


      require_once('includes/conn.php');
      $sql = 'INSERT INTO category(name) VALUES(?)';
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('s', $cnam);
      $stmt->execute();

      if($stmt->affected_rows > 0) {
        echo 'Created Category '.strtoupper($cnam).' with ID:'.$stmt->insert_id;
      }
    } elseif($cmd == 'delete_category') {
			$cid = filter_input(INPUT_POST, 'categoryid', FILTER_VALIDATE_INT)
				or die('nope');

				require_once('includes/conn.php');
				$sql = 'DELETE FROM category WHERE category_id=?';
				$stmt = $conn->prepare($sql);
				$stmt->	bind_param('i', $cid);
				$stmt->execute();

				if ($stmt->affected_rows > 0) {
					echo "wuhu";
				} else {
					echo "aww man";
				 }
       }
		}
     ?>
    <h1>Category</h1>
    <?php
    $stmt = $conn->prepare('SELECT category_id, name FROM category ORDER BY name');
    $stmt->execute();
    $stmt->bind_result($cid, $name);
    while($stmt->fetch()) { ?>
      <li><a href='filmlist.php?categoryid=<?=$cid?>'><?=$name?></a>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
					<input type="hidden" name="categoryid" value="<?=$cid?>">
					<button type="submit" name="cmd" value="delete_category">Slet</button>
				</form>
        <a href="renamecategory.php?categoryid=<?=$cid?>">Edit</a>
      </li>

    <?php } ?>

    <hr>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
      <fieldset>
        <legend>Create new Category</legend>
        <input type="text" name="categoryname" placeholder="Category Name" require>
        <button name="cmd" value="create_category" type="submit">Create It</button>
      </fieldset>
    </form>
  </body>
</html>
