<?php
//  Έλεγχος απο που ήρθε ο χρήστης. Αν ήρθε πατώντας το κουμπί Submit το οποίο και επιτρέπουμε ή μέσω του URL
// το οποίο δεν επιτρέπεται.
if (isset($_POST['login-btn'])) {
    require 'db.inc.php';

    $Username = $_POST['input-Username'];
    $Password = $_POST['input-Password'];

    //Ελέγχει αν τα πεδία είναι κενά και επιστρέφει τυχόν συμπληρωμένες τιμές στο querystring
    if (empty($Username) || empty($Password)) {
        header("Location: ../Login.php?error=empty-fields");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE UserName=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../Error.php?error=SQL Error");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $Username);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($Password, $row['Password'])) {
                    // Αν βρεθεί ο χρήστης και το password που έχει έρθειο είναι σωστό τότε δημιούργησε το session
                    // και αποθήκευσε στο session τα στοιχεία του χρήστη.
                    session_start();
                    $_SESSION['UserID'] = $row['UserID'];
                    $_SESSION['UserName'] = $row['UserName'];
                    $_SESSION['SystemRole'] = $row['SystemRole'];
                    $_SESSION['CompanyName'] = $row['CompanyName'];
                    $_SESSION['CompanyAddress'] = $row['CompanyAddress'];
                    $_SESSION['VAT'] = $row['VAT'];
                    $_SESSION['FK_RegionID'] = $row['FK_RegionID'];
                    $_SESSION['FK_MunicipalityID'] = $row['FK_MunicipalityID'];
                    $_SESSION['FK_FuelTypeID'] = $row['FK_FuelTypeID'];
                    //Κάνε redirect στη σελίδα και στείλε αντίστοιχη πληροφορία στο querystring
                    header("Location: ../index.php?Login=Success. New Session created!");
                    exit();
                } else {
                    //Το password που δόθηκε είναι λάθος, οπότε στείλε αντίστοιχη πληροφορία στο querystring
                    header("Location: ../Login.php?error=Wrong Password");
                    exit();
                }
            } else {
                //Το username που δόθηκε είναι λάθος, οπότε στείλε αντίστοιχη πληροφορία στο querystring
                header("Location: ../Login.php?error=No User");
                exit();
            }
        }
    }
} else {
    //Παρουσιάστηκε κάποιο γενικό πρόβλημα, οπότε στείλε αντίστοιχη πληροφορία στο querystring
    header("Location: ../Error.php?Error=Generic");
    exit();
}
