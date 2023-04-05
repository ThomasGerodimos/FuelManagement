<?php
// Έχει έρθει ο χρήστης απο το κουμπί της σωστής φόρμας
if (isset($_POST['promotion-btn'])) {
    //Σύνδεση με τη βάση
    require 'db.inc.php';

    $UserID= $_POST['UserID'];
    $FuelPrice = $_POST['FuelPrice'];
    $PromotionEndDate = $_POST['PromotionEndDate'];
    $FuelID=$_POST['FuelID'];

    // Υπάρχει καταχωρημένη προσφορά απο την επιχείρηση για το συγκεκριμένο καύσιμο;
    $sql = "SELECT * FROM vwactivepromotions where FK_UserID=? and FK_FuelTypeID=?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../Error.php?error=SQL Error");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"ii",$UserID,$FuelID);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if ($resultCheck > 0) {
            // Υπάρχει προσφορά και πρέπει να γίνει update
            $sql = "UPDATE promotions set PromotionPrice=?,PromotionEndDate=? where FK_FuelTypeID=? and FK_UserID=? and PromotionEndDate >= curdate();";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../Promotion.php?error=SQL Error");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "dsii", $FuelPrice, $PromotionEndDate, $FuelID, $UserID);
                mysqli_stmt_execute($stmt);
                //Η ενημέρωση ολοκληρώθηκε εμ επιτυχία.
                header("Location: ../Promotion.php?PromotionUpdated=Success");
                exit();
            }
        }
        else {
            //Προσθήκη προσφοράς
            $sql = "INSERT INTO promotions(PromotionPrice,PromotionEndDate,FK_FuelTypeID,FK_UserID) VALUES (?,?,?,?);";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt,$sql)) {
                header("Location: ../Promotion.php?error=SQL Error");
                exit();
            }
            else {
                mysqli_stmt_bind_param($stmt,"dsii",$FuelPrice,$PromotionEndDate,$FuelID,$UserID);
                mysqli_stmt_execute($stmt);
                //Η προσθήκη ολοκληρώθηκε εμ επιτυχία.
                header("Location: ../Promotion.php?PromotionInserted=Success");
                exit();
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}


