<?php require_once "init.php" ?>
<?php
    $id = intval($_REQUEST['id']);
    //checking to see if the username was set
    if(isset($_REQUEST['name'])){
        $name = trim(filter_var($_REQUEST['name'], FILTER_SANITIZE_STRING));
        //crypting the password with blowfish
        $pass = trim(filter_var($_REQUEST['password'], FILTER_SANITIZE_STRING));
        $hashFormat = "$2y$10$";
        $salt = "idontknowwhattoputhere";
        $hash_and_salt = $hashFormat . $salt;
        $pass = crypt($pass, $hash_and_salt);
        
        $access = $_REQUEST['access'];
        
        if(isset($_REQUEST['active'])){
            $active = 1;
        } else {
            $active = 0;
        }
        //insert into table
        $stmt = $db->prepare("UPDATE users SET username = ?, password = ?, accesslevel = ?, active = ?
                            WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $pass, $access, $active, $id);
        $stmt->execute();
        
        //rederect to list
        header("Location: user-read.php");
        $stmt->close();


    }
?>
<?php include "head.php" ?>
<?php include "nav.php" ?>
<?php 
    $result = $db->query("SELECT * FROM users WHERE id = $id");
    $u = $result->fetch_assoc();
?>
<body>
    <h1>Update user <?php $u['username']; ?></h1>
    <form method="post" action="user-update.php?id=<?= $id ?>">
       <input type="hidden" name="id" value="<?= $id ?>">
        <div class="form-group col-sm-9">
            <label>Username</label>
            <input id="name" type="text" name="name" class="form-control" value="<?= htmlspecialchars($u['username'])?>">
        </div>
        <div class="form-group col-sm-9">
            <label>Password</label>
            <input id="pass" type="text" name="password" class="form-control" value="<?= htmlspecialchars($u['password'])?>">
        </div>
        <div class="form-group col-sm-9">
            <label>Accesslevel</label>
            <select name="access" class="form-control">
                <option <?php if($u['accesslevel']==1) echo 'selected'; ?> value = "1">Registered</option>
                <option <?php if($u['accesslevel']==5) echo 'selected'; ?> value = "5">Administrator</option>
                <option <?php if($u['accesslevel']==10) echo 'selected'; ?> value = "10">Superadmin</option>
            </select>
        </div>
        <div class="form-group col-sm-9">
            <label>Active</label>
            <input id="active" type="checkbox" name="active" <?php if($u['active']) echo 'checked'; ?>>
        </div>
        <button class="btn btn-success">Save</button>
        <a href="user-read.php" class="btn btn-secondary">Cancel</a>
        <a href="user-delete.php?id=<?= $u['id']?>" class="btn btn-danger">Delete</a>
    </form>           
<?php include "footer.php" ?>