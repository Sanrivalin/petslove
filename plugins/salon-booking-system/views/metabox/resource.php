<?php
$helper->showNonce($postType);
?>
<div class="sln-box sln-box--main sln-box--haspanel sln-box--haspanel--open">
    <div class="collapse in sln-box__panelcollapse">
        <div class="row">
<!-- default settings -->
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 form-group sln-select">
                <label><?php _e('Units per session', 'salon-booking-system');?></label>
                <?php SLN_Form::fieldNumeric($helper->getFieldName($postType, 'unit'), $resource->getUnitPerHour(), array('max' => 100));?>
                <p><?php _e('How many reservations for the same date/time slot ?', 'salon-booking-system');?></p>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-6 col-lg-4">
                <div class="sln-switch">
                    <?php SLN_Form::fieldCheckboxSwitch($helper->getFieldName($postType, 'enabled'), $resource->getEnabled(), __('Enable', 'salon-booking-system'), __('Disable', 'salon-booking-system')) ?>
                </div>
                <p><?php _e('Use it to temporarily disable this resource', 'salon-booking-system');?></p>
            </div>
            <div class="sln-clear"></div>
        </div>
        <div class="row">
            <div class="col-xs-12 form-group sln-select">
                <label><?php _e('Assigned services', 'salon-booking-system');?></label>
                <?php
                    /** @var SLN_Wrapper_Service[] $services */
                    $services = SLN_Plugin::getInstance()->getRepository(SLN_Plugin::POST_TYPE_SERVICE)->getAll();
                    $items = array();
                    foreach ($services as $s) {
                        $items[$s->getId()] = $s->getName();
                    }
                    SLN_Form::fieldSelect(
                        $helper->getFieldName($postType, 'services[]'),
                        $items,
                        (array)$resource->getMeta('services'),
                        array('attrs' => array('multiple' => true, 'placeholder' => __('select one or more services', 'salon-booking-system'), 'data-containerCssClass' => 'sln-select-wrapper-no-search')),
                        true
                    );
                ?>
                <p><?php _e('Select the services to be assigned to this resource', 'salon-booking-system');?></p>
            </div>
        </div>
        <div class="sln-clear"></div>
    </div>
</div>

<?php do_action('sln.template.resource.metabox', $resource);?>
<?php if ( ! in_array(SLN_Plugin::USER_ROLE_WORKER,  wp_get_current_user()->roles) ): ?>
<script>
window.Userback = window.Userback || {};
Userback.access_token = '33731|64310|7TOMg95VWdhaFTyY2oCZrnrV3';
(function(d) {
var s = d.createElement('script');s.async = true;
s.src = 'https://static.userback.io/widget/v1.js';
(d.head || d.body).appendChild(s);
})(document);
</script>
<?php endif; ?>