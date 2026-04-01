<?php

include 'data.inc.php'; 
include 'functions.inc.php';

$subtotal = ($quantity1 * $price1) + ($quantity2 * $price2) + ($quantity3 * $price3) + ($quantity4 * $price4);

$shipping = ($subtotal > 10000) ? 100 : 200;

$grandTotal = $subtotal + $shipping;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CISC3003 Practice 09</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700,italic' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://cdn.bootcdn.net/ajax/libs/material-design-lite/1.3.0/material.blue_grey-orange.min.css" rel="stylesheet">
    <script defer src="https://cdn.bootcdn.net/ajax/libs/material-design-lite/1.3.0/material.min.js"></script>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
            
  <?php include 'header.inc.php'; ?>
  
  <?php include 'left.inc.php'; ?>
  
  <main class="mdl-layout__content">
    <div class="page-content">
        <header class="page-header">
          <h2>Order Summaries</h2>
          <p>Examine your customer orders</p>
        </header>   
        
        <section class="mdl-grid">
            <div class="mdl-cell mdl-cell--3-col">
                <div class="mdl-card mdl-shadow--2dp card-my-orders">
                  <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">My Orders</h2>
                  </div>
                  <div class="mdl-card__supporting-text">            
                      <ul class="order-links">
                          <?php
                          for ($i = 500; $i <= 540; $i += 10) {
                              echo "<li><a href=\"#\">Order #{$i}</a></li>";
                          }
                          ?>
                      </ul>   
                  </div>    
                </div>
            </div> 

            <div class="mdl-cell mdl-cell--9-col">
                <div class="mdl-card mdl-shadow--2dp card-selected-order">
                  <div class="mdl-card__title">
                    <h2 class="mdl-card__title-text">Selected Order: #520</h2>
                  </div>
                  <div class="mdl-card__supporting-text table-container">
                      <div class="customer-info">
                          Customer: <strong>Mount Royal University</strong>
                      </div>
                      <table class="mdl-data-table mdl-js-data-table">
                        <thead>
                          <tr>
                            <th class="mdl-data-table__cell--non-numeric">Cover</th>
                            <th class="mdl-data-table__cell--non-numeric">Title</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                                  
                        <tbody>
                          <?php
                          outputOrderRow($file1, $title1, $quantity1, $price1);
                          outputOrderRow($file2, $title2, $quantity2, $price2);
                          outputOrderRow($file3, $title3, $quantity3, $price3);
                          outputOrderRow($file4, $title4, $quantity4, $price4);
                          ?>
                        </tbody>
                        <tfoot>
                            <tr class="totals">
                                <td colspan="4">Subtotal</td>
                                <td>$<?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                            <tr class="totals">
                                <td colspan="4">Shipping</td>
                                <td>$<?php echo number_format($shipping, 2); ?></td>
                            </tr> 
                            <tr class="grandtotals">
                                <td colspan="4">Grand Total</td>
                                <td>$<?php echo number_format($grandTotal, 2); ?></td>
                            </tr>                            
                        </tfoot>
                      </table>
                  </div>
                </div>
            </div> 
        </section>
    </div>
  </main>
</div>
</body>
</html>