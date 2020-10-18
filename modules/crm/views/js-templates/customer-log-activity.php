<?php
$customer_id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
?>
<div id="log-activity">
    <p>
        <select name="log_type" v-model="feedData.log_type" id="log-type" class="erp-left">
        <option value=""><?php esc_attr_e( '-- Select type --', 'erp' ) ?></option>
            <option value="call"><?php esc_attr_e( 'Log a Call', 'erp' ) ?></option>
            <option value="meeting"><?php esc_attr_e( 'Log a Meeting', 'erp' ) ?></option>
            <option value="email"><?php esc_attr_e( 'Log an Email', 'erp' ) ?></option>
            <!-- <option value="sms"><?php esc_attr_e( 'Log an SMS', 'erp' ) ?></option> -->
            <option value="order"><?php esc_attr_e( 'Log an Order', 'erp' ) ?></option>			
            <option value="quote"><?php esc_attr_e( 'Log a Quote', 'erp' ) ?></option>	
			<option value="sample"><?php esc_attr_e( 'Log a Sample', 'erp' ) ?></option>	
        </select>

        <input class="erp-right" v-model="feedData.tp" type="text" v-timepicker="feedData.tp" placeholder="12.00pm" size="10">
        <input class="erp-right" v-model="feedData.dt" type="text" v-datepicker="feedData.dt" datedisable="upcomming" placeholder="yy-mm-dd">
        <span class="clearfix"></span>
    </p>

    <p v-if="feedData.log_type == 'email'">
        <label><?php esc_attr_e( 'Subject', 'erp' ); ?></label>
        <span class="sep">:</span>
        <span class="value">
            <input type="text" class="email_subject" name="email_subject" v-model="feedData.email_subject" placeholder="<?php esc_attr_e( 'Subject log...', 'erp' ); ?>">
        </span>
    </p>

    <p v-if="feedData.log_type == 'meeting'">
        <select name="selected_contact" id="erp-crm-activity-invite-contact" v-model="feedData.inviteContact" v-selecttwo="feedData.inviteContact" class="select2" multiple="multiple" style="width: 100%" data-placeholder="<?php esc_attr_e( 'Agents or managers..', 'erp' ); ?>">
            <?php echo wp_kses( erp_crm_get_crm_user_html_dropdown(), [
                'option' => [
                    'value'    => [],
                    'selected' => [],
                ],
            ] ); ?>
        </select>
    </p>

    <trix-editor v-if="!feed" id="log-text-editor" input="log_activity_message" placeholder="<?php esc_attr_e( 'Type your description .....', 'erp' ); ?>"></trix-editor>
    <input v-if="!feed" id="log_activity_message" v-model="feedData.message" type="hidden" name="log_activity_message" value="">

    <trix-editor v-if="feed" id="log-text-editor" input="log_activity_message_{{ feed.id }}" placeholder="<?php esc_attr_e( 'Type your description .....', 'erp' ); ?>"></trix-editor>
    <input v-if="feed" id="log_activity_message_{{ feed.id }}" v-model="feedData.message" type="hidden" name="log_activity_message_{{ feed.id }}" value="{{ feed.message }}">

    <div class="submit-action">
        <input type="hidden" name="user_id" v-model="feedData.user_id" value="<?php echo esc_attr( $customer_id ); ?>" >
        <input type="hidden" name="created_by" v-model="feedData.created_by" value="<?php echo esc_attr( get_current_user_id() ); ?>">
        <input type="hidden" name="action" v-model="feedData.action" value="erp_customer_feeds_save_notes">
        <input type="hidden" name="type" v-model="feedData.type" value="log_activity">
        <input type="submit" v-if="!feed" :disabled = "!isValid" class="button button-primary" name="add_log_activity" value="<?php esc_attr_e( 'Add Log', 'erp' ); ?>">
        <input type="submit" v-if="feed" :disabled = "!isValid" class="button button-primary" name="edit_log_activity" value="<?php esc_attr_e( 'Update Log', 'erp' ); ?>">
        <input type="reset" v-if="!feed" class="button button-default" value="<?php esc_attr_e( 'Discard', 'erp' ); ?>">
        <button class="button" v-if="feed" @click.prevent="cancelUpdateFeed"><?php esc_attr_e( 'Cancel', 'erp' ); ?></button>
    </div>
</div>
