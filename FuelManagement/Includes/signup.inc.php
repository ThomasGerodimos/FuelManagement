<?php

//  Έλεγχος απο που ήρθε ο χρήστης. Αν ήρθε πατώντας το κουμπί Submit ή μέσω του URL.
if (isset($_POST['new-business-register'])) {

    require 'db.inc.php';

    $CompanyName = $_POST['CompanyName'];
    $VAT = $_POST['VAT'];
    $CompanyAddress = $_POST['CompanyAddress'];
    $FK_RegionID = $_POST['FK_RegionID'];
    $FK_MunicipalityID = $_POST['FK_MunicipalityID'];
    $FK_FuelTypeID = $_POST['FK_FuelTypeID'];
    $Email = $_POST['Email'];
    $UserName = $_POST['UserName'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];
    $PasswordRegex = "/^(?=.*\d)(?=.*[A-Z])[a-zA-Z\d]{8}$/";



#   Ελέγχει αν τα πεδία είναι κενά και επιστρέφει τυχόν συμπληρωμένες τιμές στο querystring
   if (empty($CompanyName) || empty($VAT) || empty($CompanyAddress) || empty($FK_RegionID) || empty($FK_MunicipalityID) || empty($Email) || empty($UserName) || empty($Password) || empty($ConfirmPassword)){
        header("Location: ../Register.php?error=emptyfields&VAT=".$VAT."&mail=".$Email."&username=".$UserName."&Companyname=".$CompanyName."&companyadress=".$CompanyAddress);
        exit();
   } 
   # Ελέγχει αν το email είναι σωστό
   else if(!filter_var($Email,FILTER_VALIDATE_EMAIL)) {
        header("Location: ../Register.php?error=invalid email");
        exit();
   }
   #Ελέγχει αν το password πληρεί τις προδιαγραφές
   else if(!preg_match($PasswordRegex, $Password)) {
       header("Location: ../Register.php?error=invalid-password");
       exit();
   }
   #Ελέγχει αν το password και η επιβεβαίωση είναι τα ίδια
   else if($Password !== $ConfirmPassword) {
        header("Location: ../Register.php?error=password-check");
        exit();
    }
    # Ελέγχει αν το username υπάρχει ήδη
    else {
        $sql = "SELECT VAT FROM users where VAT=?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt,$sql)) {
            header("Location: ../Register.php?error=SQL Error");
            exit();
        }
        else {
            mysqli_stmt_bind_param($stmt,"s",$VAT);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
               header("Location: ../Register.php?error=VAT already Taken&VAT=".$VAT."&mail=".$Email."&username=".$UserName."&CompanyName=".$CompanyName."&CompanyAddress=".$CompanyAddress);
                exit();
            }
            else {
                //Προσθήκη χρήστη
                $sql = "INSERT INTO users(UserName,Password,CompanyName,CompanyAddress,SystemRole,VAT,Email,FK_RegionID,FK_MunicipalityID,FK_FuelTypeID) VALUES(?,?,?,?,2,?,?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt,$sql)) {
                    header("Location: ../Error.php?error=SQL Error");
                    exit();
                }
                else {
                    //Κρυπτογράφηση του κωδικού για ασφάλεια
                    $hashedPwd = password_hash($Password,PASSWORD_DEFAULT);
                    mysqli_stmt_bind_param($stmt,"ssssisiii",$UserName,$hashedPwd,$CompanyName,$CompanyAddress,$VAT,$Email,$FK_RegionID,$FK_MunicipalityID,$FK_FuelTypeID);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../Register.php?register=Success");
                    exit();
                }
            }
        }

    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

}
else {
    header("Location: ../Register.php");
    exit();
}