<?php
require "Templates/Header.php";
require "Includes/db.inc.php";
?>

    <main>
        <div class="text-center">
            <h1 class="display-6 fw-normal" style="margin: 0.5em;">Ημερήσια σύνοψη τιμών</h1>
        </div>

        <!-- Στατιστικά στοιχεία αναφορικά με την ελάχιστη/μέγιστη/μέση τιμή ανά τύπο καύσιμου για την τρέχουσα μέρα.-->
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <h3 style="font-size:1.5em">Τρέχουσα Ημερομηνία:</h3>
                </div>
                <div class="col-3">
                    <h3 style="font-size:1.6em">
                        <span class="badge bg-warning">
                            <!-- Εισαγωγή τρέχουσας ημερομηνίας -->
                            <?php echo date("d/m/yy"); ?>
                        </span>
                    </h3>
                </div>
            </div>
            <br/>

            <?php
            // SQL Query όπου επιστρέφει την ελάχιστη, μέση και μεγιστη τιμή ανα είδος καυσίμου
            $query = "select f.FuelTypeName,cast(min(p.promotionPrice) as decimal(15,3)) as Minimum, cast(avg(p.promotionPrice) as decimal(15,3)) as Average, cast(max(p.promotionPrice) as decimal(15,3)) as Maximum from vwactivepromotions as p inner join fueltypes as f 	on p.FK_FuelTypeID = f.FuelTypeID group by p.FK_FuelTypeID";
            $stmt = mysqli_stmt_init($conn);

            // Αν παρουσιαστεί κάποιο γενικό πρόβλημα και δε γίνει η σύνδεση στη Βάση Δεδομένων πήγαινε στη σελίδα λάθους
            if (!mysqli_stmt_prepare($stmt, $query)) {
                header("Location: ../Error.php?error=SQL Error");
                exit();
            } else {
                //Αν όλα πάνε καλά εκτέλεσε το query και επέστρεψε τα αποτελέσματα
                if ($stmt = $conn->prepare($query)) {
                    $stmt->execute();
                    $stmt->bind_result($FuelTypeName, $Minimum, $Average, $Maximum);
                    mysqli_stmt_store_result($stmt);
                    $resultCheck = mysqli_stmt_num_rows($stmt);
                    //Έλεγξε αν υπάρχουν καταχωρημένες προσφορές
                    if ($resultCheck == 0) {
                        ?>
                        <div class="alert alert-warning" role="alert" style="text-align: center">
                            Δεν υπάρχουν καταχωρημένες προσφορές για την σημερινή ημέρα.
                        </div>
                        <?php
                    }
                    while ($stmt->fetch()) {
                        ?>
                        <!-- Εμφάνισε τα αποτελέσματα σε κάρτες -->
                        <div class="row">
                            <div class="col">
                                <h2 class="fuel"><?php echo $FuelTypeName; ?>
                                </h2>
                            </div>

                            <div class="col">
                                <div class="card" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title" style="text-align: center;">Ελάχιστη</h5>
                                        <p class="card-text"
                                           style="text-align: center;color: green;">
                                            <?php echo $Minimum . " €/λίτρο</p>" ?>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card" style="width: 18rem;">

                                    <div class="card-body">
                                        <h5 class="card-title" style="text-align: center;">Μέση</h5>
                                        <p class="card-text"
                                           style="text-align: center;color:#035078"><?php echo $Average; ?> €/λίτρο</p>

                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card" style="width: 18rem;">

                                    <div class="card-body">
                                        <h5 class="card-title" style="text-align: center;">Μέγιστη</h5>
                                        <p class="card-text"
                                           style="text-align: center;color: orangered;"><?php echo $Maximum; ?>
                                            €/λίτρο</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <?php
                    }
                }
                //Κλείσε το statement
                $stmt->close();
            }
            ?>


            <div class="mx-auto text-center" style="margin-top: 5em;">
                <h1 class="display-6 fw-normal">Τελευταίες Ανακοινώσεις</h1>
            </div>
            <div class="list-group">
                <!--  Προβολή των τριών πιο πρόσφατων ανακοινώσεων με τους αντίστοιχους υπερσυνδέσμους στην σελίδα των ανακοινώσεων.-->
                <?php
                $query2 = "SELECT CreationDate, AnnouncementTitle,AnnouncementContent FROM Announcements order by CreationDate desc LIMIT 3";
                $stmt2 = mysqli_stmt_init($conn);

                //Αν όλα πάνε καλά εκτέλεσε το query και επέστρεψε τα αποτελέσματα
                if (!mysqli_stmt_prepare($stmt2, $query2)) {
                    header("Location: ../Error.php?error=SQL Error");
                    exit();
                } else {
                    if ($stmt2 = $conn->prepare($query2)) {
                        $stmt2->execute();
                        $stmt2->bind_result($CreationDate, $AnnouncementTitle, $AnnouncementContent);
                        mysqli_stmt_store_result($stmt2);
                        $resultCheck2 = mysqli_stmt_num_rows($stmt2);

                        //Έλεγξε αν υπάρχουν καταχωρημένες ανακοινώσεις
                        if ($resultCheck2 == 0) {
                            ?>
                            <div class="alert alert-warning" role="alert" style="text-align: center">
                                Δεν υπάρχουν καταχωρημένες ανακοινώσεις.
                            </div>
                            <?php
                        }
                        while ($stmt2->fetch()) {
                            ?>

                            <!-- Εμφάνισε τα αποτελέσματα σε κάρτες -->
                            <div class="list-group-item list-group-item-action">
                                <h3 style="font-size: 1.3em;"><?php echo $CreationDate ?></h3>
                                <h2 style="font-size: 1.2em;">
                                    <a href="Announcements.php">
                                        <b>
                                            <?php echo $AnnouncementTitle ?>
                                        </b>
                                    </a>
                                </h2>
                            </div>
                            <?php

                        }
                        $stmt2->close();
                    }
                }
                ?>
            </div>
    </main>

<?php require "Templates/Footer.php"; ?>