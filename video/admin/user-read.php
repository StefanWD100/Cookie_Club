<?php require_once "init.php" ?>
<?php include "head.php" ?>
<?php include "nav.php" ?>
<body>
    <h1>Users</h1>
    <a href="user-create.php" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i>New</a>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Active</th>
                <th>Accesslevel</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $result = $db->query("SELECT * FROM users");
                while($u = $result->fetch_assoc()){
                ?>
                <tr>
                    <td><?= $u['username'] ?></td>
                    <td>
                        <?php
                            if($u['active']){
                                echo '<span class="fa fa-check"></span>';
						      } else{
							     echo '<span class="fa fa-times"></span>';
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            switch($u['accesslevel']){
                                case 1: echo "Registered";
                                break;
                                case 5: echo "Administrator";
                                break;
                                case 10: echo "Superadmin";
                                break;
                            }
                        ?>
                    </td>
                    <td><a href="user-update.php?id=<?= $u['id']?>">Update</a></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>

<?php include "footer.php" ?>