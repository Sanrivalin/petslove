<div class="row">
    <div class="col-xs-12 col-md-8">
        <?php if($confirmation) : ?>
            <h2 class="salon-step-title"><?php _e('Booking Status', 'salon-booking-system') ?></h2>
        <?php else : ?>
            <?php
            $args = array(
                'key'          => 'Booking Confirmation',
                'label'        => __('Booking Confirmation', 'salon-booking-system'),
                'tag'          => 'h2',
                'textClasses'  => 'salon-step-title',
                'inputClasses' => '',
                'tagClasses'   => 'salon-step-title',
            );
            echo $plugin->loadView('shortcode/_editable_snippet', $args);
            ?>
        <?php endif ?>

        <?php include '_errors.php'; ?>

        <?php if (isset($payOp) && $payOp == 'cancel'): ?>

            <div class="alert alert-danger">
                <p><?php _e('The payment is failed, please try again.', 'salon-booking-system') ?></p>
            </div>

        <?php else: ?>

    	<?php include '_salon_thankyou_okbox.php' ?>

    	<?php $ppl = false; ?>
            <?php include '_salon_thankyou_alert.php' ?>
        <?php endif ?>

    </div>
</div>
<?php if (in_array($booking->getStatus(), array(SLN_Enum_BookingStatus::PAID)) && $booking->getAmount() > 0.0 && (!$payRemainingAmount || $booking->getPaidRemainedAmount())): ?>
    <?php include '_salon_thankyou_alert_paid.php' ?>
<?php endif; ?>
<div class="row sln-form-actions-wrapper ">

    <?php if (!in_array($booking->getStatus(), array(SLN_Enum_BookingStatus::PAID, SLN_Enum_BookingStatus::CONFIRMED, SLN_Enum_BookingStatus::CANCELED, SLN_Enum_BookingStatus::ERROR)) || $payRemainingAmount && !$booking->getPaidRemainedAmount() && !in_array($booking->getStatus(), array(SLN_Enum_BookingStatus::CANCELED, SLN_Enum_BookingStatus::ERROR))): ?>

	<?php if($paymentMethod): ?>
	    <div class="col-xs-12 col-sm-6 col-md-4 sln-input--action sln-form-actions sln-payment-actions">
		<div class="sln-btn sln-btn--emphasis sln-btn--noheight sln-btn--fullwidth">
		    <?php echo $paymentMethod->renderPayButton(compact('booking', 'paymentMethod', 'ajaxData', 'payUrl')); ?>
		</div>
		<?php include '_salon_thankyou_transaction_fee.php' ?>
	    </div>
	<?php endif; ?>

	<?php if($paymentMethod && $payLater): ?>
	    <div class="col-xs-12 col-sm-6 col-md-4 sln-input--action sln-form-actions sln-payment-actions">
		<a  href="<?php echo $laterUrl ?>" class="sln-btn sln-btn--emphasis sln-btn--noheight sln-btn--fullwidth"
		    <?php if($ajaxEnabled): ?>
			data-salon-data="<?php echo $ajaxData.'&mode=later' ?>" data-salon-toggle="direct"
		    <?php endif ?>>
		    <?php _e('I\'ll pay later', 'salon-booking-system') ?>
		</a>
	    </div>
	<?php endif ?>

    <?php endif; ?>

    <?php if(!$paymentMethod) : ?>
	<div class="col-xs-12 col-sm-10 col-md-4 sln-input--action sln-form-actions sln-payment-actions">
	    <a  href="<?php echo $laterUrl ?>" class="sln-btn sln-btn--emphasis sln-btn--medium sln-btn--fullwidth"
		<?php if($ajaxEnabled): ?>
		    data-salon-data="<?php echo $ajaxData.'&mode=later' ?>" data-salon-toggle="direct"
		<?php endif ?>>
		<?php _e('Complete', 'salon-booking-system') ?>
	    </a>
	</div>
    <?php endif ?>
</div>