<?php
/*
Plugin Name: Custom Security Tools
Description: Plugin bảo mật tùy chỉnh – đổi URL login, chặn wp-login.php, khóa wp-admin và giới hạn đăng nhập.
Version: 2.0
Author: Ẩu
*/

/* ==================================================
   CẤU HÌNH
================================================== */
define('CUSTOM_LOGIN_SLUG', 'my-login');


/* ==================================================
   TẠO URL LOGIN MỚI
   yourdomain.com/my-login/
================================================== */
function cst_add_login_rule() {
    add_rewrite_rule(
        '^' . CUSTOM_LOGIN_SLUG . '/?$',
        'wp-login.php?custom_login=1',
        'top'
    );
}
add_action('init', 'cst_add_login_rule');


/* ==================================================
   KÍCH HOẠT / TẮT PLUGIN
================================================== */
register_activation_hook(__FILE__, function () {
    cst_add_login_rule();
    flush_rewrite_rules();
});

register_deactivation_hook(__FILE__, function () {
    flush_rewrite_rules();
});


/* ==================================================
   CHẶN wp-login.php TRUY CẬP TRỰC TIẾP
================================================== */
add_action('login_init', function () {

    if (is_user_logged_in()) {
        return;
    }

    if (!isset($_GET['custom_login'])) {
        wp_die(
            'Trang không tồn tại.',
            '404',
            array('response' => 404)
        );
        exit;
    }
});


/* ==================================================
   THAY TẤT CẢ LINK LOGIN
================================================== */
add_filter('login_url', function ($login_url, $redirect) {

    $url = home_url('/' . CUSTOM_LOGIN_SLUG . '/');

    if (!empty($redirect)) {
        $url = add_query_arg('redirect_to', urlencode($redirect), $url);
    }

    return $url;

}, 10, 2);


/* ==================================================
   CHẶN wp-admin CHO USER KHÔNG PHẢI ADMIN
================================================== */
add_action('admin_init', function () {

    if (
        !current_user_can('manage_options') &&
        !wp_doing_ajax()
    ) {
        wp_redirect(home_url());
        exit;
    }

});


/* ==================================================
   GIỚI HẠN LOGIN SAI: 5 LẦN / 10 PHÚT
================================================== */
function cst_limit_login_attempts() {

    $ip = $_SERVER['REMOTE_ADDR'];
    $key = 'cst_login_' . md5($ip);

    $attempts = get_transient($key);

    if ($attempts >= 5) {
        wp_die(
            'Bạn đã đăng nhập sai quá nhiều lần. Vui lòng thử lại sau 10 phút.'
        );
    }
}
add_action('wp_authenticate', 'cst_limit_login_attempts');


/* ==================================================
   TĂNG SỐ LẦN SAI
================================================== */
add_action('wp_login_failed', function () {

    $ip = $_SERVER['REMOTE_ADDR'];
    $key = 'cst_login_' . md5($ip);

    $attempts = get_transient($key);

    if (!$attempts) {
        $attempts = 0;
    }

    set_transient(
        $key,
        $attempts + 1,
        10 * MINUTE_IN_SECONDS
    );

});


/* ==================================================
   LOGIN THÀNH CÔNG -> RESET ĐẾM
================================================== */
add_action('wp_login', function ($user_login, $user) {

    $ip = $_SERVER['REMOTE_ADDR'];
    $key = 'cst_login_' . md5($ip);

    delete_transient($key);

}, 10, 2);