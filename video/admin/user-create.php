<?php require_once "init.php" ?>
<?php
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
        $stmt = $db->prepare("INSERT INTO users (username, password, accesslevel, active) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $pass, $access, $active);
        $stmt->execute();
        
        //rederect to list
        header("Location: user-read.php");
        $stmt->close();


    }
?>
<?php include "head.php" ?>
<?php include "nav.php" ?>

<body>
    <h1>Create new</h1>
    <form method="post" action="">
        <div class="form-group col-sm-9">
            <label>Username</label>
            <input id="name" type="text" name="name" class="form-control">
        </div>
        <div class="form-group col-sm-9">
            <label>Password</label>
            <input id="pass" type="text" name="password" class="form-control">
        </div>
        <div class="form-group col-sm-9">
            <label>Accesslevel</label>
            <select name="access" class="form-control">
                <option  value = "1">Registered</option>
                <option  value = "5">Administrator</option>
                <option  value = "10">Superadmin</option>
            </select>
        </div>
        <div class="form-group col-sm-9">
            <label>Active</label>
            <input id="active" type="checkbox" name="active">
        </div>
        <button class="btn btn-success">Save</button>
        <a href="user-read.php" class="btn btn-danger">Cancel</a>
    </form>           
<?php include "footer.php" ?>