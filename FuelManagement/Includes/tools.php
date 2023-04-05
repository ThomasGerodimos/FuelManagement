<?php

/* Δεν χρησιμοποιήθηκε τελικά
 * function GetDailyAverage($FuelID) {
    require 'Includes\db.inc.php';

    $query = "select cast(avg(p.promotionPrice) as decimal(15,4)) as Average from vwactivepromotions as p inner join fueltypes as f on p.FK_FuelTypeID = f.FuelTypeID group by p.FK_FuelTypeID having p.FK_FuelTypeID=".$FuelID;
    $stmt = mysqli_stmt_init($conn);

    if ($stmt = $conn->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($Average);
        while ($stmt->fetch()) {
            echo $Average;
        }
        $stmt->close();
    }

}*/

function GetMinPromotion($FuelID) {
    require 'Includes\db.inc.php';

    $query = "SELECT promotionID FROM minprice as m where m.FK_FuelTypeID=".$FuelID;
    $stmt = mysqli_stmt_init($conn);

    if ($stmt = $conn->prepare($query)) {
        $stmt->execute();
        $stmt->bind_result($promotionID);
        while ($stmt->fetch()) {
            return $promotionID;
        }
        $stmt->close();
    }

}