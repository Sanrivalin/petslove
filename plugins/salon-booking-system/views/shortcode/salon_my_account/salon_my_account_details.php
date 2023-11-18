<h3 class="text sln-salon-title"><?php echo esc_html(sprintf(__('Welcome back %s!', 'salon-booking-system'), $data['user_name'])); ?>
    <?php if ($data['customer_fidelity_score_enabled']): ?>
        <span class="sln-customer-score">
            <span class="sln-customer-score--title">
                <?php _e('Current Score', 'salon-booking-system') ?>
            </span>
            <span class="sln-customer-score--value">
                <?php echo $data['customer_fidelity_score'] ?>
            </span>
        </span>
    <?php endif ?>
</h3>
<!-- Nav tabs -->
<ul class="nav nav-tabs sln-salon-my-account-tab-nav" role="tablist">
	<li class="col-xs-12 col-sm-4 col-md-3 active" role="presentation"><a data-target="#new" aria-controls="new" role="tab" data-toggle="tab"><?php _e('Next appointments', 'salon-booking-system')?></a></li>
	<li class="col-xs-12 col-sm-4 col-md-3" role="presentation"><a data-target="#old" aria-controls="old" role="tab" data-toggle="tab"><?php _e('Reservations history', 'salon-booking-system')?></a></li>
	<li class="col-xs-12 col-sm-4 col-md-3" role="presentation"><a data-target="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php _e('Update your profile', 'salon-booking-system')?></a></li>
	<?php do_action('sln.my_account.nav'); ?>
</ul>

<!-- Tab panes -->
<div class="tab-content sln-salon-my-account-tab-content">
	<div role="tabpanel" class="tab-pane sln-salon-my-account-tab-pane active" id="new">
		<?php if ($data['cancelled']): ?>
			<p class="hint"><?php _e('The booking has been cancelled', 'salon-booking-system');?></p>
		<?php endif?>
		<?php if (!empty($data['new']['items'])): ?>
			<p class="hint">
				<?php _e('Here you have your next reservations with us, pay attention to the \'pending\' reservations', 'salon-booking-system');?>
			</p>
			<?php
$data['table_data'] = $data['new'];
$data['table_data']['mode'] = 'new';

include '_salon_my_account_details_table.php';
unset($data['table_data']);
?>
		<?php else: ?>
			<p class="hint"><?php _e('You don\'t have upcoming reservations, do you want to re-schedule your last appointment with us?', 'salon-booking-system');?></p>
			<?php
if (!empty($data['history']['items'])) {
	$historySuccesfulItems = $data['history_successful']['items'];

	$data['table_data'] = array(
		'items' => $historySuccesfulItems,
		'mode' => 'new',
	);

	include '_salon_my_account_details_table.php';
	unset($data['table_data']);
}
?>
		<?php endif;?>
		<br>
		<div class="row">
			<div class="col-xs-10 col-sm-6 col-md-4">
				<div class="sln-btn sln-btn--emphasis sln-btn--medium sln-btn--fullwidth">
					<a href="<?php echo $data['booking_url'] ?>"><?php _e('MAKE A NEW RESERVATION', 'salon-booking-system')?></a>
				</div>
			</div>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane sln-salon-my-account-tab-pane" id="old">
		<?php if (!empty($data['history']['items'])): ?>
			<p class="hint"><?php _e('Here you have your past reservations, you can submit a review or re-schedule an appointment', 'salon-booking-system');?></p>

			<div id="sln-salon-my-account-history-content">
				<?php
$data['table_data'] = $data['history'];
$data['table_data']['mode'] = 'history';

include '_salon_my_account_details_table.php';
unset($data['table_data']);
?>
				<div class="row">
					<div class="col-xs-12 salon-scroll-down--note">
						<p><?php _e('Scroll down to load past reservations', 'salon-booking-system'); ?></p>
					</div>
				</div>
			</div>

		<?php else: ?>
			<p class="hint"><?php _e('No bookings', 'salon-booking-system');?></p>
		<?php endif;?>
		<div class="row">
			<div class="col-xs-10 col-sm-8 col-xs-push-1 col-sm-push-0">
				<div class="sln-btn sln-btn--emphasis sln-btn--medium sln-btn--fullwidth">
					<a href="<?php echo $data['booking_url'] ?>"><?php _e('MAKE A NEW RESERVATION', 'salon-booking-system')?></a>
				</div>
			</div>
		</div>
	</div>
	<div role="tabpanel" class="tab-pane sln-salon-my-account-tab-pane" id="profile">
		<?php include '_salon_my_account_profile.php';?>
	</div>
	<?php do_action('sln.my_account.content', array_merge($data['history']['items'], $data['new']['items'])); ?>
	<div id="ratingModal" class="modal fade" role="dialog" tabindex="-1">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<div id="step1">
						<p><?php _e('Hi', 'salon-booking-system');?> <?php echo $data['user_name'] ?>!</p>
						<p><?php _e('How was your experience with us this time? (required)', 'salon-booking-system');?></p>
						<p><textarea id="" placeholder="<?php _e('please, drop us some lines to understand if your experience has been  in line  with your expectations', 'salon-booking-system');?>"></textarea></p>
						<p>
						<div class="rating" id="<?php echo $item['id']; ?>"></div>
						<span><?php _e('Rate our service (required)', 'salon-booking-system');?></span>
						</p>
						<p>
							<button type="button" class="btn btn-primary" onclick="sln_myAccount.sendRate();"><?php _e('Send your review', 'salon-booking-system');?></button>
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Cancel', 'salon-booking-system');?></button>
						</p>
					</div>
					<div id="step2">
						<p><?php _e('Thank you for your review. It will help us improving our services.', 'salon-booking-system');?></p>
						<p><?php _e('We hope to see you again at', 'salon-booking-system');?> <?php echo $data['gen_name']; ?></p>
					</div>
				</div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
</div>
