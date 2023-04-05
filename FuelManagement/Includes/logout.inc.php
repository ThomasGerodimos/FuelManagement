<?php
// Καθαρισμός του Session και redirect στην αρχική σελίδα
session_start();
session_unset();
session_destroy();
header("Location:../index.php");