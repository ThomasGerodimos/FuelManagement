<?php

    require 'db.inc.php';

if (isset($_POST['save-new-post'])) {
    $UserID= $_POST['UserID'];
    $newPostDate = $_POST['newPostDate'];
    $newPostTitle = $_POST['newPostTitle'];
    $newPostContent=$_POST['newPostContent'];

    //Προσθήκη ανακοίνωσης
    $sql = "INSERT INTO announcements (CreationDate,AnnouncementTitle,AnnouncementContent,FK_UserID) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../Announcements.php?error=SQL Error");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"sssi",$newPostDate,$newPostTitle,$newPostContent,$UserID);
        mysqli_stmt_execute($stmt);

        header("Location: ../Announcements.php?AnnouncementInserted=Success");
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

if (isset($_POST['update-new-post'])) {
    $UserID= $_POST['UserID'];
    $AnnouncementID = $_POST['AnnouncementID'];
    $EditPostDate = $_POST['EditPostDate'];
    $EditPostTitle = $_POST['EditPostTitle'];
    $EditPostContent=$_POST['EditPostContent'];

    //Ενημέρωση ανακοίνωσης
    $sql = "UPDATE announcements SET CreationDate=?,AnnouncementTitle=?,AnnouncementContent=? WHERE AnnouncementID=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../Announcements.php?error=SQL Error");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"sssi",$EditPostDate,$EditPostTitle,$EditPostContent,$AnnouncementID);
        mysqli_stmt_execute($stmt);

        header("Location: ../Announcements.php?AnnouncementUpdated=Success");
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

if (isset($_POST['delete-post'])) {

    $AnnouncementID = $_POST['DeleteAnnouncementID'];

    //Διαγραφή ανακοίνωσης
    $sql = "DELETE FROM announcements WHERE AnnouncementID=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt,$sql)) {
        header("Location: ../Announcements.php?error=SQL Error");
        exit();
    }
    else {
        mysqli_stmt_bind_param($stmt,"i",$AnnouncementID);
        mysqli_stmt_execute($stmt);

        header("Location: ../Announcements.php?AnnouncementDeleted=Success");
        exit();
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}






