<?php
/**
 * Page title.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */
get_header(); ?>

<?php do_action( 'flatsome_before_page' ); ?>

<div id="content" class="content-area page-wrapper" role="main">
    <div class="row row-main">
        <div class="large-12 col">
            <div class="col-inner">

                <?php // Kiểm tra xem người dùng đã đăng nhập chưa
                if ( ! is_user_logged_in() ) : ?>

                    <p class="woocommerce-info alert-info">Vui lòng <a href="<?php echo wp_login_url( get_permalink() ); ?>">đăng nhập</a> để đăng dự án.</p>

                <?php else : ?>

                    <?php
                    // Gọi hàm acf_form_head() trước get_header() là tốt nhất,
                    // nhưng nếu đặt ở đây vẫn hoạt động trong nhiều trường hợp.
                    // Đảm bảo hàm này được gọi trước khi form được hiển thị.
                    if ( function_exists( 'acf_form_head' ) ) {
                         acf_form_head(); // Cần thiết để xử lý lưu form và enqueue scripts/styles
                    }

                    // Thiết lập các tùy chọn cho form ACF
                    $options = array(
                        'post_id' => 'new_post', // Chỉ định đây là form tạo bài mới
                        'new_post' => array(
                            'post_type'   => 'du_an_bds', // Post type cần tạo
                            'post_status' => 'pending',  // Trạng thái bài viết mới (pending: chờ duyệt, publish: đăng ngay)
                            // 'post_author' => get_current_user_id(), // Tự động gán tác giả là người dùng hiện tại
                        ),
                        'post_title' => true, // Hiển thị trường nhập Tiêu đề dự án
                        'post_content' => true, // Hiển thị trình soạn thảo nội dung
                        'field_groups' => array( 29527 ), // !! THAY XX BẰNG ID CỦA FIELD GROUP BẠN ĐÃ TẠO Ở BƯỚC 3 !!
                                                    // Bạn có thể tìm ID trong URL khi sửa Field Group, ví dụ: ...&post=acf_123 -> ID là acf_123 hoặc chỉ cần số 123
                        'submit_value' => 'Đăng dự án', // Chữ trên nút submit
                        'updated_message' => 'Dự án của bạn đã được gửi thành công và đang chờ duyệt!', // Thông báo sau khi gửi
                        // 'return' => home_url('/trang-cam-on/'), // Chuyển hướng đến trang cảm ơn sau khi gửi (tùy chọn)
                         'uploader' => 'wp', // Sử dụng trình tải lên mặc định của WordPress
                    );

                    // Hiển thị form
                    if ( function_exists( 'acf_form' ) ) {
                        acf_form( $options );
                    } else {
                        echo '<p>Vui lòng kích hoạt plugin Advanced Custom Fields Pro.</p>';
                    }
                    ?>
                <?php endif; // End is_user_logged_in() check ?>

            </div><!-- .col-inner -->
        </div><!-- .large-12 -->
    </div><!-- .row -->
</div>

<?php do_action( 'flatsome_after_page' ); ?>

<?php get_footer(); ?>


