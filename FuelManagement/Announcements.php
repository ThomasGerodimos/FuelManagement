<?php require "Templates/Header.php";
require 'Includes\db.inc.php';
?>

<main>
    <div class="text-center">
        <h1 class="display-6 fw-normal" style="margin: 0.5em;">Ανακοινώσεις</h1>
    </div>

    <div style="width: 100%; overflow-y:scroll;overflow-x: hidden;height: 45em;">
        <?PHP  if (isset($_SESSION['UserID'])) {
            //Αν ο χρήστης είναι διαχειριστής (SystemRole=1) τότε εμφάνισε το κουμπί "Νέα Ανακοίνωση"
            if ($_SESSION['SystemRole']==1) {
            ?>
              <button name="New-post" type="button" class="btn bg-secondary" data-bs-toggle="modal"
                      data-bs-target="#NewPostModal" style="width:auto; color: white;margin-left: 10px;font-size: 11px">
                Νέα Ανακοίνωση
              </button>

                <?php }}?>
        <hr>

        <?php
        //SQL Query ευρεσης των ανακοινώσεων
        $query2 = "SELECT AnnouncementID,CreationDate, AnnouncementTitle,AnnouncementContent FROM gerodimos.Announcements order by CreationDate desc";
        $stmt2 = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt2, $query2)) {
            header("Location: ../Error.php?error=SQL Error");
            exit();
        } else {
        foreach ($stmt2 = $conn->query($query2) as $row) {
            ?>
        <div class="row">
            <div class="col-3">
                <img class="post-img" src="Images\fuel-logo.webp" style="width: 250px; float: left" alt="FuelOil logo">
            </div>

            <div class="col-9" style="padding-right: 3em">
                <h3 class="announcement" id="AnnouncementDate" style="font-size: 13px"> <?php echo $row['CreationDate']; ?></h3>
                <input type="hidden" id="CurrentPostID" value="<?php echo $row['AnnouncementID']; ?>"
                       name="AnnouncementID"/>

                <h2 class="announcement"><?php echo $row['AnnouncementTitle']; ?></h2>
                <p style="text-align: justify"> <?php echo $row['AnnouncementContent']; ?></p>

                <?PHP  if (isset($_SESSION['UserID'])) {
                    //Αν ο χρήστης είναι διαχειριστής (SystemRole=1) τότε εμφάνισε το κουμπί "Νέα Ανακοίνωση"
                    if ($_SESSION['SystemRole']==1) {
                    ?>

                    <button name="New-post" type="button" class="btn bg-warning" data-bs-toggle="modal"
                            data-bs-target="<?php echo "#edit_".$row['AnnouncementID']; ?>" style="width:auto; color: white;margin-left: 10px;font-size: 11px">
                        Επεξεργασία
                    </button>
                    <button name="New-post" type="button" class="btn bg-danger" data-bs-toggle="modal"
                            data-bs-target="<?php echo "#delete_".$row['AnnouncementID']; ?>" style="width:auto; color: white;margin-left: 10px;font-size: 11px">
                        Διαγραφή
                    </button>

                    <?php
                        //Εισαγωγή των Pop up Modal παραθύρων
                        include('Templates\Announcements\Modals.php'); }}
                    ?>
            </div>
        </div>
            <br>
            <hr class="divider">
                <?php };?>
                <br>

            <?php $stmt2->close();} ?>

</main>

<?php require "Templates/Footer.php";?>