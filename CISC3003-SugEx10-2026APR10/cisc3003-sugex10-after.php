<?php
include 'includes/book-utilities.inc.php';

$customers = readCustomers('data/customers.txt');

$selectedCustomerId = isset($_GET['customer_id']) ? $_GET['customer_id'] : null;

$selectedCustomer = null;
if ($selectedCustomerId && isset($customers[$selectedCustomerId])) {
    $selectedCustomer = $customers[$selectedCustomerId];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>CISC3003 Suggested Exercise 10 - DC227171 SEKI TOMOKI</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://fonts.loli.net/css?family=Roboto" type="text/css">
    <link rel="stylesheet" href="https://fonts.loli.net/icon?family=Material+Icons">

    <link rel="stylesheet" href="css/material.min.css">
    
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/demo-styles.css">
    
    <script src="https://cdn.bootcdn.net/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script src="https://cdn.bootcdn.net/ajax/libs/material-design-lite/1.1.3/material.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
    
    <script>
        $(function() {
            $('.sparkline').sparkline('html', {
                type: 'bar', 
                barColor: '#1e88e5', 
                height: '20px', 
                barWidth: 4
            });
        });
    </script>
</head>

<body>
    
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
            
    <?php include 'includes/header.inc.php'; ?>
    <?php include 'includes/left-nav.inc.php'; ?>
    
    <main class="mdl-layout__content mdl-color--grey-50">
        <section class="page-content">
            <div class="mdl-grid">

              <div class="mdl-cell mdl-cell--7-col card-lesson mdl-card mdl-shadow--2dp">
                <div class="mdl-card__title mdl-color--orange">
                  <h2 class="mdl-card__title-text">Customers</h2>
                </div>
                <div class="mdl-card__supporting-text">
                    <table class="mdl-data-table mdl-shadow--2dp" style="width: 100%;">
                      <thead>
                        <tr>
                          <th class="mdl-data-table__cell--non-numeric">Name</th>
                          <th class="mdl-data-table__cell--non-numeric">University</th>
                          <th class="mdl-data-table__cell--non-numeric">City</th>
                          <th>Sales</th>
                        </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($customers as $customer): ?>
                          <tr>
                              <td class="mdl-data-table__cell--non-numeric">
                                  <a href="?customer_id=<?= $customer['id'] ?>">
                                      <?= $customer['firstName'] . ' ' . $customer['lastName'] ?>
                                  </a>
                              </td>
                              <td class="mdl-data-table__cell--non-numeric"><?= $customer['university'] ?></td>
                              <td class="mdl-data-table__cell--non-numeric"><?= $customer['city'] ?></td>
                              <td><span class="sparkline"><?= $customer['sales'] ?></span></td>
                          </tr>
                          <?php endforeach; ?>
                      </tbody>
                    </table>
                </div>
              </div>  
              
              <div class="mdl-grid mdl-cell--5-col" style="padding: 0; margin: 0;">
    
                  <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                      <h2 class="mdl-card__title-text">Customer Details</h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <?php if ($selectedCustomer): ?>
                            <h4><?= $selectedCustomer['firstName'] . ' ' . $selectedCustomer['lastName'] ?></h4>
                            <p><strong>Email:</strong> <?= $selectedCustomer['email'] ?></p>
                            <p><strong>University:</strong> <?= $selectedCustomer['university'] ?></p>
                            <p><strong>Address:</strong> <?= $selectedCustomer['address'] ?>, <?= $selectedCustomer['city'] ?>, <?= $selectedCustomer['state'] ?>, <?= $selectedCustomer['country'] ?>, <?= $selectedCustomer['zip'] ?></p>
                            <p><strong>Phone:</strong> <?= $selectedCustomer['phone'] ?></p>
                        <?php else: ?>
                            <p>Select a customer to view details.</p>
                        <?php endif; ?>
                    </div>    
                  </div>  

                  <div class="mdl-cell mdl-cell--12-col card-lesson mdl-card mdl-shadow--2dp">
                    <div class="mdl-card__title mdl-color--deep-purple mdl-color-text--white">
                      <h2 class="mdl-card__title-text">Order Details</h2>
                    </div>
                    <div class="mdl-card__supporting-text">       
                        
                        <table class="mdl-data-table mdl-shadow--2dp" style="width: 100%;">
                          <thead>
                            <tr>
                              <th class="mdl-data-table__cell--non-numeric">Cover</th>
                              <th class="mdl-data-table__cell--non-numeric">ISBN</th>
                              <th class="mdl-data-table__cell--non-numeric">Title</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if ($selectedCustomer): ?>
                                <?php 
                                $orders = readOrders($selectedCustomerId, 'data/orders.txt'); 
                                ?>
                                
                                <?php if (count($orders) > 0): ?>
                                    <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td class="mdl-data-table__cell--non-numeric">
                                            <img src="images/tinysquare/<?= $order['isbn'] ?>.jpg" alt="Book Cover" style="width: 50px;">
                                        </td>
                                        <td class="mdl-data-table__cell--non-numeric"><?= $order['isbn'] ?></td>
                                        <td class="mdl-data-table__cell--non-numeric"><?= $order['title'] ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="mdl-data-table__cell--non-numeric">
                                            No orders for this customer.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                          </tbody>
                        </table>

                    </div>    
                   </div> 
               </div>   
            </div>  
        </section>

        <footer class="site-footer">
            CISC3003 Web Programming: DC227171 SEKI TOMOKI 2026
        </footer>
        
    </main>    
</div>    
          
</body>
</html>