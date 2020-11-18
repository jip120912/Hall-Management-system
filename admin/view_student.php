<?php
ob_start();
session_start();
if ($_SESSION['name'] != 'admin') {
    header('location: login.php');
}

include "../config.php";
?>
<?php include "header.php"; ?>
<!---Content Part -->
<div class="col-sm-10 col-md-10 col-lg-10">
    <div id="content">
        <?php
        if (isset($_SESSION['success_message']) != "") {
            ?>
            <h2> <?php
                echo("{$_SESSION['success_message'] }");
                ?> </h2>
            <?php
            $_SESSION['success_message'] = "";
        }
        if (isset($_SESSION['error_message']) != "") {
            ?>
            <h2> <?php
                echo("{$_SESSION['error_message'] }");
                ?> </h2>
            <?php
            $_SESSION['error_message'] = "";
        }
        if (isset($_SESSION['error_email']) != "") {
            ?>
            <h2> <?php
                echo("{$_SESSION['error_email'] }");
                ?> </h2>
            <?php
            $_SESSION['error_email'] = "";
        }


        //        else{
        //            ?>
        <!--            <h2>Nothing</h2>-->
        <!--            --><?php
        //        }
        //        ?>

        <h2>View All Students</h2>

        <table class="table table-bordered table-hover table-responsive" width="100%">
            <tr style="background-color: #0D7B7B;color: #FFF;height: 40px;">
                <th width="5%" style="text-align: center; border-right: 1px solid #FFF;">No.</th>
                <th width="20%" style="text-align: center; border-right: 1px solid #FFF;">Name</th>
                <th width="20%" style="text-align: center; border-right: 1px solid #FFF;">Phone</th>
                <th width="45%" style="text-align: center; ">Action</th>
            </tr>

            <?php
            $i = 0;
            $statement = $db->prepare("SELECT * FROM tbl_student ORDER BY name ASC");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                $i++;
                ?>

                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['phone_no']; ?></td>
                    <td>
                        <a class="btn btn-info" data-toggle="modal" href="#inline<?= $i; ?>">View</a>
                        <!-- Modal -->
                        <div id="inline<?= $i; ?>" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">View Student</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <h3 style="border-bottom: 4px solid rgba(15, 46, 46, 0.85);background-color: #428bca;margin-bottom: 15px;padding: 10px;">
                                                Student Detail</h3>
                                            <p>
                                            <form action="" method="post">
                                                <table>
                                                    <tr>
                                                        <td><?= $row['name']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>ID</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $row['university_id']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Registration No.</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $row['registration_no']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Faculty</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $row['faculty']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Phone No.</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $row['phone_no']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Address</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $row['address']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Room No.</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <?php
                                                            $statement1 = $db->prepare("SELECT * FROM tbl_rooms WHERE id=?");
                                                            $statement1->execute(array($row['room_id']));
                                                            $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                                                            foreach ($result1 as $row1) {
                                                                $name = $row1['name'];
                                                                $block = $row1['block'];
                                                            }
                                                            ?>

                                                            <?= $block; ?> - <?= $name; ?>

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Session</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?= $row['session']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Image</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><img src="../images/students/<?= $row['image']; ?>" alt="">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td><a class="btn btn-info"
                                                               href="edit_student.php?id=<?= $row['id']; ?>">Edit</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <a class="btn btn-success" href="edit_student.php?id=<?= $row['id']; ?>">Edit</a>

                        <a class="btn btn-danger" onclick='return confirm("Do you want to delete this student data?")'
                           href="delete_student.php?id=<?= $row['id']; ?>">Delete</a>

                        <?php
                        if ($row['is_verified'] == 0) {
                            ?>
                            <a class="btn btn-warning" name="verify" href="approve_student.php?id=<?= $row['id']; ?>">Verify</a>
                            <?php
                        } else {
                            ?>
                            <a class="disabled" style="color: green; text-decoration: none">
                                Verified
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
</div>
<?php include "footer.php"; ?>
