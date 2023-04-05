<?php
// Έναρξη Seesion χρήστη
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ΠΛΗ23 - 3η Γραπτή Εργασία ">
    <meta name="author" content="Thomas Gerodimos - std137585">
    <title>Fuel Oil</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link href="CSS/MyStyles.css" rel="stylesheet">
    <!-- Βοοτστραπ JS   -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
            crossorigin="anonymous"></script>
</head>


<body>

<!-- Αυτό είναι το κεντρικό container -->
<div class="container">
    <!-- Αυτό είναι το header της ιστοσελίδας -->
    <header>
        <div class="text-center">
            <div class="row">
                <div class="col-6"></div>
                <div class="col-6 text-sm-end  account-links">
                    <i><?php
                        // Εδώ ελέγχουμε αν ο χρήστης είναι συνδεδεμένος ώστε να εμφανίσουμε ενα μήνυμα καλωσορίσματος και
                        // δυνατότητα αποσύνδεσης. Αν δεν είναι συνδεδεμένος εμφανίζουμε 2 κουμπιά για σύνδεση και εγγραφή
                        if (isset($_SESSION['UserID'])) {
                            echo '<h4>Καλωσήρθες </br>' . $_SESSION['CompanyName'] . '</h4>
                  <a class="btn btn-primary account" href="Logout.php">Αποσύνδεση</a>';
                        } else {
                            echo '<a class="btn btn-primary account" href="Login.php">Σύνδεση</a>
                        <a class="btn btn-primary account" href="Register.php">Εγγραφή</a>';

                        }
                        ?></i>
                </div>
            </div>
            <div class="row">
                <div class="col-3 logo">
                    <a href="Index.php">
                        <img src="Images/fuel-logo.webp" width="250px"/>
                    </a>
                </div>

                <div class="col center-vertical">
                    <h2 class="header-title">Προσφορές πώλησης Υγρών Καυσίμων</h2>
                </div>
            </div>
        </div>

        <!-- Αυτό είναι το μενού της εφαρμογής. Κάθε επιλογή ενεργοποιείται και είναι με άλλο χρώμα
        ανάλογα τη σελίδα που είναι ο χρήστης. -->

        <nav class="navbar navbar-expand-lg navbar-light bg-light" style="margin-top: 2em;">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "Index.php") {
                    echo "active";
                } ?>">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "Index.php") {
                        echo 'active';
                    } ?>" href="Index.php">Αρχική</a>
                </li>
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "Search.php") {
                    echo "active";
                } ?>">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "Search.php") {
                        echo "active";
                    } ?>" href="Search.php">Αναζήτηση</a>
                </li>
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "Promotion.php") {
                    echo "active";
                } ?>">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "Promotion.php") {
                        echo "active";
                    } ?>" href="Promotion.php">Καταχώρηση</a>
                </li>
                <li class="nav-item <?php if (basename($_SERVER['PHP_SELF']) == "Announcements.php") {
                    echo "active";
                } ?>">
                    <a class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == "Announcements.php") {
                        echo "active";
                    } ?>" href="Announcements.php">Ανακοινώσεις</a>
                </li>
            </ul>
        </nav>
    </header>
