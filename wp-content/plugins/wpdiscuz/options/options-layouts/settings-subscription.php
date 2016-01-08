<?php
if (!defined('ABSPATH')) {
    exit();
}
?>
<div>
    <h2 style="padding:5px 10px 10px 10px; margin:0px;"><?php _e('Email Subscription Settings', 'wpdiscuz'); ?> </h2>
    <table class="wp-list-table widefat plugins" style="margin-top:10px; border:none;">
        <tbody>
            <tr valign="top">
                <th scope="row" style="width:55%;">
                    <label for="wc_disable_member_confirm" style="line-height:22px;"><span style="line-height:22px;"><?php _e('Disable subscription confirmation for registered users', 'wpdiscuz'); ?></span></label><br />
                    <label for="show_subscription_bar" style="line-height:22px;"><span style="line-height:22px;"><?php _e('Show comment subscription bar', 'wpdiscuz'); ?></span></label><br />
        <p style="font-size:13px; color:#999999; width:80%; padding-left:0px; margin-left:0px;">
            <?php _e('This bar provides two subscription options: notify of "new follow-up comments" and "new replies to my comments"', 'wpdiscuz') ?>
        </p>
        <label for="wc_show_hide_reply_checkbox" style="line-height:22px;"><span style="line-height:22px;"><?php _e('Show "Notify of new replies to this comment"', 'wpdiscuz'); ?></span></label><br />
        <p style="font-size:13px; color:#999999; width:80%; padding-left:0px; margin-left:0px;">
            <?php _e('wpDiscuz is the only comment plugin which allows you to subscribe to certain comment replies. This option is located above [Post Comment] button in comment form. You can disable this subscription way by unchecking this option.', 'wpdiscuz') ?>
        </p>
        </th>
        <td>  
            <input type="checkbox" <?php checked($this->optionsSerialized->disableMemberConfirm == 1) ?> value="1" name="wc_disable_member_confirm" id="wc_disable_member_confirm" />
            <br />
            <input type="checkbox" <?php checked($this->optionsSerialized->showSubscriptionBar == 1) ?> value="1" name="show_subscription_bar" id="show_subscription_bar" />
            <br /><br /><br />
            <input type="checkbox" <?php checked($this->optionsSerialized->showHideReplyCheckbox == 1) ?> value="1" name="wc_show_hide_reply_checkbox" id="wc_show_hide_reply_checkbox" />
        </td>
        </tr>
        <?php if (class_exists('Prompt_Comment_Form_Handling')) { ?>
            <tr valign="top">
                <th scope="row">
                    <?php _e('Use Postmatic for subscriptions and commenting by email', 'wpdiscuz'); ?>
            <p style="font-size:13px; color:#999999; width:80%; padding-left:0px; margin-left:0px;"><?php _e('Postmatic allows your users subscribe to comments. Instead of just being notified, they add a reply right from their inbox.', 'wpdiscuz'); ?></p>
            </th>
            <td>                                
                <label for="wc_use_postmatic_for_comment_notification">
                    <input type="checkbox" <?php checked($this->optionsSerialized->usePostmaticForCommentNotification == 1) ?> value="1" name="wc_use_postmatic_for_comment_notification" id="wc_use_postmatic_for_comment_notification" />
                </label>
            </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>