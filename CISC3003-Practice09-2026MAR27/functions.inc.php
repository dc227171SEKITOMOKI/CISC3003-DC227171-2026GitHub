<?php
function outputOrderRow($file, $title, $quantity, $price) {
    $amount = $quantity * $price;
    
    echo "<tr>";
    echo "<td class=\"mdl-data-table__cell--non-numeric\"><img src=\"images/books/tinysquare/{$file}\" alt=\"Cover\"></td>";
    echo "<td class=\"mdl-data-table__cell--non-numeric\">{$title}</td>";
    echo "<td>{$quantity}</td>";
    echo "<td>" . $price . "</td>";
    echo "<td>$" . number_format($amount, 2) . "</td>";
    echo "</tr>";
}
?>