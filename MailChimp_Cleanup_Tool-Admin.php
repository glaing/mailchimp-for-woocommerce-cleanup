<div class="wrap">
  <h2>MailChimp for WooCommerce - Cleanup Tool</h2>
  <p>This tool has been created to search for orders where the customer has not opted in to be a MailChimp subscriber. These customers were previously being imported by the MailChimp for WooCommerce Plugin from MailChimp.</p>
  <p>Please check through the data carefully before importing the unsubscribe list into MailChimp to prevent users being accidently unsubscribed.</p>
  <p>Note: This tool cannot check to see if users have signed up to the MailChimp using any other method than the Subscribe option on your checkout page. If a customer has joined your mailing list through another method, but then not opted in during checkout, they will be removed.</p>
  
   <?php
        $data = $_POST;
        $mode = $_GET["mode"];

        if($mode == "list") {
            ?> 
 
            <p>Click <a href="https://us3.admin.mailchimp.com/lists" target="_blank">https://us3.admin.mailchimp.com/lists</a> and go to your chosen list.</p>
            <p>Then go to 'Manage contacts' and click 'Unsubscribe addresses'.</p>
            <p>Scroll to the bottom of the page, click below and then paste in the box on the Unsubscribe People page.</p>
            
            <script src="https://cdn.jsdelivr.net/npm/clipboard@1/dist/clipboard.min.js"></script>
            <style>
                div#unsubscribes ul li {margin:0;}
            </style>
            <div id="unsubscribes">

                <?php
                echo '<ul>';
                $removing = 0;
                foreach( $data as $order ){
                    
                    foreach ($order as $number => $email) {
                        echo '<li>' . $email . '</li>';
                        $removing+= 1;
                    }

                }
                echo '</ul></div>';
                echo '<h3>Removing ' . $removing . ' Subscribers</h3>';
            ?> 
            
            <p><a class="copy-button" data-clipboard-action="copy" data-clipboard-target="#unsubscribes">Copy</a><script>var clipboard = new Clipboard('.copy-button');</script></p>
            
            

        <?php

        } else {
    
            if( !empty($data) ) { 
            ?>
                <style>
                    table {width:100%!important;}
                    table tr:first-of-type td{font-weight:700;}
                    td.optout {font-weight: 700;color: #F44336;}
                </style>

                <p>Untick any customers that you don't want to unsubscribe and then scroll to the bottom and click 'Create Unsubsriber List'.</p>
                <form action="<?php echo admin_url();?>tools.php?page=mailchimp-cleanup&mode=list" method="POST">
                <ul>
                <?php
                
                    $subscriber = 0;
                    $orders = 0;
                
                    foreach( $data as $customer => $order_id ){
                        echo '<li>';
                        echo '<h3>';
                        echo 'Customer ID: ' . $customer;
                        echo '</h3>';
                        echo '<table>';
                        echo "<tr><td>Order Number</td><td>Date</td><td>Value</td><td>Status</td><td>Opted In?</td><td>Email Address</td><td>WooCommerce Customer ID</td></tr>";
                        $sub = 0;
                        $subscriber+= 1;
    
                        foreach ($order_id as $id => $check ){
                            $order = wc_get_order( $id );
                            echo "<tr>";
                            echo '<td>'. $id . "</td>";
                            echo '<td>'. date_format($order->get_date_created() , "d-m-Y") . "</td>";
                            echo '<td>'. $order->get_total() . "</td>";
                            echo '<td>'. $order->get_status() . "</td>";
                            echo '<td>'. $check . "</td>";
                            echo '<td>'. $order->get_billing_email() . "</td>";
                            
                            if ($order->get_customer_id() == 0 ) {
                                echo '<td>Guest</td>';
                            } else {
                                echo '<td>'. $order->get_customer_id() . "</td>";
                            }
                            
                            echo '</tr>';
                            $sub+= $check;
                            $orders+= 1;
                        }
        
                        echo '<tr><td>Remove from list?</td><td>';
        
                        if ( $sub > 0 ) {
                            echo '<input name="' . $order->id . '[]" value="'. $order->billing_email . '" type="checkbox"></td><td colspan="5">User has opted in to the mailing list at some point.</td>';
                        } else {    
                            echo '<input name="' . $order->id . '[]" value="'. $order->billing_email . '" type="checkbox" checked></td><td class="optout" colspan="5">User has NOT opted in to the mailing list.</td>';
                        }
        
                        echo '</td></tr>';
                        echo '</table>';
                        echo '</li>';
                    }
                    
                    
                    echo '</ul>';
                    echo '<h3>Total Orders: ' . $orders . '</h3>';
                    echo '<h3>Total Unique Customer Email Addresses: ' . $subscriber . '</h3>';
                    echo '<button type="submit">Create List</button></form></div>';
    
    
            } else { 
 
                $args = array(
		            'limit' => -1,
		        );
                
                $orders = wc_get_orders( $args );
                ?>

                <form action="<?php echo admin_url();?>tools.php?page=mailchimp-cleanup" method="POST">

                <?php
		
                    foreach( $orders as $order ) {
                        $mc_opt = $order->get_meta('mailchimp_woocommerce_is_subscribed');
                        echo '<input name="'. $order->billing_email . '[' . $order->ID . ']" type="hidden" value="' . $mc_opt . '">';
                    }
                ?>
                <button type="submit">Start</button>  
                </form>
                <?php
                
            }
        }
        ?>
        </div>
