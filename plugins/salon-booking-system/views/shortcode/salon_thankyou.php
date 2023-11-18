<?php
/**
 * @var SLN_Plugin $plugin
 * @var string     $formAction
 * @var string     $submitName
 * @var SLN_Shortcode_Salon_ThankyouStep $step
 */
$confirmation = $plugin->getSettings()->get('confirmation');
$booking = $plugin->getBookingBuilder()->getLastBooking();
if(empty($booking) && isset($_GET['op'])){
    $booking = $plugin->createBooking(explode('-', sanitize_text_field($_GET['op']))[1]);
}
$payRemainingAmount = isset($_GET['pay_remaining_amount']) && $_GET['pay_remaining_amount'];
$pendingPayment = $plugin->getSettings()->isPayEnabled() && (in_array($booking->getStatus(), array(SLN_Enum_BookingStatus::PENDING_PAYMENT, SLN_Enum_BookingStatus::DRAFT)) || $payRemainingAmount && !$booking->getPaidRemainedAmount());
$payLater = $plugin->getSettings()->get('pay_cash');
$currentStep = $step->getShortcode()->getCurrentStep();
$ajaxData = "sln_step_page=$currentStep&submit_$currentStep=1&pay_remaining_amount=" . ($payRemainingAmount ? 1 : 0);

$ajaxData = apply_filters('sln.booking.thankyou-step.get-ajax-data', $ajaxData);

$ajaxEnabled = $plugin->getSettings()->isAjaxEnabled();

$paymentMethod = ((!$confirmation || $pendingPayment) && $plugin->getSettings()->isPayEnabled()) ?
SLN_Enum_PaymentMethodProvider::getService($plugin->getSettings()->getPaymentMethod(), $plugin)
: false;

if ($booking->getAmount() == 0) {
	$pendingPayment = $payLater = $paymentMethod = false;
}

$style = $step->getShortcode()->getStyleShortcode();
$size = SLN_Enum_ShortcodeStyle::getSize($style);

?>
<div id="salon-step-thankyou" class="sln-thankyou">
<?php include '_salon_thankyou_'.$size.'.php'; ?>
</div>
<?php include '_mixpanel_track.php'; ?>
