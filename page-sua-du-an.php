<?php
/**
 * Page title.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

?>
<?php
/**
 * Template Name: Trang Sửa Dự Án
 */

get_header(); ?>

<?php do_action( 'flatsome_before_page' ); ?>

<div id="content" class="content-area page-wrapper" role="main">
    <div class="row row-main">
        <div class="large-12 col">
            <div class="col-inner">

                <?php
                if ( ! is_user_logged_in() ) :
                    echo '<p class="woocommerce-info alert-info">Vui lòng <a href="' . wp_login_url( get_permalink() ) . '">đăng nhập</a> để sửa dự án.</p>';
                else :
                    // Lấy project_id từ URL
                    $project_id = isset( $_GET['project_id'] ) ? intval( $_GET['project_id'] ) : 0;
                    $current_user_id = get_current_user_id();
                    $post_author_id = get_post_field( 'post_author', $project_id );

                    // Kiểm tra xem project_id có hợp lệ và người dùng có quyền sửa không
                    if ( $project_id > 0 && get_post_type( $project_id ) == 'du_an_bds' && ( $post_author_id == $current_user_id || current_user_can( 'edit_others_posts' ) ) ) {

                        if ( function_exists( 'acf_form_head' ) ) {
                             acf_form_head();
                        }

                        $options = array(
                            'post_id' => $project_id, // Chỉ định ID bài viết cần sửa
                            'post_title' => true,
                            'post_content' => true,
                            'field_groups' => array(29527 ), // !! THAY XX BẰNG ID FIELD GROUP !!
                            'submit_value' => 'Cập nhật dự án',
                            'updated_message' => 'Dự án đã được cập nhật thành công!',
                            // 'return' => get_permalink($project_id), // Quay lại trang chi tiết dự án sau khi cập nhật
                            'uploader' => 'wp',
                        );

                        if ( function_exists( 'acf_form' ) ) {
                            acf_form( $options );
                        } else {
                            echo '<p>Vui lòng kích hoạt plugin Advanced Custom Fields Pro.</p>';
                        }

                    } else {
                        echo '<p class="woocommerce-error alert-danger">Dự án không tồn tại hoặc bạn không có quyền sửa dự án này.</p>';
                    }
                endif; // End is_user_logged_in() check
                ?>

            </div><!-- .col-inner -->
        </div><!-- .large-12 -->
    </div><!-- .row -->
</div>

<?php do_action( 'flatsome_after_page' ); ?>

<?php get_footer(); ?>
