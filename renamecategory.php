<?php

    if ($cmd = filter_input(INPUT_POST, 'cmd')) {
      if($cmd == 'rename_category') {
        $cid = filter_input(INPUT_POST, 'categoryid', FILTER_VALIDATE_INT)
        or die('Missing/illegal categoryid parameter');
        $cnam = filter_input(INPUT_POST, 'categoryname')
        or die('Missing/illegal categoryname parameter');

        require_once('includes/conn.php');
        $sql = 'UPDATE category set name=? WHERE category_id=?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $cnam, $cid);
        $stmt->execute();

        if($stmt->affected_rows > 0) {
          header("Location: categorylist.php?=categoryupdated");
          exit();
        }
        else {
          echo 'Could not update'.$cnam;
        }
      }
      else {
        die('DIE MOTHERFUCKER DIE');
      }
    }

    if(empty($cid)) {
    $cid = filter_input(INPUT_GET, 'categoryid', FILTER_VALIDATE_INT)
    or die('Missing/illegal categoryid parameter');
  };
      require_once('includes/conn.php');
      $sql ='SELECT name FROM category WHERE category_id=?';
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('i', $cid);
      $stmt->execute();
      $stmt->bind_result($cname);
      while($stmt->fetch()) {};
     ?>
     <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
       <fieldset>
         <legend>Rename Category</legend>
         <input type="hidden" name="categoryid" value="<?=$cid?>">
         <input type="text" name="categoryname" placeholder="<?= $cname ?>" value="<?= $cname ?>" required>
         <button type="submit" name="cmd" value="rename_category">Update Category</button>
       </fieldset>
     </form>


  </body>
</html>
