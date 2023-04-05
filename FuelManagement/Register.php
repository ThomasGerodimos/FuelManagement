<?php
require "Templates/Header.php";
require "Includes/db.inc.php";
?>

<?php
// Δημιουργία επιλογών για τις πτυσσόμενες λίστες

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
        <div style="margin-top: 1em;margin-bottom: 1em;">
            <h1 style="font-size:1.6em">Εγγραφή Επιχείρησης</h1>
        </div>

        <!--  Εμφάνιση errors για τους ελέγχους που γίνονται στην php-->
        <?php
        if (isset($_GET['error'])) {
            $ErrorMessage = "Παρουσιάστηκε πρόβλημα με:<br/> ";
            if (strpos($_GET['error'], "VAT already Taken") !== false) {
                $ErrorMessage = $ErrorMessage . "- Το ΑΦΜ είναι ήδη καταχωρημένο.";

            }
            if ($_GET['error'] == "invalid email") [$ErrorMessage = $ErrorMessage . "- Το email που πληκτρολογήσατε δεν είναι σωστό."];
            if ($_GET['error'] == "password-check") [$ErrorMessage = $ErrorMessage . "- Η επιβεβαίωση του Κωδικού δεν είναι σωστή. Παρακαλώ δοκιμάστε ξανά."];
            if ($_GET['error'] == "SQL Error") [$ErrorMessage = $ErrorMessage . "- Υπάρχει πρόβλημα με την Βάση Δεδομένων.<br/>"];
            if ($_GET['error'] == "invalid-password") [$ErrorMessage = $ErrorMessage . "- O Κωδικός δεν πληρεί τις προδιαγραφές. Θα πρέπει να περιλαμβάνει τουλάχιστον ένα αριθμό και ενα κεφαλαίο γράμμα.<br/>"];

            echo '<div class="alert alert-danger" role="alert"><h5>Δημιουργία λογαριασμού</h5>';
            $ErrorMessage = $ErrorMessage . "<br/>Επικοινωνήστε με το διαχειριστή στο email admin@fueloil.gr";
            echo $ErrorMessage;
            echo '</div>';
        }?>

        <?php
        if (isset($_GET['register'])) {
            if ($_GET['register'] == "Success") [$SuccessMessage="Ο λογαριασμός δημιουργήθηκε με επιτυχία."];
            echo '<div class="alert alert-info" role="alert"><h5>Δημιουργία λογαριασμού</h5>';
            echo $SuccessMessage;
            echo '</div>';
        }?>

        <form class="needs-validation" action="Includes/signup.inc.php" method="post" novalidate>
            <div class="row">
                <div class="col-3">
                    <label class="form-label">Επωνυμία Επιχείρησης</label>
                </div>
                <div class="col-3">
                    <input type="text" name="CompanyName" class="form-control"
                        <?php if (isset($_GET['CompanyName'])) { ?>
                            value="<?php echo $_GET['CompanyName']; ?>"
                        <?php } ?>
                           maxlength="120" required>
                    <div class="invalid-feedback">
                        Η επωνυμία της επιχείρησης είναι υποχρεωτική (έως 120 χαρακτήρες)!
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 0.5em;">
                <div class="col-3">
                    <label class="form-label" for="validationCustom01">ΑΦΜ</label>
                </div>

                <div class="col-3">
                    <input type="text" class="form-control" name="VAT" minlength="9" maxlength="9" id="pin"
                           pattern="[0-9]{9}" required
                           oninput="this.value = this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
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
                    <input type="text" id="disabledTextInput" name="CompanyAddress" class="form-control"
                        <?php if (isset($_GET['CompanyAddress'])) { ?>
                            value="<?php echo $_GET['CompanyAddress']; ?>"
                        <?php } ?>
                           maxlength="120" required>

                    <div class="invalid-feedback">
                        Πρέπει να συμπληρώσετε την Διεύθυνση (έως 120 χαρακτήρες)!
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 0.5em;">
                <div class="col-3">
                    <label class="form-label">Νομός</label>
                </div>
                <div class="col-3">
                    <select class="form-select" id="FuelSelect" name="FK_RegionID" required="">
                        <option selected value="">Επιλογή Νομού...</option>
                        <?php
                       //Δημιουργία επιλογών απο τη Βάση Δεδομένων
                        while ($Nomoi = mysqli_fetch_array(
                            $AllNomoi, MYSQLI_ASSOC)):; ?>
                            <option value="<?php echo $Nomoi["RegionID"];?>">
                                <?php echo $Nomoi["RegionName"];?>
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
                    <select class="form-select" id="FuelSelect" name="FK_MunicipalityID" required>
                        <option selected value="">Επιλογή Δήμου...</option>
                        <?php
                        //Δημιουργία επιλογών απο τη Βάση Δεδομένων
                        while ($Dimoi = mysqli_fetch_array(
                            $AllDimoi, MYSQLI_ASSOC)):; ?>
                            <option value="<?php echo $Dimoi["MunicipalityID"]; ?>">
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
                    <label class="form-label">Είδος Καυσίμου</label>
                </div>
                <div class="col-3">
                    <select class="form-select" id="FuelSelect" name="FK_FuelTypeID" required="">
                        <option selected value="">Επιλογή Καυσίμου...</option>
                        <?php
                        //Δημιουργία επιλογών απο τη Βάση Δεδομένων
                        while ($Fuel = mysqli_fetch_array(
                            $AllFuel, MYSQLI_ASSOC)):; ?>
                            <option value="<?php echo $Fuel["FuelTypeID"]; ?>">
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
                    <label class="form-label">Email</label>
                </div>
                <div class="col-3">
                    <input type="email" class="form-control" name="Email"
                        <?php if (isset($_GET['mail'])) { ?>
                            value="<?php echo $_GET['mail']; ?>"
                        <?php } ?>
                           required />
                    <div class="invalid-feedback">
                        Πρέπει να συμπληρωθεί το email του χρήστη!
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 0.5em;">
                <div class="col-3">
                    <label class="form-label">Username</label>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" name="UserName" minlength="6" required>
                    <div class="invalid-feedback">
                        Το όνομα χρήστη πρέπει να είναι τουλάχιστον 6 χαρακτήρες!
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 0.5em;">
                <div class="col-3">
                    <label class="form-label">Κωδικός</label>
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" name="Password" maxlength="8" required>
                    <div class="invalid-feedback">
                        Ο κωδικός χρήστη είναι υποχρεωτικό πεδίο και πρέπει να είναι έως 8 χαρακτήρες, να περιέχει 1 κεφαλαίο γράμμα και ένα αριθμό!
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 0.5em;">
                <div class="col-3">
                    <label class="form-label">Επιβεβαίωση Κωδικού</label>
                </div>
                <div class="col-3">
                    <input type="password" class="form-control" name="ConfirmPassword" maxlength="8" required>
                    <div class="invalid-feedback">
                        H Επιβεβαίωση Κωδικού είναι υποχρεωτικό πεδίο!
                    </div>
                </div>

            </div>
            <br/>
            <label class="form-label">* Όλα τα πεδία της φόρμας είναι υποχρεωτικά.</label>

            <div class="row" style="margin-top: 0.5em;">
                <div class="col-3"></div>
                <div class="col-3" style="text-align: center;">
                    <button type="submit" name="new-business-register" class="btn btn-primary account"
                            style="width: 200px;">Εγγραφή
                    </button>
                </div>
            </div>
        </form>
    </main>

<?php require "Templates/Footer.php";
?>