//registrar automaticamente un usuario con el pedido

function wc_register_guests( $order_id ) {
            // get all the order data
            $order = new WC_Order($order_id);
  
            //get the user email from the order
            $order_email = $order->billing_email;
    
            // check if there are any users with the billing email as user or email
            $email = email_exists( $order_email );  
            $user = username_exists( $order_email );
  
            // if the UID is null, then it's a guest checkout
            if( $user == false && $email == false ){
    
            // random password with 12 chars
            $random_password = 'cambiar';
    
            // create new user with email as username & newly created pw
            $user_id = wp_create_user( $order_email, $random_password, $order_email );
    
            //WC guest customer identification
            update_user_meta( $user_id, 'guest', 'yes' );
 
            //user's billing data
            update_user_meta( $user_id, 'billing_address_1', $order->billing_address_1 );
            update_user_meta( $user_id, 'billing_address_2', $order->billing_address_2 );
            update_user_meta( $user_id, 'billing_city', $order->billing_city );
            update_user_meta( $user_id, 'billing_company', $order->billing_company );
            update_user_meta( $user_id, 'billing_country', $order->billing_country );
            update_user_meta( $user_id, 'billing_email', $order->billing_email );
            update_user_meta( $user_id, 'billing_first_name', $order->billing_first_name );
            update_user_meta( $user_id, 'billing_last_name', $order->billing_last_name );
            update_user_meta( $user_id, 'billing_phone', $order->billing_phone );
            update_user_meta( $user_id, 'billing_postcode', $order->billing_postcode );
            update_user_meta( $user_id, 'billing_state', $order->billing_state );
 
            // user's shipping data
            update_user_meta( $user_id, 'shipping_address_1', $order->shipping_address_1 );
            update_user_meta( $user_id, 'shipping_address_2', $order->shipping_address_2 );
            update_user_meta( $user_id, 'shipping_city', $order->shipping_city );
            update_user_meta( $user_id, 'shipping_company', $order->shipping_company );
            update_user_meta( $user_id, 'shipping_country', $order->shipping_country );
            update_user_meta( $user_id, 'shipping_first_name', $order->shipping_first_name );
            update_user_meta( $user_id, 'shipping_last_name', $order->shipping_last_name );
            update_user_meta( $user_id, 'shipping_method', $order->shipping_method );
            update_user_meta( $user_id, 'shipping_postcode', $order->shipping_postcode );
            update_user_meta( $user_id, 'shipping_state', $order->shipping_state );
    
            // link past orders to this newly created customer
            wc_update_new_customer_past_orders( $user_id );
        }
  
        }
//add this newly created function to the thank you page
add_action( 'woocommerce_thankyou', 'wc_register_guests', 10, 1 );
