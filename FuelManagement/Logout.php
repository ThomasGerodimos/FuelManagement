<?php require "Templates/Header.php";
?>
<!-- Σελίδα αποσύνδεσης -->
<div class="container-fluid">
    <form class="needs-validation" action="Includes/logout.inc.php" method="post">
        <br/> <br/>

        <div class="alert alert-warning" role="alert">
            Είστε σίγουροι ότι θέλετε να αποσυνδεθείτε;
        </div>
        <br/>
        <div class="col-12" style="text-align: center">
            <button type="submit" name="logout-submit" class="btn btn-outline-primary">Αποσύνδεση</button>
        </div>

    </form>
</div>
