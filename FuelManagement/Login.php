<?php
require "Templates/Header.php";
?>
    <main>
    <div style="margin-top: 1em;">
        <h1 style="font-size:1.6em;margin-top: 0.5em;">Είσοδος Χρήστη</h1>
      </div>

        <?php
        // Προβολή λαθών στον χρήστη
        if(isset($_GET['error']))
        {
            $ErrorMessage="<h6>Έλεγχος ορθότητας δεδομένων:</h6><br/> ";
            if($_GET['error']=="empty-fields") {$ErrorMessage=$ErrorMessage."- Κάποια απο τα πεδία είναι κενά.<br/>";}
            if($_GET['error']=="SQL Error") {$ErrorMessage=$ErrorMessage."- Υπάρχει πρόβλημα με την Βάση Δεδομένων.<br/>";}
            if($_GET['error']=="No User") {$ErrorMessage=$ErrorMessage."- Δεν υπάρχει καταχωρημένος χρήστης με αυτά τα στοιχεία.<br/>";}
            if($_GET['error']=="Generic") {$ErrorMessage=$ErrorMessage."- Το πρόβλημα είναι άγνωστο, παρακαλώ επικοινωνήστε με τον διαχειριστή της εφαρμογής.<br/>";}
            if($_GET['error']=="Wrong Password") {$ErrorMessage=$ErrorMessage."- Το Όνομα Χρήστη ή ο Κωδικός είναι λάθος. Προσπαθήστε ξανά και αν το πρόβλημα παραμείνει, παρακαλώ επικοινωνήστε με τον διαχειριστή της εφαρμογής.<br/>";}
            if($_GET['error']=="No Authentication") {$ErrorMessage=$ErrorMessage."- Η συγκεκριμένη σελίδα είναι μόνο για εξουσιοδοτημένους χρήστες. <br/>Συμπληρώστε το Όνομα Χρήστη και τον Κωδικό πρόσβασης για να συνδεθείτε.<br/>";}

            echo '<div class="alert alert-danger w-75" role="alert">';
            echo   $ErrorMessage;
            echo '</div>';
        }
        ?>

      <form class="needs-validation" action="Includes/signin.inc.php" method="post" novalidate>
        <div class="row" style="margin-top: 2em;">
          <div class="col-3">
            <label class="form-label">Όνομα Χρήστη</label>
          </div>
          <div class="col-3">
            <input type="text" name="input-Username" class="form-control" required>
              <div class="invalid-feedback">
                  Το Όνομα Χρήστη είναι υποχρεωτικό πεδίο!
              </div>
          </div>
        </div>

        <div class="row" style="margin-top: 1em;">
          <div class="col-3">
            <label class="form-label">Κωδικός</label>
          </div>
          <div class="col-3">
            <input type="password" name="input-Password" class="form-control" maxlength="8" required>
              <div class="invalid-feedback">
                  Ο Κωδικός είναι υποχρεωτικό πεδίο!
              </div>
          </div>
        </div>

        <div class="row" style="margin-top: 1.5em;">
          <div class="col-3"></div>
          <div class="col-3" style="text-align: center;">
            <button type="submit" name="login-btn" class="btn btn-primary account" style="width: 200px;">Είσοδος</button><br><br>
            <a href="Register.php">Εγγραφή νέας Επιχείρησης</a>
          </div>
        </div>
      </form>
    </main>

<?php require "Templates/Footer.php";
?>