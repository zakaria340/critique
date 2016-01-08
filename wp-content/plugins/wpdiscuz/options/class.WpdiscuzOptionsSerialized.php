<?php

class WpdiscuzOptionsSerialized {

    /**
     * Type - Checkbox array
     * Available Values - Checked/Unchecked
     * Description - On which post types display comment form
     * Default Value - Post
     */
    public $postTypes = array('post');

    /**
     * Type - Radio Button
     * Available Values - Disabled / Always updtae / Update if has new comments
     * Description - Updates comments list via ajax to show new comments
     * Default Value - Disabled
     */
    public $commentListUpdateType;

    /**
     * Type - Dropdown menu
     * Available Values - 10s, 20s, 30s, 60s(1 minute), 180s(3 minutes), 300s(5 minutes), 600s(10 minutes)
     * Description - Updates comments list every ... seconds
     * Default Value - Comment list update timer value
     */
    public $commentListUpdateTimer;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Allow guests to vote on comments
     * Default Value - Checked
     */
    public $liveUpdateGuests;

    /**
     * Type - Dropdown menu
     * Available Values - Not Allow(0), 900s(15 minutes)  1800s(30 minutes), 3600s(1 hour), 10800s(3 hours), 86400(24 hours)
     * Description - Allow commnet editing after comment subimt
     * Default Value - Editable comment time value
     */
    public $commentEditableTime;

    /**
     * Type - Dropdown menu
     * Available Values - list of pages (ids)
     * Description - Redirect first commenter to the selected page
     * Default Value - 0
     */
    public $redirectPage;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Allow guests to vote on comments
     * Default Value - Checked
     */
    public $isGuestCanVote;

    /**
     * Type - Radio Button
     * Available Values - 0 Default (Load More) / 1 Load Rest Of Comments / 2 Lazy Load comments on scrolling
     * Description - Comment list load type
     * Default Value - Disabled
     */
    public $commentListLoadType;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Voting buttons
     * Default Value - Unchecked
     */
    public $votingButtonsShowHide;

    /**
     * Type - Checkbox array
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Share Buttons
     * Default Value - fb, g+, tw, vk, ok
     */
    public $shareButtons = array('fb', 'twitter', 'google');

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide the  CAPTCHA field
     * Default Value - Unchecked
     */
    public $captchaShowHide;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show the  CAPTCHA field for logged in users
     * Default Value - Unchecked
     */
    public $captchaShowHideForMembers;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide the  Web URL field
     * Default Value - Unchecked
     */
    public $weburlShowHide;

    /*
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide header text
     * Default Value - Unchecked
     */
    public $headerTextShowHide;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - If checked user must fill this field
     * Default Value - Checked
     */
    public $isNameFieldRequired;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - If checked user must fill this field
     * Default Value - Checked
     */
    public $isEmailFieldRequired;

    /**
     * Type - input
     * Available Values - 0 to unlimit
     * Description - If setted 0 commenter data will be stored for current session else days count
     * Default Value - Checked
     */
    public $storeCommenterData;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - If checked show logged-in user name top of the main form
     * Default Value - Checked
     */
    public $showHideLoggedInUsername;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Reply button for Guests
     * Default Value - Unchecked
     */
    public $replyButtonGuestsShowHide;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Reply button for Customers
     * Default Value - Unchecked
     */
    public $replyButtonMembersShowHide;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide Author Titles
     * Default Value - Unchecked
     */
    public $authorTitlesShowHide;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Comment date format - 20-01-2015
     * Default Value - Checked
     */
    public $simpleCommentDate;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show all new reply notification checkbox below the form
     * Default Value - Checked
     */
    public $showSubscriptionBar;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show new reply notification checkbox below the form
     * Default Value - Checked
     */
    public $showHideReplyCheckbox;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide comment sorting by votes on front-end
     * Default Value - Unchecked
     */
    public $showSortingButtons;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Show/Hide comment sorting by votes on front-end
     * Default Value - Unchecked
     */
    public $mostVotedByDefault;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Use Postmatic plugin for comment notification
     * Default Value - Unchecked
     */
    public $usePostmaticForCommentNotification;

    /**
     * Type - Select
     * Available Values - 12px-16px
     * Description - Comment Text Size
     * Default Value - 14px
     */
    public $commentTextSize;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Form Background Color
     * Default Value - #F9F9F9
     */
    public $formBGColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Comment Background Color
     * Default Value - #FEFEFE
     */
    public $commentBGColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Reply Background Color
     * Default Value - #F8F8F8
     */
    public $replyBGColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Comment Text Color
     * Default Value - #555
     */
    public $commentTextColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Comment Username Color
     * Default Value - #00B38F
     */
    public $primaryColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Colors for blog users by roles 
     * Default Value - #00B38F
     */
    public $blogRoles;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Vote, Reply, Share, Edit - text colors
     * Default Value - #666666
     */
    public $voteReplyColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - Form imput border olor
     * Default Value - #D9D9D9
     */
    public $inputBorderColor;

    /**
     * Type - Input
     * Available Values - color codes
     * Description - New Comments background color
     * Default Value - #FFFAD6
     */
    public $newLoadedCommentBGColor;

    /**
     * Type - Textarea
     * Available Values - custom css code
     * Description - Custom css code
     * Default Value -
     */
    public $customCss;

    /**
     * Type - HTML elements array
     * Available Values - Text
     * Description - Phrases for form elements texts
     * Default Value -
     */
    public $phrases;

    /**
     * helper class for database operations
     */
    public $dbManager;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Hide plugin powerid by information
     * Default Value - Unchecked
     */
    public $showPluginPoweredByLink;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Use .PO/.MO files
     * Default Value - Unchecked
     */
    public $isUsePoMo;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Disable confirmation email for members
     * Default Value - Unchecked
     */
    public $disableMemberConfirm;

    /**
     * Type - Input
     * Available Values - Integer (comment text min length)
     * Description - Define comment text min length
     * Default Value - 1 character
     */
    public $commentTextMinLength;

    /**
     * Type - Input
     * Available Values - Integer (comment text length)
     * Description - Define comment text max length (leave blank for unlimit length)
     * Default Value - Unlimit
     */
    public $commentTextMaxLength;

    /**
     * Type - Input
     * Available Values - Integer (after the limit has been reached show read more link)
     * Description - Define words max count for read more link
     * Default Value - 100 words
     */
    public $commentReadMoreLimit;

    /**
     * Type - Checkbox
     * Available Values - Checked/Unchecked
     * Description - Hide comment link if checked
     * Default Value - Unchecked
     */
    public $showHideCommentLink;
    public $wordpressCommentRegistration;
    public $wordpressDateFormat;
    public $wordpressTimeFormat;
    public $wordpressThreadComments;
    public $wordpressThreadCommentsDepth;
    public $wordpressIsPaginate;
    public $wordpressCommentOrder;
    public $wordpressDefaultCommentsPage;
    public $wordpressCommentPerPage;
    public $wordpressShowAvatars;

    function __construct($dbmanager) {
        $this->dbManager = $dbmanager;
        $this->initPhrases();
        $this->addOptions();
        $this->initOptions(get_option(WpdiscuzCore::OPTION_SLUG_OPTIONS));
        $this->wordpressCommentRegistration = get_option('comment_registration');
        $this->wordpressDateFormat = get_option('date_format');
        $this->wordpressTimeFormat = get_option('time_format');
        $this->wordpressThreadComments = get_option('thread_comments');
        $this->wordpressThreadCommentsDepth = get_option('thread_comments_depth');
        $this->wordpressIsPaginate = get_option('page_comments');
        $this->wordpressCommentOrder = get_option('comment_order');
        $this->wordpressCommentPerPage = get_option('comments_per_page');
        $this->wordpressShowAvatars = get_option('show_avatars');
        $this->wordpressDefaultCommentsPage = get_option('default_comments_page');
        add_action('plugins_loaded', array(&$this, 'initPhrasesOnLoad'), 2126);
    }

    public function initOptions($serialize_options) {
        $options = maybe_unserialize($serialize_options);
        $this->postTypes = isset($options['wc_post_types']) ? $options['wc_post_types'] : array('post');
        $this->commentListUpdateType = isset($options['wc_comment_list_update_type']) ? $options['wc_comment_list_update_type'] : 0;
        $this->commentListUpdateTimer = isset($options['wc_comment_list_update_timer']) ? $options['wc_comment_list_update_timer'] : 30;
        $this->liveUpdateGuests = isset($options['wc_live_update_guests']) ? $options['wc_live_update_guests'] : 1;
        $this->commentEditableTime = isset($options['wc_comment_editable_time']) ? $options['wc_comment_editable_time'] : 900;
        $this->redirectPage = isset($options['wpdiscuz_redirect_page']) ? $options['wpdiscuz_redirect_page'] : 0;
        $this->isGuestCanVote = isset($options['wc_is_guest_can_vote']) ? $options['wc_is_guest_can_vote'] : 0;
        $this->commentListLoadType = isset($options['commentListLoadType']) ? $options['commentListLoadType'] : 0;
        $this->votingButtonsShowHide = isset($options['wc_voting_buttons_show_hide']) ? $options['wc_voting_buttons_show_hide'] : 0;
        $this->shareButtons = isset($options['wpdiscuz_share_buttons']) ? $options['wpdiscuz_share_buttons'] : array('fb', 'twitter', 'google');
        $this->captchaShowHide = isset($options['wc_captcha_show_hide']) ? $options['wc_captcha_show_hide'] : 0;
        $this->captchaShowHideForMembers = isset($options['wc_captcha_show_hide_for_members']) ? $options['wc_captcha_show_hide_for_members'] : 0;
        $this->weburlShowHide = isset($options['wc_weburl_show_hide']) ? $options['wc_weburl_show_hide'] : 0;
        $this->headerTextShowHide = isset($options['wc_header_text_show_hide']) ? $options['wc_header_text_show_hide'] : 0;
        $this->isNameFieldRequired = isset($options['wc_is_name_field_required']) ? $options['wc_is_name_field_required'] : 0;
        $this->isEmailFieldRequired = isset($options['wc_is_email_field_required']) ? $options['wc_is_email_field_required'] : 0;
        $this->storeCommenterData = isset($options['storeCommenterData']) ? $options['storeCommenterData'] : -1;
        $this->showHideLoggedInUsername = isset($options['wc_show_hide_loggedin_username']) ? $options['wc_show_hide_loggedin_username'] : 0;
        $this->replyButtonGuestsShowHide = isset($options['wc_reply_button_guests_show_hide']) ? $options['wc_reply_button_guests_show_hide'] : 0;
        $this->replyButtonMembersShowHide = isset($options['wc_reply_button_members_show_hide']) ? $options['wc_reply_button_members_show_hide'] : 0;
        $this->authorTitlesShowHide = isset($options['wc_author_titles_show_hide']) ? $options['wc_author_titles_show_hide'] : 0;
        $this->simpleCommentDate = isset($options['wc_simple_comment_date']) ? $options['wc_simple_comment_date'] : 0;
        $this->showSubscriptionBar = isset($options['show_subscription_bar']) ? $options['show_subscription_bar'] : 1;
        $this->showHideReplyCheckbox = isset($options['wc_show_hide_reply_checkbox']) ? $options['wc_show_hide_reply_checkbox'] : 0;
        $this->showSortingButtons = isset($options['show_sorting_buttons']) ? $options['show_sorting_buttons'] : 1;
        $this->mostVotedByDefault = isset($options['mostVotedByDefault']) ? $options['mostVotedByDefault'] : 0;
        $this->usePostmaticForCommentNotification = isset($options['wc_use_postmatic_for_comment_notification']) ? $options['wc_use_postmatic_for_comment_notification'] : 0;
        $this->commentTextSize = isset($options['wc_comment_text_size']) ? $options['wc_comment_text_size'] : '14px';
        $this->formBGColor = isset($options['wc_form_bg_color']) ? $options['wc_form_bg_color'] : '#F9F9F9';
        $this->commentBGColor = isset($options['wc_comment_bg_color']) ? $options['wc_comment_bg_color'] : '#FEFEFE';
        $this->replyBGColor = isset($options['wc_reply_bg_color']) ? $options['wc_reply_bg_color'] : '#F8F8F8';
        $this->commentTextColor = isset($options['wc_comment_text_color']) ? $options['wc_comment_text_color'] : '#555';
        $this->primaryColor = isset($options['wc_comment_username_color']) ? $options['wc_comment_username_color'] : '#00B38F';
        $this->blogRoles = isset($options['wc_blog_roles']) ? $options['wc_blog_roles'] : array();
        $this->voteReplyColor = isset($options['wc_vote_reply_color']) ? $options['wc_vote_reply_color'] : '#666666';
        $this->inputBorderColor = isset($options['wc_input_border_color']) ? $options['wc_input_border_color'] : "#D9D9D9";
        $this->newLoadedCommentBGColor = isset($options['wc_new_loaded_comment_bg_color']) ? $options['wc_new_loaded_comment_bg_color'] : '#FFFAD6';
        $this->customCss = isset($options['wc_custom_css']) ? $options['wc_custom_css'] : '.comments-area{width:auto; margin: 0 auto;}';
        $this->showPluginPoweredByLink = isset($options['wc_show_plugin_powerid_by']) ? $options['wc_show_plugin_powerid_by'] : 0;
        $this->isUsePoMo = isset($options['wc_is_use_po_mo']) ? $options['wc_is_use_po_mo'] : 0;
        $this->disableMemberConfirm = isset($options['wc_disable_member_confirm']) ? $options['wc_disable_member_confirm'] : 1;
        $this->commentTextMinLength = isset($options['wc_comment_text_min_length']) ? $options['wc_comment_text_min_length'] : 1;
        $this->commentTextMaxLength = isset($options['wc_comment_text_max_length']) ? $options['wc_comment_text_max_length'] : '';
        $this->commentReadMoreLimit = isset($options['commentWordsLimit']) ? $options['commentWordsLimit'] : 100;
        $this->showHideCommentLink = isset($options['showHideCommentLink']) ? $options['showHideCommentLink'] : 0;
    }

    /**
     * initialize default phrases
     */
    public function initPhrases() {
        $this->phrases = array(
            'wc_leave_a_reply_text' => __('Leave a Reply', 'wpdiscuz'),
            'wc_be_the_first_text' => __('Be the First to Comment!', 'wpdiscuz'),
            'wc_header_text' => __('Comment', 'wpdiscuz'),
            'wc_header_text_plural' => __('Comments', 'wpdiscuz'), // PLURAL
            'wc_header_on_text' => __('on', 'wpdiscuz'),
            'wc_comment_start_text' => __('Start the discussion', 'wpdiscuz'),
            'wc_comment_join_text' => __('Join the discussion', 'wpdiscuz'),
            'wc_email_text' => __('Email', 'wpdiscuz'),
            'wc_name_text' => __('Name', 'wpdiscuz'),
            'wc_website_text' => __('WebSite URL', 'wpdiscuz'),
            'wc_captcha_text' => __('Please insert the code above to comment', 'wpdiscuz'),
            'wc_submit_text' => __('Post Comment', 'wpdiscuz'),
            'wc_notify_of' => __('Notify of', 'wpdiscuz'),
            'wc_notify_on_new_comment' => __('new follow-up comments', 'wpdiscuz'),
            'wc_notify_on_all_new_reply' => __('new replies to my comments', 'wpdiscuz'),
            'wc_notify_on_new_reply' => __('Notify of new replies to this comment', 'wpdiscuz'),
            'wc_sort_by' => __('Sort by', 'wpdiscuz'),
            'wc_newest' => __('newest', 'wpdiscuz'),
            'wc_oldest' => __('oldest', 'wpdiscuz'),
            'wc_most_voted' => __('most voted', 'wpdiscuz'),
            'wc_load_more_submit_text' => __('Load More Comments', 'wpdiscuz'),
            'wc_load_rest_comments_submit_text' => __('Load Rest of Comments', 'wpdiscuz'),
            'wc_reply_text' => __('Reply', 'wpdiscuz'),
            'wc_share_text' => __('Share', 'wpdiscuz'),
            'wc_edit_text' => __('Edit', 'wpdiscuz'),
            'wc_share_facebook' => __('Share On Facebook', 'wpdiscuz'),
            'wc_share_twitter' => __('Share On Twitter', 'wpdiscuz'),
            'wc_share_google' => __('Share On Google', 'wpdiscuz'),
            'wc_share_vk' => __('Share On VKontakte', 'wpdiscuz'),
            'wc_share_ok' => __('Share On Odnoklassniki', 'wpdiscuz'),
            'wc_hide_replies_text' => __('Hide Replies', 'wpdiscuz'),
            'wc_show_replies_text' => __('Show Replies', 'wpdiscuz'),
            'wc_email_subject' => __('New Comment', 'wpdiscuz'),
            'wc_email_message' => __('New comment on the discussion section you\'ve been interested in', 'wpdiscuz'),
            'wc_new_reply_email_subject' => __('New Reply', 'wpdiscuz'),
            'wc_new_reply_email_message' => __('New reply on the discussion section you\'ve been interested in', 'wpdiscuz'),
            'wc_subscribed_on_comment' => __('You\'re subscribed for new replies on this comment', 'wpdiscuz'),
            'wc_subscribed_on_all_comment' => __('You\'re subscribed for new replies on all your comments', 'wpdiscuz'),
            'wc_subscribed_on_post' => __('You\'re subscribed for new follow-up comments on this post', 'wpdiscuz'),
            'wc_unsubscribe' => __('Unsubscribe', 'wpdiscuz'),
            'wc_ignore_subscription' => __('Cancel subscription', 'wpdiscuz'),
            'wc_unsubscribe_message' => __('You\'ve successfully unsubscribed.', 'wpdiscuz'),
            'wc_subscribe_message' => __('You\'ve successfully subscribed.', 'wpdiscuz'),
            'wc_confirm_email' => __('Confirm your subscription', 'wpdiscuz'),
            'wc_comfirm_success_message' => __('You\'ve successfully confirmed your subscription.', 'wpdiscuz'),
            'wc_confirm_email_subject' => __('Subscribe Confirmation', 'wpdiscuz'),
            'wc_confirm_email_message' => __('Hi, <br/> You just subscribed for new comments on our website. This means you will receive an email when new comments are posted according to subscription option you\'ve chosen. <br/> To activate, click confirm below. If you believe this is an error, ignore this message and we\'ll never bother you again.', 'wpdiscuz'),
            'wc_error_empty_text' => __('please fill out this field to comment', 'wpdiscuz'),
            'wc_error_email_text' => __('email address is invalid', 'wpdiscuz'),
            'wc_error_url_text' => __('url is invalid', 'wpdiscuz'),
            'wc_year_text' => array('datetime' => array(__('year', 'wpdiscuz'), 1)),
            'wc_year_text_plural' => array('datetime' => array(__('years', 'wpdiscuz'), 1)), // PLURAL
            'wc_month_text' => array('datetime' => array(__('month', 'wpdiscuz'), 2)),
            'wc_month_text_plural' => array('datetime' => array(__('months', 'wpdiscuz'), 2)), // PLURAL
            'wc_day_text' => array('datetime' => array(__('day', 'wpdiscuz'), 3)),
            'wc_day_text_plural' => array('datetime' => array(__('days', 'wpdiscuz'), 3)), // PLURAL
            'wc_hour_text' => array('datetime' => array(__('hour', 'wpdiscuz'), 4)),
            'wc_hour_text_plural' => array('datetime' => array(__('hours', 'wpdiscuz'), 4)), // PLURAL
            'wc_minute_text' => array('datetime' => array(__('minute', 'wpdiscuz'), 5)),
            'wc_minute_text_plural' => array('datetime' => array(__('minutes', 'wpdiscuz'), 5)), // PLURAL
            'wc_second_text' => array('datetime' => array(__('second', 'wpdiscuz'), 6)),
            'wc_second_text_plural' => array('datetime' => array(__('seconds', 'wpdiscuz'), 6)), // PLURAL
            'wc_right_now_text' => __('right now', 'wpdiscuz'),
            'wc_ago_text' => __('ago', 'wpdiscuz'),
            'wc_posted_today_text' => __('Today', 'wpdiscuz'),
            'wc_you_must_be_text' => __('You must be', 'wpdiscuz'),
            'wc_logged_in_as' => __('You are logged in as', 'wpdiscuz'),
            'wc_log_out' => __('Log out', 'wpdiscuz'),
            'wc_logged_in_text' => __('logged in', 'wpdiscuz'),
            'wc_to_post_comment_text' => __('to post a comment.', 'wpdiscuz'),
            'wc_vote_up' => __('Vote Up', 'wpdiscuz'),
            'wc_vote_down' => __('Vote Down', 'wpdiscuz'),
            'wc_vote_counted' => __('Vote Counted', 'wpdiscuz'),
            'wc_vote_only_one_time' => __("You've already voted for this comment", 'wpdiscuz'),
            'wc_voting_error' => __('Voting Error', 'wpdiscuz'),
            'wc_login_to_vote' => __('You Must Be Logged In To Vote', 'wpdiscuz'),
            'wc_self_vote' => __('You cannot vote for your comment', 'wpdiscuz'),
            'wc_deny_voting_from_same_ip' => __('You are not allowed to vote for this comment', 'wpdiscuz'),
            'wc_invalid_captcha' => __('Invalid Captcha Code', 'wpdiscuz'),
            'wc_invalid_field' => __('Some of field value is invalid', 'wpdiscuz'),
            'wc_new_comment_button_text' => __('new comment', 'wpdiscuz'),
            'wc_new_comments_button_text' => __('new comments', 'wpdiscuz'), // PLURAL
            'wc_held_for_moderate' => __('Comment awaiting moderation', 'wpdiscuz'),
            'wc_new_reply_button_text' => __('new reply on your comment', 'wpdiscuz'),
            'wc_new_replies_button_text' => __('new replies on your comments', 'wpdiscuz'), // PLURAL
            'wc_new_comments_text' => __('New', 'wpdiscuz'),
            'wc_comment_not_updated' => __('Sorry, the comment was not updated', 'wpdiscuz'),
            'wc_comment_edit_not_possible' => __('Sorry, this comment no longer possible to edit', 'wpdiscuz'),
            'wc_comment_not_edited' => __('You\'ve not made any changes', 'wpdiscuz'),
            'wc_comment_edit_save_button' => __('Save', 'wpdiscuz'),
            'wc_comment_edit_cancel_button' => __('Cancel', 'wpdiscuz'),
            'wc_msg_comment_text_min_length' => __('Comment text is too short (minimum %d% characters)', 'wpdiscuz'),
            'wc_msg_comment_text_max_length' => __('Comment text is too long (maximum %d% characters allowed)', 'wpdiscuz'),
            'wc_read_more' => __('Read more &raquo;', 'wpdiscuz'),
            'wc_msg_required_fields' => __('Please fill out required fields', 'wpdiscuz'),
            'wc_connect_with' => __('Connect with', 'wpdiscuz'),
            'wc_subscribed_to' => __('You\'re subscribed to', 'wpdiscuz'),
            'wc_postmatic_subscription_label' => __('Participate in this discussion via email', 'wpdiscuz')
        );
    }

    public function toArray() {
        $options = array(
            'wc_post_types' => $this->postTypes,
            'wc_comment_list_update_type' => $this->commentListUpdateType,
            'wc_comment_list_update_timer' => $this->commentListUpdateTimer,
            'wc_live_update_guests' => $this->liveUpdateGuests,
            'wc_comment_editable_time' => $this->commentEditableTime,
            'wpdiscuz_redirect_page' => $this->redirectPage,
            'wc_is_guest_can_vote' => $this->isGuestCanVote,
            'commentListLoadType' => $this->commentListLoadType,
            'wc_voting_buttons_show_hide' => $this->votingButtonsShowHide,
            'wpdiscuz_share_buttons' => $this->shareButtons,
            'wc_captcha_show_hide' => $this->captchaShowHide,
            'wc_captcha_show_hide_for_members' => $this->captchaShowHideForMembers,
            'wc_weburl_show_hide' => $this->weburlShowHide,
            'wc_header_text_show_hide' => $this->headerTextShowHide,
            'wc_is_name_field_required' => $this->isNameFieldRequired,
            'wc_is_email_field_required' => $this->isEmailFieldRequired,
            'storeCommenterData' => $this->storeCommenterData,
            'wc_show_hide_loggedin_username' => $this->showHideLoggedInUsername,
            'wc_reply_button_guests_show_hide' => $this->replyButtonGuestsShowHide,
            'wc_reply_button_members_show_hide' => $this->replyButtonMembersShowHide,
            'wc_author_titles_show_hide' => $this->authorTitlesShowHide,
            'wc_simple_comment_date' => $this->simpleCommentDate,
            'show_subscription_bar' => $this->showSubscriptionBar,
            'wc_show_hide_reply_checkbox' => $this->showHideReplyCheckbox,
            'show_sorting_buttons' => $this->showSortingButtons,
            'mostVotedByDefault' => $this->mostVotedByDefault,
            'wc_use_postmatic_for_comment_notification' => $this->usePostmaticForCommentNotification,
            'wc_comment_text_size' => $this->commentTextSize,
            'wc_form_bg_color' => $this->formBGColor,
            'wc_comment_bg_color' => $this->commentBGColor,
            'wc_reply_bg_color' => $this->replyBGColor,
            'wc_comment_text_color' => $this->commentTextColor,
            'wc_comment_username_color' => $this->primaryColor,
            'wc_blog_roles' => $this->blogRoles,
            'wc_vote_reply_color' => $this->voteReplyColor,
            'wc_input_border_color' => $this->inputBorderColor,
            'wc_new_loaded_comment_bg_color' => $this->newLoadedCommentBGColor,
            'wc_custom_css' => $this->customCss,
            'wc_show_plugin_powerid_by' => $this->showPluginPoweredByLink,
            'wc_is_use_po_mo' => $this->isUsePoMo,
            'wc_disable_member_confirm' => $this->disableMemberConfirm,
            'wc_comment_text_min_length' => $this->commentTextMinLength,
            'wc_comment_text_max_length' => $this->commentTextMaxLength,
            'commentWordsLimit' => $this->commentReadMoreLimit,
            'showHideCommentLink' => $this->showHideCommentLink,
        );
        return $options;
    }

    public function updateOptions() {
        update_option(WpdiscuzCore::OPTION_SLUG_OPTIONS, serialize($this->toArray()));
    }

    public function addOptions() {
        $options = array(
            'wc_post_types' => $this->postTypes,
            'wc_comment_list_update_type' => '0',
            'wc_comment_list_update_timer' => '30',
            'wc_live_update_guests' => '1',
            'wc_comment_editable_time' => '900',
            'wpdiscuz_redirect_page' => '0',
            'wc_is_guest_can_vote' => '1',
            'commentsLoadType' => '0',
            'commentListLoadType' => '0',
            'wc_voting_buttons_show_hide' => '0',
            'wpdiscuz_share_buttons' => $this->shareButtons,
            'wc_captcha_show_hide' => '0',
            'wc_captcha_show_hide_for_members' => '0',
            'wc_weburl_show_hide' => '1',
            'wc_header_text_show_hide' => '0',
            'wc_avatar_show_hide' => '0',
            'wc_is_name_field_required' => '1',
            'wc_is_email_field_required' => '1',
            'storeCommenterData' => '-1',
            'wc_show_hide_loggedin_username' => '1',
            'wc_reply_button_guests_show_hide' => '0',
            'wc_reply_button_members_show_hide' => '0',
            'wc_author_titles_show_hide' => '0',
            'wc_simple_comment_date' => '0',
            'show_subscription_bar' => '1',
            'show_sorting_buttons' => '1',
            'mostVotedByDefault' => '0',
            'wc_show_hide_reply_checkbox' => '1',
            'wc_use_postmatic_for_comment_notification' => '0',
            'wc_comment_text_size' => '14px',
            'wc_form_bg_color' => '#F9F9F9',
            'wc_comment_bg_color' => '#FEFEFE',
            'wc_reply_bg_color' => '#F8F8F8',
            'wc_comment_text_color' => '#555',
            'wc_comment_username_color' => '#00B38F',
            'wc_blog_roles' => $this->blogRoles,
            'wc_vote_reply_color' => '#666666',
            'wc_input_border_color' => '#D9D9D9',
            'wc_new_loaded_comment_bg_color' => '#FFFAD6',
            'wc_custom_css' => '.comments-area{width:auto;}',
            'wc_show_plugin_powerid_by' => '0',
            'wc_is_use_po_mo' => '0',
            'wc_disable_member_confirm' => '1',
            'wc_comment_text_min_length' => '1',
            'wc_comment_text_max_length' => '',
            'commentWordsLimit' => '100',
            'showHideCommentLink' => '0'
        );
        add_option(WpdiscuzCore::OPTION_SLUG_OPTIONS, serialize($options));
    }

    public function initPhrasesOnLoad() {
        if (!$this->isUsePoMo && $this->dbManager->isPhraseExists('wc_leave_a_reply_text')) {
            $this->phrases = $this->dbManager->getPhrases();
        } else {
            $this->initPhrases();
        }
    }

    public function getOptionsForJs() {
        $js_options = array();
        $js_options['wc_hide_replies_text'] = $this->phrases['wc_hide_replies_text'];
        $js_options['wc_show_replies_text'] = $this->phrases['wc_show_replies_text'];
        $js_options['wc_msg_required_fields'] = $this->phrases['wc_msg_required_fields'];
        $js_options['wc_invalid_field'] = $this->phrases['wc_invalid_field'];
        $js_options['wc_invalid_captcha'] = $this->phrases['wc_invalid_captcha'];
        $js_options['wc_error_empty_text'] = $this->phrases['wc_error_empty_text'];
        $js_options['wc_error_url_text'] = $this->phrases['wc_error_url_text'];
        $js_options['wc_error_email_text'] = $this->phrases['wc_error_email_text'];
        $js_options['wc_login_to_vote'] = $this->phrases['wc_login_to_vote'];
        $js_options['wc_deny_voting_from_same_ip'] = $this->phrases['wc_deny_voting_from_same_ip'];
        $js_options['wc_self_vote'] = $this->phrases['wc_self_vote'];
        $js_options['wc_vote_only_one_time'] = $this->phrases['wc_vote_only_one_time'];
        $js_options['wc_voting_error'] = $this->phrases['wc_voting_error'];
        $js_options['wc_captcha_show_hide'] = $this->captchaShowHide;
        $js_options['wc_msg_comment_text_min_length'] = str_replace('%d%', $this->commentTextMinLength, $this->phrases['wc_msg_comment_text_min_length']);
        $js_options['wc_msg_comment_text_max_length'] = str_replace('%d%', $this->commentTextMaxLength, $this->phrases['wc_msg_comment_text_max_length']);
        $js_options['wc_held_for_moderate'] = $this->phrases['wc_held_for_moderate'];
        $js_options['wc_comment_edit_not_possible'] = $this->phrases['wc_comment_edit_not_possible'];
        $js_options['wc_comment_not_updated'] = $this->phrases['wc_comment_not_updated'];
        $js_options['wc_comment_not_edited'] = $this->phrases['wc_comment_not_edited'];
        $js_options['wc_new_comment_button_text'] = $this->phrases['wc_new_comment_button_text'];
        $js_options['wc_new_comments_button_text'] = $this->phrases['wc_new_comments_button_text'];
        $js_options['wc_new_reply_button_text'] = $this->phrases['wc_new_reply_button_text'];
        $js_options['wc_new_replies_button_text'] = $this->phrases['wc_new_replies_button_text'];
        $js_options['wc_captcha_show_hide_for_members'] = $this->captchaShowHideForMembers;
        $js_options['is_email_field_required'] = $this->isEmailFieldRequired;
        $js_options['is_user_logged_in'] = is_user_logged_in();
        $js_options['commentListLoadType'] = $this->commentListLoadType;
        $js_options['commentListUpdateType'] = $this->commentListUpdateType;
        $js_options['commentListUpdateTimer'] = $this->commentListUpdateTimer;
        $js_options['liveUpdateGuests'] = $this->liveUpdateGuests;
        $js_options['wc_comment_bg_color'] = $this->commentBGColor;
        $js_options['wc_reply_bg_color'] = $this->replyBGColor;
        $js_options['wordpress_comment_order'] = $this->wordpressCommentOrder;
        $js_options['commentsVoteOrder'] = $this->showSortingButtons && $this->mostVotedByDefault;
        $js_options['wordpressThreadCommentsDepth'] = $this->wordpressThreadCommentsDepth;
        $js_options['wordpressIsPaginate'] = $this->wordpressIsPaginate;
        if ($this->storeCommenterData < 0) {
            $js_options['storeCommenterData'] = 100000;
        } else if ($this->storeCommenterData == 0) {
            $js_options['storeCommenterData'] = null;
        } else {
            $js_options['storeCommenterData'] = $this->storeCommenterData;
        }
        if (function_exists('zerospam_get_key')) {
            $js_options['wpdiscuz_zs'] = md5(zerospam_get_key());
        }
        return $js_options;
    }

}
