<!-- New Announcement Modal -->
<div class="modal fade" id="NewPostModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Νέα Ανακοίνωση</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" method="post" action="Includes/Announcement.inc.php"  novalidate>
            <div class="modal-body">

                    <div class="row">
                        <input type="hidden" value="<?php echo $_SESSION['UserID'] ?>" name="UserID"/>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">Ημερομηνία</label>
                        </div>
                        <div class="col-5">
                            <input type="date" id="disabledTextInput" name="newPostDate" class="form-control w-50" required>
                            <div class="invalid-feedback">
                                Η Ημερομηνία είναι υποχρεωτικό πεδίο!
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">Τίτλος</label>
                        </div>
                        <div class="col-5">
                            <input type="text" class="form-control" style="width: 30em"  name="newPostTitle" maxlength="500" required>
                            <div class="invalid-feedback">
                                Ο Τίτλος είναι υποχρεωτικό πεδίο!
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">Περιεχόμενο</label>
                        </div>
                        <div class="col-5">
                            <textarea type="text" class="form-control" style="width: 30em" name="newPostContent" maxlength="2000" required></textarea>
                            <div class="invalid-feedback">
                                Ο Τίτλος είναι υποχρεωτικό πεδίο!
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Άκυρο</button>
                <button type="submit" class="btn btn-primary" name="save-new-post">Αποθήκευση</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Announcement Modal -->
<div class="modal fade" id="<?php echo "edit_".$row['AnnouncementID']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="ModalLabel">Επεξεργασία Ανακοίνωσης </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" method="post" action="Includes/Announcement.inc.php" novalidate>
            <div class="modal-body">

                    <div class="row">
                        <input type="hidden" value="<?php echo $_SESSION['UserID'] ?>" name="UserID"/>
                        <input type="hidden" value="<?php echo $row['AnnouncementID']; ?>" name="AnnouncementID"/>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">Ημερομηνία</label>
                        </div>
                        <div class="col-5">
                            <input type="date" name="EditPostDate"
                                   value="<?php echo $row['CreationDate']; ?>"
                                   class="form-control w-50" required>
                            <div class="invalid-feedback">
                                Η Ημερομηνία είναι υποχρεωτικό πεδίο!
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">Τίτλος</label>
                        </div>
                        <div class="col-5">
                            <input type="text" class="form-control" style="width: 30em" value="<?php echo $row['AnnouncementTitle']; ?>"
                                   name="EditPostTitle" maxlength="100" required>
                            <div class="invalid-feedback">
                                Ο Τίτλος είναι υποχρεωτικό πεδίο!
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <label class="form-label">Περιεχόμενο</label>
                        </div>
                        <div class="col-5">
                            <textarea name="EditPostContent" type="text"  class="form-control" style="width: 30em; height:15em" maxlength="100" required><?php echo $row['AnnouncementContent']; ?></textarea>
                            <div class="invalid-feedback">
                                To περιεχόμενο είναι υποχρεωτικό πεδίο!
                            </div>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Άκυρο</button>
                <button type="submit" class="btn btn-primary" name="update-new-post">Ενημέρωση</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Announcement Modal-->
<div class="modal fade" id="<?php echo "delete_".$row['AnnouncementID']; ?>" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Διαγραφή Ανακοίνωσης</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" method="post" action="Includes/Announcement.inc.php" novalidate>
            <div class="modal-body">
                <input type="hidden" value="<?php echo $row['AnnouncementID']; ?>" name="DeleteAnnouncementID"/>
                <p class="alert alert-warning">Είστε σίγουροι ότι θέλετε να διαγράψετε την ανακοίνωση;</p>
                <p><b>Τίτλος</b>: <?php echo $row['AnnouncementTitle'] ?></p>
                <p><b>Ημερομηνία ανάρτησης</b>: <?php echo $row['CreationDate']; ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger" name="delete-post">Οριστική Διαγραφή</button>
            </div>
            </form>
        </div>
    </div>
</div>