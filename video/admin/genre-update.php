<?php require_once "init.php" ?>
<?php
    $id = intval($_REQUEST['id']);
    //checking to see if the genre was send
    if(isset($_REQUEST['name'])){
        $name = trim(filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING));
        //update the table
        $stmt = $db->prepare("UPDATE genre SET genre = ?
                            WHERE id = ?");
        $stmt->bind_param("si", $name, $id);
        $stmt->execute();
        $stmt->close();
    }

    //to load a specific genre trough id, default values in the form
    $res = $db->query("SELECT * FROM genre WHERE id = $id");
    $gen = $res->fetch_assoc();

        
?>
<?php include "head.php" ?>
<?php include "nav.php" ?>
<body>
    <h1>Update genre <?= $gen['genre'] ?></h1><!--Trough id we get a title of the genre we want to change-->
    <form method="post" action="genre-update.php?id=<?= $id ?>">
       <input type="hidden" name="id" value="<?= $id ?>">
        <div class="form-group col-sm-9">
            <label>Name</label>
            <input id="name" type="text" name="name" class="form-control" value="<?= htmlspecialchars($gen['genre'])?>">
        </div>
        <button type="submit" value="Submit" class="btn btn-success">Save</button>
        <a href="genre-read.php" class="btn btn-secondary">Cancel</a>
        <a href="genre-delete.php?id=<?= $gen['id']?>" class="btn btn-danger">Delete</a>
    </form>           
<?php include "footer.php" ?>