<?php
require "Templates/Header.php";
require "Includes/db.inc.php";
require "Includes/tools.php";

//  Query που επιστρέφει τους Νομούς
$sqlNomoi = "SELECT * FROM regions order by RegionName";
$AllNomoi = mysqli_query($conn, $sqlNomoi);

//  Query που επιστρέφει τa Είδη Καυσίμου
$sqlFuels = "SELECT * FROM fueltypes order by FuelTypeName;";
$AllFuel = mysqli_query($conn, $sqlFuels);

//  Query που επιστρέφει τις επιχειρήσεις
$sqlUsers = "SELECT  p.PromotionID ,p.PromotionPrice ,p.PromotionEndDate ,p.FK_FuelTypeID ,p.FK_UserID ,f.FuelTypeName ,u.CompanyName ,u.CompanyAddress FROM promotions as p left join fueltypes as f on f.FuelTypeID=p.FK_FuelTypeID left join users as u on u.UserID=p.FK_UserID where p.PromotionEndDate >= curdate() and u.SystemRole>1";

//Αρχικοποίηση των μεταβλητών των λιστών επιλογής που θα φιλτράρουν τα δεδομένα
$SelectedRegion="";
$SelectedFuel="";

// Όταν πατηθεί το κουμπί αναζήτησης
if (isset($_POST['search-btn'])) {
    //Δίνουμε τιμή στη μεταβλητή του Νομού απο τη λίστα επιλογής
    $SelectedRegion = $_POST['NomosSelect'];

    //Αν έχει επιλεγεί στο φίλτρο νομός τότε προσθεσε το στο SQL Query
    if ($SelectedRegion>0){
        $sqlUsers=$sqlUsers." and u.FK_RegionID=".$SelectedRegion;
    }

    //Δίνουμε τιμή στη μεταβλητή του καύσιμου απο τη λίστα επιλογής
    $SelectedFuel= $_POST['FuelSelect'];

    //Αν έχει επιλεγεί στο φίλτρο καύσιμο τότε προσθεσε το στο SQL Query
    if ($SelectedFuel>0){
        $sqlUsers=$sqlUsers." and p.FK_FuelTypeID=".$SelectedFuel;
    }
}

//Πρόσθεσε στο τελικό SQL Query ταξινόμηση κατά τιμή
$sqlUsers=$sqlUsers." order by p.PromotionPrice asc";
?>

<main>

    <div class="container">
        <div class="text-left">
            <h1 class="fw-normal" style="font-size: 1.6em;margin-top: 1em;">Φίλτρα</h1>
        </div>

        <form method="post">
            <div class="row">
                <div class="col-4">
                    <select class="form-select" id="NomosSelect" name="NomosSelect">
                        <option selected="" value="0">Επιλογή Νομού...</option>

                        <?php
                        //Δημιουργία επιλογών απο τη Βάση Δεδομένων
                        while ($Nomoi = mysqli_fetch_array(
                            $AllNomoi, MYSQLI_ASSOC)):; ?>
                            <option value="<?php echo $Nomoi["RegionID"]; ?>">
                                <?php echo $Nomoi["RegionName"]; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-4">
                    <select class="form-select" id="FuelSelect" name="FuelSelect">
                        <option selected value="0">Επιλογή Καυσίμου...</option>

                        <?php
                        //Δημιουργία επιλογών απο τη Βάση Δεδομένων
                        while ($Fuel = mysqli_fetch_array(
                            $AllFuel, MYSQLI_ASSOC)):; ?>
                            <option value="<?php echo $Fuel["FuelTypeID"]; ?>">
                                <?php echo $Fuel["FuelTypeName"]; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Αν έχει γίνει αναζήτηση άλλαξε το όνομα του κουμπιού σε Προβολή όλων γιατί όταν ξαναπατηθεί θα
                     φέρει όλες τις εγγραφές. -->
                <div class="col-4">
                    <button type="submit" name="search-btn" class="btn btn-primary account">
                        <?php if ($SelectedRegion>0 || $SelectedFuel>0) {
                            echo "Προβολή όλων";
                        } else {
                            echo "Αναζήτηση";
                        }

                        ?>
                    </button>
                </div>
            </div>
        </form>
        <div class="text-left">
            <h1 class="fw-normal" style="font-size: 1.6em;margin-top: 1em;">Αποτελέσματα</h1>
        </div>
        <div style="height: 200px; overflow: auto">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ΑΑ</th>
                <th scope="col">Επωνυμία</th>
                <th scope="col">Διεύθυνση</th>
                <th scope="col">Τύπος Καυσίμου</th>
                <th scope="col">Τιμή</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($stmt = $conn->prepare($sqlUsers)) {
                $stmt->execute();
                $stmt->bind_result($PromotionID, $PromotionPrice, $PromotionEndDate, $FK_FuelTypeID, $FK_UserID, $FuelTypeName, $CompanyName, $CompanyAddress);
                $count = 0;

                while ($stmt->fetch()) {
                    //Μετρητής για να δώσει τιμή στο πεδίο ΑΑ
                    $count = $count + 1;

                    //Η προσφορά που έχει τη μικρότερη διαφορά από την ημερήσια μέση τιμή θα εμφανίζεται με πράσινο φόντο (background).
                    ?>

                    <tr>
                        <th scope="row"><?php echo $count ?></th>
                        <td><?php echo $CompanyName ?></td>
                        <td><a href="https://www.google.com/maps/place/<?php echo $CompanyAddress ?>"
                               target="_blank"><?php echo $CompanyAddress ?></a></td>
                        <td><?php echo $FuelTypeName ?></td>
                        <!-- Χρωματισμός της κατάλληλης τιμής -->
                        <td style="<?php if ($PromotionID == GetMinPromotion($FK_FuelTypeID)) { echo "background-color:#20c997;color: white";} ?>">
                            <?php echo $PromotionPrice ?> € /Λίτρο
                        </td>
                    </tr>
                    <?php
                }
                $stmt->close();
            }
            ?>
            </tbody>
        </table>

        </div>
        </div>
    <i>* Με πράσινο χρώμα εμφανίζονται οι προσφορές που πλησιάζουν την μέση τιμή πώλησης κάθε προϊόντος για την σημερινή ημέρα.</i>
</main>

<?php require "Templates/Footer.php";
?>
