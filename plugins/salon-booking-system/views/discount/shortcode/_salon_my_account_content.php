
<div role="tabpanel" class="tab-pane sln-salon-my-account-tab-pane" id="discount">
    <div class="row sln-discounts-header">
        <div class="col-xs-6 col-sm-6 sln-discount-name"><strong><?php _e('Discount name', 'salon-booking-system') ?></strong></div>
        <div class="col-xs-6 col-sm-6 sln-discount-value"><strong><?php _e('Usage', 'salon-booking-system') ?></strong></div>
    </div>
    <?php foreach(SLN_Plugin::getInstance()->getRepository(SLB_Discount_Plugin::POST_TYPE_DISCOUNT)->getAll() as $discount): ?>
        <?php
        $discounted_booking = array();
        foreach($booking_history as $booking){
            if(get_post_meta($booking['id'], '_sln_booking_discount_'.$discount->getId(), true)){
                $discounted_booking[] = $booking;
            }
        }
        $errors = $discount->validateDiscountForMail((new DateTime())->getTimestamp(), $customer);
        if(count($discounted_booking) || empty($errors)): ?>
            <div class="discount-container">
                <div class="row">
                    <div class="col-xs-11 col-sm-10 sln-discount-content sln-discount-name">
                        <span class="sln-discount-btn sln-discount-icon--up hide"></span>
                        <span class="sln-discount-btn sln-discount-icon--down"></span>
                        <span class="sln-discount-icon--status sln-discount-icon--<?php echo empty($errors) ? 'active' : 'error' ?>"></span>
                        <?php echo $discount->getName(); ?>
                        <?php if(empty($errors)): ?>
                        -<span> <?php echo $discount->getAmountString() ?> </span> - 
                        <strong> <?php echo ($discount->getAmountType() == 'fixed')? __('automatic', 'salon-booking-system') : $discount->getCouponCode() ?> </strong>
                        -<span class="sln-discount-name--untile-date"> <?php echo __('until', 'salon-booking-system'). ' '. $plugin->format()->date($discount->getEndsAt()); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-1 col-sm-2 sln-discount-content sln-discount-value"><?php echo count($discounted_booking); ?></div>
                </div>
                <div class="collaps hide">
                    <div class="row sln-discounted-booking-table--header">
                        <div class="col-xs-4 col-sm-3 sln-discounted-booking-value"><strong><?php _e('Booking ID', 'salon-booking-system'); ?></strong></div>
                        <div class="col-xs-4 col-sm-3 sln-discounted-booking-value"><strong><?php _e('Booking date', 'salon-booking-system'); ?></strong></div>
                        <div class="col-xs-4 col-sm-3 sln-discounted-booking-value"><strong><?php _e('Status', 'salon-booking-system') ?></strong></div>
                    </div>
                    <?php foreach($discounted_booking as $booking): ?>
                        <div class="row sln-discounted-booking-table">
                            <div class="col-xs-4 col-sm-3 sln-discounted-booking-value">#<?php echo $booking['id']; ?></div>
                            <div class="col-xs-4 col-sm-3 sln-discounted-booking-value"><?php echo $booking['date']; ?></div>
                            <div class="col-xs-4 col-sm-3 sln-discounted-booking-value"><?php echo $booking['status']; ?></div>
                        </div>
                    <?php endforeach ;?>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>