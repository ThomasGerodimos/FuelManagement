<?php require "Templates/Header.php";
require 'Includes\db.inc.php';
?>

<!--    Δημιουργία επιλογών για την πτυσσόμενη λίστα των Νομών-->
<?php
//  Query που επιστρέφει τους Νομούς
$sqlNomoi = "SELECT * FROM regions order by RegionName";
$AllNomoi = mysqli_query($conn, $sqlNomoi);

//  Query που επιστρέφει τους Δήμους
$sqlDimoi = "SELECT * FROM municipalities order by MunicipalityName;";
$AllDimoi = mysqli_query($conn, $sqlDimoi);

//  Query που επιστρέφει τa Είδη Καυσίμου
$sqlFuels = "SELECT * FROM fueltypes order by FuelTypeName;";
$AllFuel = mysqli_query($conn, $sqlFuels);

?>

<main>
    <?php
    //Αν δεν υπάρχει στη συνεδρία το UserID σημαίνει ότι ο χρήστης δεν είναι συνδεδεμένος όποτε γίνεται
    // αναδρομολόγηση στη σελίδα Login.php
    if (!isset($_SESSION['UserID'])) {
        header("Location: Login.php?error=No Authentication");
        exit();
    }
    ?>
    <div class="text-center" style="margin: 1.5em;">
        <h1 class="display-6 fw-normal">Καταχώρηση Προσφοράς</h1>
    </div>

    <!--  Εμφάνιση errors με ελέγχους στην php-->
    <?php
    if (isset($_GET['PromotionInserted'])) {
        if ($_GET['PromotionInserted'] == "Success") [$SuccessMessage="Η προσφορά καταχωρήθηκε με επιτυχία."];
        echo '<div class="alert alert-info  " role="alert"><h5>Καταχώρηση Προσφοράς</h5>';
        echo $SuccessMessage;
        echo '</div>';
    }
    if (isset($_GET['PromotionUpdated'])) {
        if ($_GET['PromotionUpdated'] == "Success") [$SuccessMessage="Υπήρχε ήδη καταχωρημένη ενεργή προσφορά. Η προσφορά ενημερώθηκε με επιτυχία, με την  τιμή και ημερομηνία λήξης που συμπληρώθηκε."];
        echo '<div class="alert alert-warning" role="alert"><h5>Ενημέρωση Προσφοράς</h5>';
        echo $SuccessMessage;
        echo '</div>';
    }
    ?>

    <form class="needs-validation" novalidate action="Includes/addpromotion.inc.php" method="post">
        <div class="row">
            <input type="hidden" value="<?php echo $_SESSION['UserID'] ?>" name="UserID"/>
        </div>
        <div class="row">
            <div class="col-3">
                <label class="form-label">Επωνυμία Επιχείρησης</label>
            </div>
            <div class="col-3">
                <input type="text" class="form-control" readonly disabled
                    <?php if (isset($_SESSION['CompanyName'])) { ?>
                        value="<?php echo $_SESSION['CompanyName']; ?>"
                    <?php } ?>
                       required>
            </div>
        </div>


        <div class="row" style="margin-top: 0.5em;">
            <div class="col-3">
                <label class="form-label" for="validationCustom01">ΑΦΜ</label>
            </div>

            <div class="col-3">
                <input type="text" class="form-control" name="AFM" minlength="9" maxlength="9" id="pin"
                       pattern="[0-9]{9}" required
                    <?php if (isset($_SESSION['VAT'])) { ?>
                        value="<?php echo $_SESSION['VAT']; ?>"
                    <?php } ?>
                       oninput="this.value = this.value.replace(/[^0-9.]/g, "").replace(/(\..*)\./g, "$1");"
                />
                <div class="invalid-feedback">
                    Το ΑΦΜ είναι υποχρεωτικό και πρέπει να έχει 9 ψηφία!
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 0.5em;">
            <div class="col-3">
                <label class="form-label">Διεύθυνση</label>
            </div>
            <div class="col-3">
                <input type="text" id="disabledTextInput" class="form-control"
                    <?php if (isset($_SESSION['CompanyAddress'])) { ?>
                        value="<?php echo $_SESSION['CompanyAddress']; ?>"
                    <?php } ?>
                       required="">
                <div class="invalid-feedback">
                    Πρέπει να συμπληρώνεται τη Διεύθυνση!
                </div>
            </div>
        </div>


        <div class="row" style="margin-top: 0.5em;">
            <div class="col-3">
                <label class="form-label">Νομός</label>
            </div>
            <div class="col-3">
                <select class="form-select" id="FuelSelect" required="">
                    <option selected value="">Επιλογή Νομού...</option>
                    <?php
                    //Δημιουργία επιλογών απο τη Βάση Δεδομένων
                    while ($Nomoi = mysqli_fetch_array(
                        $AllNomoi, MYSQLI_ASSOC)):; ?>
                        <option value="<?php echo $Nomoi["RegionID"]; ?>"
                            <?php if ($_SESSION['FK_RegionID'] == $Nomoi["RegionID"]) echo 'selected="selected"'; ?> >
                            <?php echo $Nomoi["RegionName"]; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <div class="invalid-feedback">
                    Πρέπει να συμπληρωθεί ο Νομός!
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 0.5em;">
            <div class="col-3">
                <label class="form-label">Δήμος</label>
            </div>
            <div class="col-3">
                <select class="form-select" id="FuelSelect" required>
                    <option selected value="">Επιλογή Δήμου...</option>
                    <?php
                    //Δημιουργία επιλογών απο τη Βάση Δεδομένων
                    while ($Dimoi = mysqli_fetch_array(
                        $AllDimoi, MYSQLI_ASSOC)):; ?>
                        <option value="<?php echo $Dimoi["MunicipalityID"]; ?>"
                            <?php if ($_SESSION['FK_MunicipalityID'] == $Dimoi["MunicipalityID"]) echo 'selected="selected"'; ?> >
                            <?php echo $Dimoi["MunicipalityName"]; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <div class="invalid-feedback">
                    Πρέπει να συμπληρωθεί ο Δήμος!
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 0.5em;">
            <div class="col-3">
                <label class="form-label">Είδος Καυσίμου *</label>
            </div>
            <div class="col-3">
                <select class="form-select" id="FuelSelect" name="FuelID" required="">
                    <option selected value="">Επιλογή Καυσίμου...</option>
                    <?php
                    //Δημιουργία επιλογών απο τη Βάση Δεδομένων
                    while ($Fuel = mysqli_fetch_array(
                        $AllFuel, MYSQLI_ASSOC)):; ?>
                        <option value="<?php echo $Fuel["FuelTypeID"]; ?>"
                            <?php if ($_SESSION['FK_FuelTypeID'] == $Fuel["FuelTypeID"]) echo 'selected="selected"'; ?> >
                            <?php echo $Fuel["FuelTypeName"]; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <div class="invalid-feedback">
                    Πρέπει να συμπληρωθεί το Καύσιμο!
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 0.5em;">
            <div class="col-3">
                <label class="form-label">Τιμή *</label>
            </div>
            <div class="col-3">
                <input type="number" step="0.001" placeholder="0.000" name="FuelPrice" class="form-control" required/>
                <div class="invalid-feedback">
                    Πρέπει να συμπληρωθεί η τιμή του καύσιμου στη μορφή 0.000!
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 0.5em;">
            <div class="col-3">
                <label class="form-label">Ημερομηνία Λήξης προσφοράς *</label>
            </div>
            <div class="col-3">
                <input type="date" id="disabledTextInput" name="PromotionEndDate" class="form-control" required>
                <div class="invalid-feedback">
                    Πρέπει να συμπληρωθεί η ημερομηνία λήξης της προσφοράς!
                </div>
            </div>

        </div>
        <br/>
        <i class="form-label">* Τα συγκεκριμένα πεδία είναι υποχρεωτικά.</i><br/>
        <i class="form-label">Σε περίπτωση που έχει ξανακαταχωρηθεί προσφορά για το ίδιο τύπο καυσίμου και αυτή είναι ενεργή τότε <br/>
            θα ενημερωθεί με τη νέα τιμή και τη νέα ημερομηνία.</i>

        <div class="row" style="margin-top: 0.5em;">
            <div class="col-3"></div>
            <div class="col-3" style="text-align: center;">
                <button type="submit" name="promotion-btn" class="btn btn-primary account" style="width: 200px;">Καταχώρηση</button>
            </div>
        </div>
    </form>
</main>

<?php require "Templates/Footer.php";
?>