<?php
/*
* 
 * Prefix and sufix to price
 * Author: https://thitruongdiaoc.net
  trong file gốc web140*/
/*
/*Add default setting*/
/*flickr slider*/
/*end flickr slider*/

/*menu san pham */
/* Tự động thêm Title, Alt-Text, Caption & Description cho hình ảnh by thuthuat.vip
--------------------------------------------------------------------------------------*/
/**
*  VI DE O
* @link https://developer.wordpress.org/themes/basics/theme-functions/
* @package willgroup
**/
          	
/**
 * Remove product data tabs xoa tab trong single products
 */
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['reviews'] );       // Xóa tab đánh giá
    unset( $tabs['additional_information'] );    // Xóa tab thuộc tính sản phẩm
    return $tabs;
}
/*remove metabox ( truong tuy bien san pham )*/
function lt_remove_metaboxes() {
     remove_meta_box( 'postcustom' , 'product' , 'normal' );
}
add_action( 'add_meta_boxes' , 'lt_remove_metaboxes', 50 );

/**
 * Đăng ký Custom Post Type: Dự án Bất động sản
 */
function bds_register_project_post_type() {
    $labels = array(
        'name'                  => _x( 'Dự án BĐS', 'Post type general name', 'flatsome-child' ),
        'singular_name'         => _x( 'Dự án BĐS', 'Post type singular name', 'flatsome-child' ),
        'menu_name'             => _x( 'Dự án BĐS', 'Admin Menu text', 'flatsome-child' ),
        'name_admin_bar'        => _x( 'Dự án BĐS', 'Add New on Toolbar', 'flatsome-child' ),
        'add_new'               => __( 'Thêm mới', 'flatsome-child' ),
        'add_new_item'          => __( 'Thêm dự án mới', 'flatsome-child' ),
        'new_item'              => __( 'Dự án mới', 'flatsome-child' ),
        'edit_item'             => __( 'Sửa dự án', 'flatsome-child' ),
        'view_item'             => __( 'Xem dự án', 'flatsome-child' ),
        'all_items'             => __( 'Tất cả dự án', 'flatsome-child' ),
        'search_items'          => __( 'Tìm kiếm dự án', 'flatsome-child' ),
        'parent_item_colon'     => __( 'Dự án cha:', 'flatsome-child' ),
        'not_found'             => __( 'Không tìm thấy dự án nào.', 'flatsome-child' ),
        'not_found_in_trash'    => __( 'Không có dự án nào trong thùng rác.', 'flatsome-child' ),
        'featured_image'        => _x( 'Ảnh đại diện dự án', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'flatsome-child' ),
        'set_featured_image'    => _x( 'Đặt ảnh đại diện', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'flatsome-child' ),
        'remove_featured_image' => _x( 'Xóa ảnh đại diện', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'flatsome-child' ),
        'use_featured_image'    => _x( 'Sử dụng làm ảnh đại diện', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'flatsome-child' ),
        'archives'              => _x( 'Lưu trữ dự án', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'flatsome-child' ),
        'insert_into_item'      => _x( 'Chèn vào dự án', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'flatsome-child' ),
        'uploaded_to_this_item' => _x( 'Tải lên dự án này', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'flatsome-child' ),
        'filter_items_list'     => _x( 'Lọc danh sách dự án', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'flatsome-child' ),
        'items_list_navigation' => _x( 'Điều hướng danh sách dự án', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'flatsome-child' ),
        'items_list'            => _x( 'Danh sách dự án', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'flatsome-child' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'du-an-bds' ), // Đường dẫn tĩnh cho dự án, ví dụ: /du-an-bds/ten-du-an
        'capability_type'    => 'post',
        'has_archive'        => true, // Bật trang lưu trữ (archive) cho CPT này, ví dụ: /du-an-bds/
        'hierarchical'       => false,
        'menu_position'      => 5, // Vị trí hiển thị trên menu admin
        'menu_icon'          => 'dashicons-building', // Icon trên menu admin (https://developer.wordpress.org/resource/dashicons/)
        // --- QUAN TRỌNG CHO UX BUILDER ---
        'supports'           => array(
            'title',          // Tiêu đề
            'editor',         // *** BẮT BUỘC: Trình soạn thảo (Block Editor/Classic Editor) ***
            'thumbnail',      // Ảnh đại diện
            'excerpt',        // Đoạn trích ngắn
            'custom-fields',  // *** BẮT BUỘC: Cho ACF hoạt động ***
            'author',         // Tác giả
            'page-attributes',// Cần thiết nếu muốn có thứ tự hoặc cha-con (thường không cần cho dự án)
            // 'revisions',   // Lưu các bản sửa đổi (tùy chọn)
            // 'comments'    // Cho phép bình luận (tùy chọn)
        ),
            'show_in_rest'       => true, // *** BẮT BUỘC: Cho Block Editor và UX Builder hoạt động ***
// --- KẾT THÚC PHẦN QUAN TRỌNG ---
);
    register_post_type( 'du_an_bds', $args );
}
add_action( 'init', 'bds_register_project_post_type', 0 );

// Cập nhật lại permalinks sau khi đăng ký CPT mới
// Vào Settings -> Permalinks và bấm Save Changes một lần.
/**
 * Đăng ký các Custom Taxonomies cho Dự án BĐS
 */
function bds_register_project_taxonomies() {

    // 1. Loại BĐS (Chung cư, Đất nền, ...)
    $labels_loai = array(
        'name'              => _x( 'Loại BĐS', 'taxonomy general name', 'flatsome-child' ),
        'singular_name'     => _x( 'Loại BĐS', 'taxonomy singular name', 'flatsome-child' ),
        'search_items'      => __( 'Tìm kiếm Loại BĐS', 'flatsome-child' ),
        'all_items'         => __( 'Tất cả Loại BĐS', 'flatsome-child' ),
        'parent_item'       => __( 'Loại BĐS cha', 'flatsome-child' ),
        'parent_item_colon' => __( 'Loại BĐS cha:', 'flatsome-child' ),
        'edit_item'         => __( 'Sửa Loại BĐS', 'flatsome-child' ),
        'update_item'       => __( 'Cập nhật Loại BĐS', 'flatsome-child' ),
        'add_new_item'      => __( 'Thêm Loại BĐS mới', 'flatsome-child' ),
        'new_item_name'     => __( 'Tên Loại BĐS mới', 'flatsome-child' ),
        'menu_name'         => __( 'Loại BĐS', 'flatsome-child' ),
    );
    $args_loai = array(
        'public' => true,
        'publicly_queryable' => true,
        'hierarchical'      => true, // Có phân cấp cha-con (như Category)
        'labels'            => $labels_loai,
        'show_ui'           => true,
        'show_admin_column' => true, // Hiển thị cột trong danh sách dự án admin
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'loai-bds' ), // Đường dẫn tĩnh, ví dụ: /loai-bds/chung-cu
        'show_in_rest'      => true,
    );
    register_taxonomy( 'loai_bds', array( 'du_an_bds' ), $args_loai ); // Gán taxonomy này cho CPT 'du_an_bds'

    // 2. Khu vực (Quận/Huyện -> Phường/Xã)
    $labels_khuvuc = array(
        'name'              => _x( 'Khu vực', 'taxonomy general name', 'flatsome-child' ),
        'singular_name'     => _x( 'Khu vực', 'taxonomy singular name', 'flatsome-child' ),
        'search_items'      => __( 'Tìm kiếm Khu vực', 'flatsome-child' ),
        'all_items'         => __( 'Tất cả Khu vực', 'flatsome-child' ),
        'parent_item'       => __( 'Khu vực cha', 'flatsome-child' ),
        'parent_item_colon' => __( 'Khu vực cha:', 'flatsome-child' ),
        'edit_item'         => __( 'Sửa Khu vực', 'flatsome-child' ),
        'update_item'       => __( 'Cập nhật Khu vực', 'flatsome-child' ),
        'add_new_item'      => __( 'Thêm Khu vực mới', 'flatsome-child' ),
        'new_item_name'     => __( 'Tên Khu vực mới', 'flatsome-child' ),
        'menu_name'         => __( 'Khu vực', 'flatsome-child' ),
    );
    $args_khuvuc = array(
        'hierarchical'      => true, // Có phân cấp cha-con
        'labels'            => $labels_khuvuc,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'khu-vuc' ), // ví dụ: /khu-vuc/quan-1/phuong-ben-nghe
        'show_in_rest'      => true,
    );
    register_taxonomy( 'khu_vuc', array( 'du_an_bds' ), $args_khuvuc );

    // 3. Hướng nhà (Đông, Tây, Nam, Bắc...)
    $labels_huong = array(
        'name'              => _x( 'Hướng nhà', 'taxonomy general name', 'flatsome-child' ),
        'singular_name'     => _x( 'Hướng nhà', 'taxonomy singular name', 'flatsome-child' ),
        'search_items'      => __( 'Tìm kiếm Hướng nhà', 'flatsome-child' ),
        'all_items'         => __( 'Tất cả Hướng nhà', 'flatsome-child' ),
        'parent_item'       => null, // Không có cha-con
        'parent_item_colon' => null,
        'edit_item'         => __( 'Sửa Hướng nhà', 'flatsome-child' ),
        'update_item'       => __( 'Cập nhật Hướng nhà', 'flatsome-child' ),
        'add_new_item'      => __( 'Thêm Hướng nhà mới', 'flatsome-child' ),
        'new_item_name'     => __( 'Tên Hướng nhà mới', 'flatsome-child' ),
        'menu_name'         => __( 'Hướng nhà', 'flatsome-child' ),
        'separate_items_with_commas' => __( 'Các hướng cách nhau bởi dấu phẩy', 'flatsome-child' ),
        'add_or_remove_items'        => __( 'Thêm hoặc xóa hướng', 'flatsome-child' ),
        'choose_from_most_used'      => __( 'Chọn từ các hướng phổ biến', 'flatsome-child' ),
        'not_found'                  => __( 'Không tìm thấy hướng nào.', 'flatsome-child' ),
    );
    $args_huong = array(
        'hierarchical'      => false, // Không phân cấp (giống như Tags)
        'labels'            => $labels_huong,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'huong-nha' ), // ví dụ: /huong-nha/dong-nam
        'show_in_rest'      => true,
    );
    register_taxonomy( 'huong_nha', array( 'du_an_bds' ), $args_huong );

    // 4. Pháp lý (Sổ hồng, Sổ đỏ...)
    $labels_phaply = array(
        'name'              => _x( 'Pháp lý', 'taxonomy general name', 'flatsome-child' ),
        'singular_name'     => _x( 'Pháp lý', 'taxonomy singular name', 'flatsome-child' ),
        'search_items'      => __( 'Tìm kiếm Pháp lý', 'flatsome-child' ),
        'all_items'         => __( 'Tất cả Pháp lý', 'flatsome-child' ),
        'parent_item'       => null,
        'parent_item_colon' => null,
        'edit_item'         => __( 'Sửa Pháp lý', 'flatsome-child' ),
        'update_item'       => __( 'Cập nhật Pháp lý', 'flatsome-child' ),
        'add_new_item'      => __( 'Thêm Pháp lý mới', 'flatsome-child' ),
        'new_item_name'     => __( 'Tên Pháp lý mới', 'flatsome-child' ),
        'menu_name'         => __( 'Pháp lý', 'flatsome-child' ),
        'separate_items_with_commas' => __( 'Các loại pháp lý cách nhau bởi dấu phẩy', 'flatsome-child' ),
        'add_or_remove_items'        => __( 'Thêm hoặc xóa pháp lý', 'flatsome-child' ),
        'choose_from_most_used'      => __( 'Chọn từ các loại pháp lý phổ biến', 'flatsome-child' ),
        'not_found'                  => __( 'Không tìm thấy loại pháp lý nào.', 'flatsome-child' ),
    );
    $args_phaply = array(
        'hierarchical'      => false, // Không phân cấp
        'labels'            => $labels_phaply,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'phap-ly' ), // ví dụ: /phap-ly/so-hong
        'show_in_rest'      => true,
    );
    register_taxonomy( 'phap_ly', array( 'du_an_bds' ), $args_phaply );

}
add_action( 'init', 'bds_register_project_taxonomies' );
function bds_register_project_tags_taxonomy() {

    $labels_tags = array(
        'name'                       => _x( 'Thẻ Dự án', 'taxonomy general name', 'flatsome-child' ),
        'singular_name'              => _x( 'Thẻ Dự án', 'taxonomy singular name', 'flatsome-child' ),
        'search_items'               => __( 'Tìm kiếm Thẻ', 'flatsome-child' ),
        'popular_items'              => __( 'Thẻ Phổ biến', 'flatsome-child' ),
        'all_items'                  => __( 'Tất cả Thẻ', 'flatsome-child' ),
        'parent_item'                => null, // Tags không có cha con
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Sửa Thẻ', 'flatsome-child' ),
        'update_item'                => __( 'Cập nhật Thẻ', 'flatsome-child' ),
        'add_new_item'               => __( 'Thêm Thẻ mới', 'flatsome-child' ),
        'new_item_name'              => __( 'Tên Thẻ mới', 'flatsome-child' ),
        'separate_items_with_commas' => __( 'Các thẻ cách nhau bởi dấu phẩy', 'flatsome-child' ),
        'add_or_remove_items'        => __( 'Thêm hoặc xóa thẻ', 'flatsome-child' ),
        'choose_from_most_used'      => __( 'Chọn từ các thẻ được dùng nhiều nhất', 'flatsome-child' ),
        'not_found'                  => __( 'Không tìm thấy thẻ nào.', 'flatsome-child' ),
        'menu_name'                  => __( 'Thẻ Dự án', 'flatsome-child' ),
        'back_to_items'              => __( '← Quay lại các thẻ', 'flatsome-child' ),
    );

    $args_tags = array(
        'hierarchical'          => false, // *** QUAN TRỌNG: false để hoạt động như Tags ***
        'labels'                => $labels_tags,
        'show_ui'               => true,
        'show_admin_column'     => true, // Hiển thị cột trong danh sách dự án admin
        'update_count_callback' => '_update_post_term_count', // Cần thiết cho non-hierarchical taxonomies
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'the-du-an' ), // Slug cho URL, ví dụ: /the-du-an/ten-the
        'public'                => true, // Cho phép truy cập trang lưu trữ tag
        'show_in_rest'          => true, // Hỗ trợ Gutenberg và REST API
    );

    // Đăng ký taxonomy 'the_du_an' và gán nó cho post type 'du_an_bds'
    register_taxonomy( 'the_du_an', array( 'du_an_bds' ), $args_tags );

}
add_action( 'init', 'bds_register_project_tags_taxonomy', 0 ); // Tham số 0 để chạy sớm

// QUAN TRỌNG: Cập nhật lại Permalinks sau khi thêm taxonomy mới
// Vào Settings -> Permalinks và bấm Save Changes một lần.

/**
 * Shortcode để hiển thị giá trị của một ACF field cho bài viết hiện tại.
 * Sử dụng: [bds_field name="ten_field_acf" post_id="123" prefix="Giá: " suffix=" VNĐ" format="number"]
 *
 * @param array $atts Thuộc tính shortcode.
 * - name (bắt buộc): Tên của ACF field.
 * - post_id (tùy chọn): ID của bài viết. Mặc định là bài viết hiện tại trong loop.
 * - prefix (tùy chọn): Chuỗi hiển thị trước giá trị.
 * - suffix (tùy chọn): Chuỗi hiển thị sau giá trị.
 * - format (tùy chọn): 'text' (mặc định), 'number' (định dạng số), 'image' (trả về thẻ img nếu là field ảnh), 'url' (trả về URL nếu là field file/link).
 * - image_size (tùy chọn): Kích thước ảnh nếu format='image' (mặc định: 'thumbnail').
 * - default (tùy chọn): Giá trị hiển thị nếu field rỗng.
 * @return string HTML hoặc giá trị của field.
 */
function bds_acf_field_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'name'       => '',
        'post_id'    => null,
        'prefix'     => '',
        'suffix'     => '',
        'format'     => 'text', // text, number, image, url
        'image_size' => 'thumbnail',
        'default'    => '',
    ), $atts, 'bds_field' );

    if ( empty( $atts['name'] ) ) {
        return '<!-- Thiếu thuộc tính "name" cho shortcode bds_field -->';
    }

    $post_id = $atts['post_id'] ? intval( $atts['post_id'] ) : get_the_ID();

    if ( ! $post_id ) {
        return '<!-- Không tìm thấy Post ID -->';
    }

    $value = get_field( $atts['name'], $post_id );

    if ( $value === null || $value === false || $value === '' ) {
        return esc_html( $atts['default'] );
    }

    $output = '';
    switch ( $atts['format'] ) {
        case 'number':
            if ( is_numeric( $value ) ) {
                // Bạn có thể thêm định dạng phức tạp hơn ở đây nếu cần
                $output = number_format( floatval( $value ), 0, ',', '.' );
            } else {
                $output = esc_html( $value ); // Trả về text nếu không phải số
            }
            break;
        case 'image':
            $image_output = '';
            if ( is_array( $value ) && isset( $value['ID'] ) ) { // Field Image trả về Array
                $image_output = wp_get_attachment_image( $value['ID'], $atts['image_size'] );
            } elseif ( is_numeric( $value ) ) { // Field Image trả về ID
                $image_output = wp_get_attachment_image( $value, $atts['image_size'] );
            } elseif ( is_string( $value ) && filter_var($value, FILTER_VALIDATE_URL) ) { // Field Image trả về URL
                 $image_output = '<img src="' . esc_url( $value ) . '" alt="" loading="lazy">'; // Cần thêm alt nếu có
            }
             $output = $image_output;
            break;
        case 'url':
             if ( is_array( $value ) && isset( $value['url'] ) ) { // Field File/Link trả về Array
                $output = esc_url( $value['url'] );
            } elseif ( is_string( $value ) && filter_var($value, FILTER_VALIDATE_URL) ) { // Field trả về URL
                 $output = esc_url( $value );
            }
             // Nếu muốn trả về thẻ <a> thì xử lý thêm ở đây
            break;
        case 'text':
        default:
             if ( is_array( $value ) ) {
                 // Xử lý field phức tạp (Repeater, Group,...) - Cần tùy chỉnh thêm
                 $output = '<!-- Kiểu field array chưa được hỗ trợ mặc định -->';
                 // Ví dụ đơn giản: implode nếu là checkbox/select multi
                 if(is_array($value) && !isset($value['ID']) && !isset($value['url'])){
                    $output = esc_html( implode(', ', $value) );
                 }
             } else {
                 $output = wp_kses_post( $value ); // Cho phép một số HTML an toàn
             }
            break;
    }

    if ( $output !== '' || ($output === '' && $atts['default'] !== '') ) {
        // Chỉ trả về $output nếu nó không rỗng HOẶC nếu nó rỗng nhưng có giá trị default
       $final_output = ($output !== '') ? $output : esc_html($atts['default']);

       // Sử dụng wp_kses_post cho prefix và suffix
       return wp_kses_post( $atts['prefix'] ) . $final_output . wp_kses_post( $atts['suffix'] );
   } else {
       // Nếu cả $output và $default đều rỗng, trả về chuỗi rỗng
       return '';
   }
}
add_shortcode( 'bds_field', 'bds_acf_field_shortcode' );


/**
 * Shortcode để hiển thị danh sách các terms của một taxonomy cho bài viết hiện tại.
 * Sử dụng: [bds_terms tax="ten_taxonomy" before="Loại: " sep=", " after="." link="true"]
 *
 * @param array $atts Thuộc tính shortcode.
 * - tax (bắt buộc): Slug của taxonomy.
 * - post_id (tùy chọn): ID của bài viết. Mặc định là bài viết hiện tại.
 * - before (tùy chọn): Chuỗi hiển thị trước danh sách.
 * - sep (tùy chọn): Chuỗi phân cách giữa các term.
 * - after (tùy chọn): Chuỗi hiển thị sau danh sách.
 * - link (tùy chọn): 'true' để liên kết đến trang lưu trữ của term, 'false' để chỉ hiển thị tên. Mặc định là 'true'.
 * @return string HTML danh sách các terms.
 */
function bds_taxonomy_terms_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'tax'     => '',
        'post_id' => null,
        'before'  => '',
        'sep'     => ', ',
        'after'   => '',
        'link'    => 'true', // 'true' or 'false'
    ), $atts, 'bds_terms' );

    if ( empty( $atts['tax'] ) ) {
        return '<!-- Thiếu thuộc tính "tax" cho shortcode bds_terms -->';
    }

    $post_id = $atts['post_id'] ? intval( $atts['post_id'] ) : get_the_ID();

    if ( ! $post_id ) {
        return '<!-- Không tìm thấy Post ID -->';
    }

    if ( $atts['link'] === 'true' ) {
        return get_the_term_list( $post_id, $atts['tax'], $atts['before'], $atts['sep'], $atts['after'] );
    } else {
        $terms = get_the_terms( $post_id, $atts['tax'] );
        if ( is_wp_error( $terms ) || empty( $terms ) ) {
            return '';
        }
        $term_names = wp_list_pluck( $terms, 'name' );
        return $atts['before'] . esc_html( implode( $atts['sep'], $term_names ) ) . $atts['after'];
    }
}
add_shortcode( 'bds_terms', 'bds_taxonomy_terms_shortcode' );
//Shortcut slider ACF
/**
 * Shortcode để hiển thị slider Flickity từ một ACF Gallery field.
 * Sử dụng: [bds_acf_gallery_slider name="ten_field_gallery" image_size="large" lightbox_size="full"]
 *
 * @param array $atts Thuộc tính shortcode.
 * - name (bắt buộc): Tên của ACF Gallery field.
 * - image_size (tùy chọn): Kích thước ảnh hiển thị trong slide (mặc định: 'large').
 * - lightbox_size (tùy chọn): Kích thước ảnh cho lightbox (mặc định: 'full').
 * @return string HTML của slider.
 */
function bds_acf_gallery_slider_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'name'          => '',
        'image_size'    => 'large', // Kích thước ảnh trong slide
        'lightbox_size' => 'full',  // Kích thước ảnh khi zoom lightbox
    ), $atts, 'bds_acf_gallery_slider' );

    if ( empty( $atts['name'] ) ) {
        return '<!-- Shortcode bds_acf_gallery_slider: Thiếu thuộc tính "name". -->';
    }

    $post_id = get_the_ID(); // Lấy ID của bài viết hiện tại đang xem
    if ( ! $post_id ) {
        return '<!-- Shortcode bds_acf_gallery_slider: Không tìm thấy Post ID. -->';
    }

    $images = get_field( $atts['name'], $post_id ); // Lấy dữ liệu gallery từ post hiện tại

    if ( empty( $images ) || ! is_array( $images ) ) {
        // Kiểm tra thêm ảnh đại diện làm fallback nếu không có gallery ACF
        if ( has_post_thumbnail( $post_id ) ) {
             $thumbnail_id = get_post_thumbnail_id( $post_id );
             $image_full_url = wp_get_attachment_image_url( $thumbnail_id, $atts['lightbox_size'] );
             $image_display_url = wp_get_attachment_image_url( $thumbnail_id, $atts['image_size'] );
             $image_caption = get_the_title( $post_id );
             $gallery_id = 'project-gallery-' . $post_id;

             ob_start(); // Bắt đầu output buffering cho fallback
             ?>
             <div class="featured-image-container alignfull mb-0 relative">
                 <div class="featured-image-wrapper" data-lightbox="gallery" data-lightbox-gallery-id="<?php echo esc_attr($gallery_id); ?>">
                      <img src="<?php echo esc_url($image_display_url); ?>" alt="<?php echo esc_attr($image_caption); ?>" loading="lazy" />
                      <a href="<?php echo esc_url($image_full_url); ?>"
                         title="<?php echo esc_attr($image_caption); ?>"
                         class="button zoom-button icon is-outline is-small circle lightbox-single"
                         data-lightbox-src="<?php echo esc_url($image_full_url); ?>">
                          <i class="icon-expand"></i>
                      </a>
                 </div>
             </div>
             <?php
             return ob_get_clean(); // Trả về HTML của ảnh đại diện
        }
        return '<!-- Shortcode bds_acf_gallery_slider: Không có ảnh trong gallery hoặc field không tồn tại. -->';
    }

    // --- Bắt đầu tạo HTML cho slider ---
    ob_start(); // Bắt đầu output buffering

    $gallery_id = 'project-gallery-' . $post_id;
    $slider_id = 'project-slider-' . $post_id;
    ?>
    <div id="<?php echo esc_attr($slider_id); ?>" class="project-main-slider slider-container alignfull mb-0 relative">
        <div class="loading-spin dark large centered"></div>
        <div class="slider slider-nav-circle slider-nav-large slider-nav-light slider-style-normal slider-show-on-init"
             data-flickity-options='{
                 "cellAlign": "left", "contain": true, "wrapAround": true, "autoPlay": 5000,
                 "prevNextButtons": true, "percentPosition": true, "imagesLoaded": true,
                 "pageDots": true, "adaptiveHeight": false, "rightToLeft": false,
                 "selectedAttraction": 0.02, "friction": 0.3
             }'
             data-lightbox="gallery"
             data-lightbox-gallery-id="<?php echo esc_attr($gallery_id); ?>"
             >
            <?php foreach( $images as $image ): ?>
                <?php
                    // Lấy URL ảnh theo kích thước yêu cầu
                    $image_display_url = isset($image['sizes'][$atts['image_size']]) ? $image['sizes'][$atts['image_size']] : $image['url'];
                    $image_full_url = isset($image['sizes'][$atts['lightbox_size']]) ? $image['sizes'][$atts['lightbox_size']] : $image['url'];
                    $image_caption = !empty($image['caption']) ? $image['caption'] : $image['title']; // Ưu tiên caption, sau đó title
                    $image_alt = !empty($image['alt']) ? $image['alt'] : $image['title'];
                ?>
                <div class="img-item ux-slide">
                    <div class="slide-wrapper">
                        <img src="<?php echo esc_url($image_display_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" loading="lazy" />
                        <a href="<?php echo esc_url($image_full_url); ?>"
                           title="<?php echo esc_attr($image_caption); ?>"
                           class="button zoom-button icon is-outline is-small circle"
                           data-lightbox-src="<?php echo esc_url($image_full_url); ?>"
                           >
                            <i class="icon-expand"></i>
                        </a>
                         <?php if(!empty($image['caption'])): ?>
                            <div class="caption absolute-bottom dark text-center op-8 pd-x-small fs-medium">
                                <?php echo esc_html($image['caption']); ?>
                            </div>
                         <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php

    return ob_get_clean(); // Trả về HTML của slider đã tạo
}
add_shortcode( 'bds_acf_gallery_slider', 'bds_acf_gallery_slider_shortcode' );

//End shortcut slider ACF
/**
 * Shortcode để hiển thị ảnh đại diện (Featured Image) của bài viết hiện tại.
 * Sử dụng: [bds_featured_image size="medium_large" link="true" class="custom-image-class" fallback_text="Ảnh đang cập nhật"]
 *
 * @param array $atts Thuộc tính shortcode.
 * - size (tùy chọn): Kích thước ảnh (mặc định: 'thumbnail').
 * - link (tùy chọn): 'true' để bọc ảnh bằng link đến bài viết, 'false' để chỉ hiển thị ảnh (mặc định: 'true').
 * - class (tùy chọn): Class CSS tùy chỉnh cho thẻ <img>.
 * - fallback_text (tùy chọn): Văn bản hiển thị nếu không có ảnh đại diện.
 * @return string HTML của ảnh đại diện (hoặc fallback).
 */
function bds_featured_image_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'size'          => 'thumbnail',
        'link'          => 'true',
        'class'         => 'bds-item-image', // Class mặc định
        'fallback_text' => '', // Có thể đặt placeholder mặc định ở đây
    ), $atts, 'bds_featured_image' );

    $post_id = get_the_ID();
    if ( !$post_id ) return '<!-- Không tìm thấy Post ID -->';

    $output = '';
    if ( has_post_thumbnail( $post_id ) ) {
        $image_html = get_the_post_thumbnail( $post_id, $atts['size'], array( 'class' => esc_attr( $atts['class'] ) ) );
        if ( $atts['link'] === 'true' ) {
            $output = '<a href="' . esc_url( get_permalink( $post_id ) ) . '" aria-label="' . esc_attr( get_the_title( $post_id ) ) . '" class="plain">' . $image_html . '</a>';
        } else {
            $output = $image_html;
        }
    } elseif ( !empty($atts['fallback_text']) ) {
         // Tạo placeholder nếu không có ảnh và có text fallback
         $aspect_ratio_style = ''; // Có thể thêm style aspect-ratio nếu muốn
         $output = '<div class="bds-archive-item-image placeholder-box ' . esc_attr($atts['class']) . '" style="' . $aspect_ratio_style . '"><span>' . esc_html($atts['fallback_text']) . '</span></div>';
    }

    return $output;
}
add_shortcode( 'bds_featured_image', 'bds_featured_image_shortcode' );


/**
 * Shortcode để hiển thị tiêu đề của bài viết hiện tại.
 * Sử dụng: [bds_post_title tag="h4" link="true" class="custom-title-class" limit="2"]
 *
 * @param array $atts Thuộc tính shortcode.
 * - tag (tùy chọn): Thẻ HTML bao ngoài tiêu đề (mặc định: 'h3').
 * - link (tùy chọn): 'true' để bọc tiêu đề bằng link đến bài viết (mặc định: 'true').
 * - class (tùy chọn): Class CSS tùy chỉnh cho thẻ bao ngoài (tag).
 * - limit (tùy chọn): Số dòng tối đa hiển thị (yêu cầu CSS hỗ trợ -webkit-line-clamp).
 * @return string HTML của tiêu đề.
 */
function bds_post_title_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'tag'   => 'h3',
        'link'  => 'true',
        'class' => 'bds-item-title uppercase', // Class mặc định
        'limit' => 0, // Số dòng giới hạn, 0 là không giới hạn
    ), $atts, 'bds_post_title' );

    $post_id = get_the_ID();
    if ( !$post_id ) return '<!-- Không tìm thấy Post ID -->';

    $title = get_the_title( $post_id );
    if ( empty($title) ) return '';

    $tag = tag_escape( $atts['tag'] ); // Đảm bảo tag hợp lệ
    $classes = esc_attr( $atts['class'] );
    $style = '';

    // Thêm style cho giới hạn dòng nếu có
    if ( intval($atts['limit']) > 0 ) {
        $classes .= ' has-line-clamp'; // Thêm class để CSS dễ hơn
        $style = ' style="-webkit-line-clamp: ' . intval($atts['limit']) . ';"';
    }

    $output = '<' . $tag . ' class="' . $classes . '"' . $style . '>';
    if ( $atts['link'] === 'true' ) {
        $output .= '<a href="' . esc_url( get_permalink( $post_id ) ) . '" class="plain">' . esc_html( $title ) . '</a>';
    } else {
        $output .= esc_html( $title );
    }
    $output .= '</' . $tag . '>';

    return $output;
}
add_shortcode( 'bds_post_title', 'bds_post_title_shortcode' );


/**
 * Shortcode để tạo nút bấm hoặc link đến bài viết hiện tại.
 * Sử dụng: [bds_permalink text="Xem thêm" class="button primary is-small" icon="icon-angle-right" icon_pos="after"]
 *
 * @param array $atts Thuộc tính shortcode.
 * - text (tùy chọn): Nội dung text của link/button (mặc định: 'Xem chi tiết').
 * - class (tùy chọn): Class CSS tùy chỉnh cho thẻ <a> (mặc định: ''). Có thể thêm class 'button' của Flatsome.
 * - icon (tùy chọn): Class của icon Flatsome (ví dụ: 'icon-angle-right').
 * - icon_pos (tùy chọn): Vị trí icon 'before' hoặc 'after' text (mặc định: 'after').
 * @return string HTML của link/button.
 */
function bds_permalink_shortcode( $atts ) {
     $atts = shortcode_atts( array(
        'text'     => 'Xem chi tiết',
        'class'    => 'button primary is-outline is-small lowercase', // Class button mặc định
        'icon'     => 'icon-angle-right', // Icon mặc định
        'icon_pos' => 'after', // 'before' hoặc 'after'
    ), $atts, 'bds_permalink' );

    $post_id = get_the_ID();
    if ( !$post_id ) return '<!-- Không tìm thấy Post ID -->';

    $link = get_permalink( $post_id );
    $text_content = esc_html( $atts['text'] );
    $icon_html = '';
    if (!empty($atts['icon'])) {
        $icon_html = '<i class="' . esc_attr($atts['icon']) . '"></i>';
    }

    $output = '<a href="' . esc_url( $link ) . '" class="' . esc_attr( $atts['class'] ) . '">';
    if ( $atts['icon_pos'] === 'before' && $icon_html ) {
        $output .= $icon_html . ' ';
    }
    $output .= '<span>' . $text_content . '</span>'; // Bọc span để icon dễ style
    if ( $atts['icon_pos'] === 'after' && $icon_html ) {
        $output .= ' ' . $icon_html;
    }
    $output .= '</a>';

    return $output;
}
add_shortcode( 'bds_permalink', 'bds_permalink_shortcode' );
/**
 * Shortcode để hiển thị đoạn trích ngắn (excerpt) của bài viết hiện tại.
 * Sử dụng: [bds_excerpt length="200" more="..."]
 *
 * @param array $atts Thuộc tính shortcode.
 * - length (tùy chọn): Số lượng ký tự tối đa (mặc định: 150).
 * - more (tùy chọn): Chuỗi hiển thị ở cuối nếu nội dung bị cắt ngắn (mặc định: '...').
 * @return string HTML của đoạn trích ngắn.
 */
function bds_excerpt_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'length' => 150, // Độ dài mặc định
        'more'   => '...', // Dấu ... mặc định
    ), $atts, 'bds_excerpt' );

    $post_id = get_the_ID();
    if ( !$post_id ) return '<!-- Không tìm thấy Post ID -->';

    $excerpt = '';
    // Ưu tiên lấy Excerpt được nhập thủ công
    if ( has_excerpt( $post_id ) ) {
        $excerpt = get_the_excerpt( $post_id );
    } else {
        // Nếu không có excerpt, lấy từ nội dung chính
        $content = get_the_content( null, false, $post_id ); // Lấy content chưa áp dụng filter
        $content = strip_shortcodes( $content ); // Bỏ shortcodes
        $content = wp_strip_all_tags( $content ); // Bỏ hết thẻ HTML
        $excerpt = $content;
    }

    // Giới hạn độ dài ký tự
    $limit = intval( $atts['length'] );
    if ( mb_strlen( $excerpt ) > $limit ) {
        $excerpt = mb_substr( $excerpt, 0, $limit );
        // Tìm khoảng trắng cuối cùng để cắt cho đẹp (tránh cắt giữa từ)
        $last_space = mb_strrpos( $excerpt, ' ' );
        if ( $last_space !== false ) {
            $excerpt = mb_substr( $excerpt, 0, $last_space );
        }
        $excerpt .= esc_html( $atts['more'] ); // Thêm dấu ...
    }

    // Chỉ trả về nếu có nội dung
    if ( !empty($excerpt) ) {
        // Sử dụng wp_kses_post để cho phép một số định dạng cơ bản nếu bạn muốn
        // Hoặc dùng esc_html nếu chỉ muốn text thuần túy
        return '<p class="bds-item-excerpt">' . wp_kses_post( $excerpt ) . '</p>';
    }

    return ''; // Trả về rỗng nếu không có gì
}
add_shortcode( 'bds_excerpt', 'bds_excerpt_shortcode' );
function chu_dau_tu() {
    /* Biến $label chứa các tham số thiết lập tên hiển thị của Taxonomy
     */
    $labels = array(
            'name' => 'Chủ đầu tư',
            'singular' => 'Danh mục chủ đầu tư',
            'menu_name' => 'Chủ đầu tư'
    );
    /* Biến $args khai báo các tham số trong custom taxonomy cần tạo
     */
    $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => true,
            'show_tagcloud'              => true,
    );
    
    /* Hàm register_taxonomy để khởi tạo taxonomy
     */
    register_taxonomy('chu-dau-tu', array( 'du_an_bds' ), $args);
}
// Hook into the 'init' action
add_action( 'init', 'chu_dau_tu', 0 );
/*
 * Chống spam cho contact form 7 bằng định dạng số điện thoại
 * Author: levantoan.com
 * */
add_filter('wpcf7_validate_tel', 'devvn_custom_validate_sdt', 10, 2);
add_filter('wpcf7_validate_tel*', 'devvn_custom_validate_sdt', 10, 2);
function devvn_custom_validate_sdt($result, $tag) {
    $name = $tag->name;
    if ($name === 'your-tel') {
        $sdt = isset($_POST[$name]) ? wp_unslash($_POST[$name]) : '';
        if (!preg_match('/^0([0-9]{9,10})+$/D', $sdt)) {
            $result->invalidate($tag, 'Số điện thoại không hợp lệ.');
        }
    }
    return $result;
}

    /**
     * Enqueue scripts and styles.
     */

    // 3. Hide ACF field group menu item
    //add_filter('acf/settings/show_admin', '__return_false');
    
    /**
     * Custom fields
     */
    require get_template_directory() . '/../web140/inc/real-estate.php';

    /**
     * Register widget area.
     */
    //require get_template_directory() . '/../web140/inc/widgets.php';
    //require get_template_directory() . '/../web140/inc/widgets/widget-new-posts.php';
    
    /**
     * Ajax functions
     */
    //require get_template_directory() . '/../web140/inc/ajax.php';
    
    /**
     * Utility functions.
     */
    require get_template_directory() . '/../web140/inc/functions.php';
    

// Add the info to the email tracking
function wpshore_wpcf7_before_send_mail($array) {
    global $wpdb;
    if(wpautop($array['body']) == $array['body']) // The email is of HTML type
        $lineBreak = "<br/>";
    else
        $lineBreak = "\n";
    $trackingInfo .= $lineBreak . $lineBreak . '-- Tracking Info --' . $lineBreak;
    $trackingInfo .= 'URL điền form: ' . $_SERVER['HTTP_REFERER'] . $lineBreak;
    if (isset ($_SESSION['OriginalRef']) )
        $trackingInfo .= 'Người dùng đến từ trang: ' . $_SESSION['OriginalRef'] . $lineBreak;
    if (isset ($_SESSION['LandingPage']) )
        $trackingInfo .= 'Trang đích trước khi điền form: ' . $_SESSION['LandingPage'] . $lineBreak;
    if ( isset ($_SERVER["REMOTE_ADDR"]) )
    $trackingInfo .= 'IP người dùng: ' . $_SERVER["REMOTE_ADDR"] . $lineBreak;
    if ( isset ($_SERVER["HTTP_X_FORWARDED_FOR"]))
        $trackingInfo .= 'User\'s Proxy Server IP: ' . $_SERVER["HTTP_X_FORWARDED_FOR"] . $lineBreak . $lineBreak;
    if ( isset ($_SERVER["HTTP_USER_AGENT"]) )
        $trackingInfo .= 'Thông tin trình duyệt: ' . $_SERVER["HTTP_USER_AGENT"] . $lineBreak;
    $array['body'] = str_replace('[tracking-info]', $trackingInfo, $array['body']);
    return $array;
}
add_filter('wpcf7_mail_components', 'wpshore_wpcf7_before_send_mail');

// Original Referrer 
function wpshore_set_session_values() 
{
	if (!session_id()) 
	{
		session_start();
	}
	if (!isset($_SESSION['OriginalRef'])) 
	{
		$_SESSION['OriginalRef'] = $_SERVER['HTTP_REFERER']; 
	}
	if (!isset($_SESSION['LandingPage'])) 
	{
		$_SESSION['LandingPage'] = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]; 
	}
}
add_action('init', 'wpshore_set_session_values');


function wpcb_contact_form_7() {
    $load_scripts = false;
    if( is_singular() ) {
        $post = get_post();
        if( has_shortcode($post->post_content, 'contact-form-7') ) {
            $load_scripts = true;
        }
    }
    if( ! $load_scripts ) {
        wp_dequeue_script( 'contact-form-7' );
    wp_dequeue_script( 'google-recaptcha' );
    wp_dequeue_script( 'wpcf7-recaptcha' );
        wp_dequeue_script( 'wpcf7-redirect-script' );
        wp_dequeue_style( 'contact-form-7' );
    wp_dequeue_style( 'cf7-confirmation-addon' );
        wp_dequeue_style( 'wpcf7-redirect-script-frontend' );
    }
}
add_action( 'wp_enqueue_scripts', 'wpcb_contact_form_7', 99 );
/*==============================CUSTOM======================================*/
// add taxonomy nhu cau
// 
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 ); 
add_action( 'init', 'custom_taxonomy_Item' );
function custom_taxonomy_Item()  {
$labels = array(
    'name'                       => 'Nhu Cầu',
    'singular_name'              => 'Nhu Cầu',
    'menu_name'                  => 'Nhu Cầu',
    'all_items'                  => 'Tất cả Nhu Cầu',
    'parent_item'                => 'Nhu Cầu cha',
    'parent_item_colon'          => 'Nhu Cầu cha:',
    'new_item_name'              => 'Nhu Cầu mới',
    'add_new_item'               => 'Thêm Nhu Cầu',
    'edit_item'                  => 'Sửa Nhu Cầu',
    'update_item'                => 'Cập nhật Nhu Cầu',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'phan-loai', 'product', $args );
register_taxonomy_for_object_type( 'phan-loai', 'product' );
}
// add taxonomy khoang gia
add_action( 'init', 'custom_taxonomy_kg' );
function custom_taxonomy_kg()  {
$labels = array(
    'name'                       => 'Khoảng Giá',
    'singular_name'              => 'Khoảng Giá',
    'menu_name'                  => 'Khoảng Giá',
    'all_items'                  => 'Tất cả Khoảng Giá',
    'parent_item'                => 'Khoảng Giá cha',
    'parent_item_colon'          => 'Khoảng Giá cha:',
    'new_item_name'              => 'Khoảng Giá mới',
    'add_new_item'               => 'Thêm Khoảng Giá',
    'edit_item'                  => 'Sửa Khoảng Giá',
    'update_item'                => 'Cập nhật Khoảng Giá',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'khoang-gia', 'product', $args );
register_taxonomy_for_object_type( 'khoang-gia', 'product' );
}
// add taxonomy so phong ngu
add_action( 'init', 'custom_taxonomy_pn' );
function custom_taxonomy_pn()  {
$labels = array(
    'name'                       => 'Số Phòng Ngủ',
    'singular_name'              => 'Số Phòng Ngủ',
    'menu_name'                  => 'Số Phòng Ngủ',
    'all_items'                  => 'Tất cả Số Phòng Ngủ',
    'new_item_name'              => 'Số Phòng Ngủ mới',
    'add_new_item'               => 'Thêm Số Phòng Ngủ',
    'edit_item'                  => 'Sửa Số Phòng Ngủ',
    'update_item'                => 'Cập nhật Số Phòng Ngủ',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'phong-ngu', 'product', $args );
register_taxonomy_for_object_type( 'phong-ngu', 'product' );
}
// add taxonomy huong ban cong
add_action( 'init', 'custom_taxonomy_huong' );
function custom_taxonomy_huong()  {
$labels = array(
    'name'                       => 'Hướng ban công',
    'singular_name'              => 'Hướng ban công',
    'menu_name'                  => 'Hướng ban công',
    'all_items'                  => 'Tất cả Hướng ban công',
    'new_item_name'              => 'Hướng ban công mới',
    'add_new_item'               => 'Thêm Hướng ban công',
    'edit_item'                  => 'Sửa Hướng ban công',
    'update_item'                => 'Cập nhật Hướng ban công',
    'separate_items_with_commas' => 'Separate Item with commas',
    'search_items'               => 'Search Items',
    'add_or_remove_items'        => 'Add or remove Items',
    'choose_from_most_used'      => 'Choose from the most used Items',
);
$args = array(
    'labels'                     => $labels,
    'hierarchical'               => true,
    'public'                     => true,
    'show_ui'                    => true,
    'show_admin_column'          => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
);
register_taxonomy( 'huong-ban-cong', 'product', $args );
register_taxonomy_for_object_type( 'huong-ban-cong', 'product' );
}
//* Enqueue scripts and styles
add_action( 'wp_enqueue_scripts', 'crunchify_disable_woocommerce_loading_css_js' );
 
function crunchify_disable_woocommerce_loading_css_js() {
 
	// Check if WooCommerce plugin is active
	if( function_exists( 'is_woocommerce' ) ){
 
		// Check if it's any of WooCommerce page
		if(! is_woocommerce() && ! is_cart() && ! is_checkout() ) { 		
			
			## Dequeue WooCommerce styles
			wp_dequeue_style('woocommerce-layout'); 
			wp_dequeue_style('woocommerce-general'); 
			wp_dequeue_style('woocommerce-smallscreen'); 	
 
			## Dequeue WooCommerce scripts
			wp_dequeue_script('wc-cart-fragments');
			wp_dequeue_script('woocommerce'); 
			wp_dequeue_script('wc-add-to-cart'); 
		
			wp_deregister_script( 'js-cookie' );
			wp_dequeue_script( 'js-cookie' );
 
		}
	}	

 
    function custom_filter_wpcf7_is_tel( $result, $tel ) {
        $result = preg_match( '/^(032|033|034|035|036|037|038|039|086|096|097|098|081|082|083|084|085|088|091|094|056|058|092|070|076|077|078|079|089|090|093|099|059)+([0-9]{7})$/;', $tel );
        return $result;
      }
      add_filter( 'wpcf7_is_tel', 'custom_filter_wpcf7_is_tel', 10, 2 ); 

}

//them so dien thoai va comment
add_filter('comment_form_default_fields', 'devvn_website_remove');
function devvn_website_remove($fields)
{
    if (isset($fields['email'])) unset($fields['email']);
    if (isset($fields['url'])) unset($fields['url']);
    return $fields;
}
if(!function_exists('devvn_array_insert_before')) {
    function devvn_array_insert_before($key, array &$array, $new_key, $new_value)
    {
        if (array_key_exists($key, $array)) {
            $new = array();
            foreach ($array as $k => $value) {
                if ($k === $key) {
                    $new[$new_key] = $new_value;
                }
                $new[$k] = $value;
            }
            return $new;
        }
        return FALSE;
    }
}
add_filter('comment_form_default_fields', 'devvn_add_phone_comment_form_defaults');
function devvn_add_phone_comment_form_defaults($fields)
{
    $commenter = wp_get_current_commenter();
    $fields_phone = '<p class="comment-form-url">' .
        '<label for="phone">' . __('Số điện thoại') . '<span class="required">*</span></label>' .
        '<input id="phone" name="phone" type="text" size="30"  tabindex="4" required="required"/></p>';
    $fields['author'] = '<p class="comment-form-author">' . '<label for="author">' . __('Họ tên <span class="required">*</span>') . '</label> ' .
        '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30" maxlength="245" /></p>';
    $fields_new = devvn_array_insert_before('cookies', $fields, 'phone', $fields_phone);
    if ($fields_new) $fields = $fields_new;
    return $fields;
}
add_action('comment_post', 'devvn_save_comment_meta_data');
function devvn_save_comment_meta_data($comment_id)
{
    if ((isset($_POST['phone'])) && ($_POST['phone'] != ''))
        $phone = wp_filter_nohtml_kses($_POST['phone']);
    add_comment_meta($comment_id, 'phone', $phone);
}
add_filter('preprocess_comment', 'devvn_verify_comment_meta_data');
function devvn_verify_comment_meta_data($commentdata)
{
    if (!is_admin() && !is_user_logged_in() && 'post' === get_post_type( absint( $_POST['comment_post_ID'] ))) {
        if (!isset($_POST['phone']))
            wp_die(__('Lỗi: Số điện thoại là bắt buộc'));
        $phone = $_POST['phone'];
        if (!(preg_match('/^0([0-9]{9,10})+$/D', $phone))) {
            wp_die(__('Lỗi: Số điện thoại không đúng định dạng'));
        }
        if ($commentdata['comment_author'] == '')
            wp_die('Lỗi: Xin hãy nhập tên của bạn');
    }
    return $commentdata;
}
add_filter('comment_text', 'devvn_modify_comment');
function devvn_modify_comment($text)
{
    $commentphone = get_comment_meta(get_comment_ID(), 'phone', true);
    if ($commentphone && is_admin()) {
        $commentphone = '<br/>SĐT: <strong>' . esc_attr($commentphone) . '</strong>';
        $text = $text . $commentphone;
    }
    return $text;
}
add_filter('option_require_name_email', '__return_false');

//code slider thumnail
/*
* Chia sẻ bởi NinhBinhWeb - https://giuseart.com - https://toptheme.info
* Code backend tạo element Slider with Thumnail với Flatsome theme
*/
function flatsome_ux_builder_template_nbw( $path ) {
    ob_start();
    include get_template_directory() . '/inc/builder/shortcodes/templates/' . $path;
    return ob_get_clean();
  }
  function flatsome_ux_builder_thumbnail_nbw( $name ) {
    return get_template_directory_uri() . '/inc/builder/shortcodes/thumbnails/' . $name . '.svg';
  }
  function flatsome_ux_builder_template_thumb_nbw( $name ) {
    return get_template_directory_uri() . '/inc/builder/templates/thumbs/' . $name . '.jpg';
  }
  function nbw_custom_shortcode_slider_thumnail(){
  add_ux_builder_shortcode( 'slider_thumnail', array(
      'type' => 'container',
      'name' => __( 'slider_thumnail' ),
      'category' => __( 'Layout' ),
      'message' => __( 'Add slides here' ),
      'directives' => array( 'ux-slider' ),
      'allow' => array( 'ux_banner','ux_image','section','row','ux_banner_grid','logo'),
      'template' => flatsome_ux_builder_template_nbw( 'ux_slider.html' ),
      'thumbnail' =>  flatsome_ux_builder_thumbnail_nbw( 'slider' ),
      'tools' => 'shortcodes/ux_slider/ux-slider-tools.directive.html',
      'wrap'   => false,
      'info' => '{{ label }}',
      'priority' => -1,
   
      'toolbar' => array(
          'show_children_selector' => true,
          'show_on_child_active' => true,
      ),
   
      'children' => array(
          'inline' => true,
          'addable_spots' => array( 'left', 'right' )
      ),
   
   
      'options' => array(
          'label' => array(
              'type' => 'textfield',
              'heading' => 'Admin label',
              'placeholder' => 'Enter admin label...'
          ),
          'type' => array(
            'type' => 'select',
            'heading' => 'Type',
            'default' => 'slide',
            'options' => array(
              'slide' => 'Slide',
            ),
          ),
          'layout_options' => array(
            'type' => 'group',
            'heading' => __( 'Layout' ),
            'options' => array(
              'style' => array(
                'type' => 'select',
                'heading' => 'Style',
                'default' => 'normal',
                'options' => array(
                    'normal' => 'Default',
                    'container' => 'Container',
                    'focus' => 'Focus',
                    'shadow' => 'Shadow',
                ),
                'conditions' => 'type !== "fade"',
              ),
              'slide_width' => array(
                'type' => 'scrubfield',
                'heading' => 'Slide Width',
                'placeholder' => 'Width in Px',
                'default' => '',
                'min' => '0',
                'conditions' => 'type !== "fade"',
              ),
   
              'slide_align' => array(
                  'type' => 'select',
                'heading' => 'Slide Align',
                'default' => 'center',
                'options' => array(
                    'center' => 'Center',
                    'left' => 'Left',
                    'right' => 'Right',
                ),
                'conditions' => 'type !== "fade"',
              ),
              'bg_color' => array(
                'type' => 'colorpicker',
                'heading' => __('Bg Color'),
                'format' => 'rgb',
                'position' => 'bottom right',
                'helpers' => require( get_template_directory(). '/inc/builder/shortcodes/helpers/colors.php' ),
              ),
              'margin' => array(
                'type' => 'scrubfield',
                'responsive' => true,
                'heading' => __('Margin'),
                'default' => '0px',
                'min' => 0,
                'max' => 100,
                'step' => 1
              ),
              'infinitive' => array(
                  'type' => 'radio-buttons',
                  'heading' => __('Infinitive'),
                  'default' => 'false',
                  'options' => array(
                      'false'  => array( 'title' => 'Off'),
                      'true'  => array( 'title' => 'On'),
                  ),
              ),
              'freescroll' => array(
                  'type' => 'radio-buttons',
                  'heading' => __('Free Scroll'),
                  'default' => 'false',
                  'options' => array(
                      'false'  => array( 'title' => 'Off'),
                      'true'  => array( 'title' => 'On'),
                  ),
              ),
              'draggable' => array(
                  'type' => 'radio-buttons',
                  'heading' => __('Draggable'),
                  'default' => 'true',
                  'options' => array(
                      'false'  => array( 'title' => 'Off'),
                      'true'  => array( 'title' => 'On'),
                  ),
              ),
              'parallax' => array(
                  'type' => 'slider',
                  'heading' => 'Parallax',
                  'unit' => '+',
                  'default' => 0,
                  'max' => 10,
                  'min' => 0,
              ),
              'mobile' => array(
                  'type' => 'radio-buttons',
                  'heading' => __('Show for Mobile'),
                  'default' => 'true',
                  'options' => array(
                      'false'  => array( 'title' => 'Off'),
                      'true'  => array( 'title' => 'On'),
                  ),
              ),
            ),
          ),
   
          'nav_options' => array(
            'type' => 'group',
            'heading' => __( 'Navigation' ),
            'options' => array(
              'hide_nav' => array(
                  'type' => 'radio-buttons',
                  'heading' => __('Always Visible'),
                  'default' => '',
                  'options' => array(
                      ''  => array( 'title' => 'Off'),
                      'true'  => array( 'title' => 'On'),
                  ),
              ),
              'nav_pos' => array(
                'type' => 'select',
                'heading' => 'Position',
                'default' => '',
                'options' => array(
                    '' => 'Inside',
                    'outside' => 'Outside',
                )
              ),
             'nav_size' => array(
                'type' => 'select',
                'heading' => 'Size',
                'default' => 'large',
                'options' => array(
                    'large' => 'Large',
                    'normal' => 'Normal',
                )
              ),
              'arrows' => array(
                'type' => 'radio-buttons',
                'heading' => __('Arrows'),
                'default' => 'true',
                'options' => array(
                  'false'  => array( 'title' => 'Off'),
                  'true'  => array( 'title' => 'On'),
                  ),
              ),
              'nav_style' => array(
                'type' => 'select',
                'heading' => __('Arrow Style'),
                'default' => 'circle',
                'options' => array(
                    'circle' => 'Circle',
                    'simple' => 'Simple',
                    'reveal' => 'Reveal',
                )
              ),
              'nav_color' => array(
                  'type' => 'radio-buttons',
                  'heading' => __('Arrow Color'),
                  'default' => 'light',
                  'options' => array(
                      'dark'  => array( 'title' => 'Dark'),
                      'light'  => array( 'title' => 'Light'),
                  ),
              ),
   
              'bullets' => array(
                'type' => 'radio-buttons',
                'heading' => __('Bullets'),
                'default' => 'false',
                'options' => array(
                    'false'  => array( 'title' => 'Off'),
                    'true'  => array( 'title' => 'On'),
                ),
              ),
              'bullet_style' => array(
                'type' => 'select',
                'heading' => 'Bullet Style',
                'default' => 'circle',
                'options' => array(
                  'circle' => 'Circle',
                  'dashes' => 'Dashes',
                  'dashes-spaced' => 'Dashes (Spaced)',
                  'simple' => 'Simple',
                  'square' => 'Square',
              )
             ),
            ),
          ),
          'slide_options' => array(
            'type' => 'group',
            'heading' => __( 'Auto Slide' ),
            'options' => array(
              'auto_slide' => array(
                  'type' => 'radio-buttons',
                  'heading' => __('Auto slide'),
                  'default' => 'true',
                  'options' => array(
                      'false'  => array( 'title' => 'Off'),
                      'true'  => array( 'title' => 'On'),
                  ),
              ),
              'timer' => array(
                  'type' => 'textfield',
                  'heading' => 'Timer (ms)',
                  'default' => 6000,
              ),
              'pause_hover' => array(
                  'type' => 'radio-buttons',
                  'heading' => __('Pause on Hover'),
                  'default' => 'true',
                  'options' => array(
                      'false'  => array( 'title' => 'Off'),
                      'true'  => array( 'title' => 'On'),
                  ),
              ),
            ),
          ),
              'advanced_options' => require( get_template_directory() . '/inc/builder/shortcodes/commons/advanced.php'),
      ),
  ) );
  }
  add_action('ux_builder_setup', 'nbw_custom_shortcode_slider_thumnail');
  function slider_thumnail( $atts, $content = null ){
    extract( shortcode_atts( array(
          '_id' => 'slider-'.rand(),
          'timer' => '6000',
          'bullets' => 'false',
          'visibility' => '',
          'class' => '',
          'type' => '',
          'bullet_style' => '',
          'auto_slide' => 'true',
          'auto_height' => 'true',
          'bg_color' => '',
          'slide_align' => 'center',
          'style' => 'normal',
          'slide_width' => '',
          'arrows' => 'true',
          'pause_hover' => 'true',
          'hide_nav' => '',
          'nav_style' => 'circle',
          'nav_color' => 'light',
          'nav_size' => 'large',
          'nav_pos' => '',
          'infinitive' => 'false',
          'freescroll' => 'false',
          'parallax' => '0',
          'margin' => '',
          'columns' => '1',
          'height' => '',
          'rtl' => 'false',
          'draggable' => 'true',
          'friction' => '0.6',
          'selectedattraction' => '0.1',
          'threshold' => '10',
          'class_slider' => '',
          // Derpicated
          'mobile' => 'true',
   
      ), $atts ) );
   
      // Stop if visibility is hidden
      if($visibility == 'hidden') return;
      if($mobile !==  'true' && !$visibility) {$visibility = 'hide-for-small';}
   
      ob_start();
   
      $wrapper_classes = array('slider-wrapper', 'relative');
      if( $class ) $wrapper_classes[] = $class;
      if( $visibility ) $wrapper_classes[] = $visibility;
      $wrapper_classes = implode(" ", $wrapper_classes);
   
      $classes = array('slider');
   
      if ($type == 'fade') $classes[] = 'slider-type-'.$type;
   
      // Bullet style
      if($bullet_style) $classes[] = 'slider-nav-dots-'.$bullet_style;
   
      // Nav style
      if($nav_style) $classes[] = 'slider-nav-'.$nav_style;
   
      // Nav size
      if($nav_size) $classes[] = 'slider-nav-'.$nav_size;
   
      // Nav Color
      if($nav_color) $classes[] = 'slider-nav-'.$nav_color;
   
      // Nav Position
      if($nav_pos) $classes[] = 'slider-nav-'.$nav_pos;
   
      // Add timer
      if($auto_slide == 'true') $auto_slide = $timer;
   
      // Add Slider style
      if($style) $classes[] = 'slider-style-'.$style;
      // Always show Nav if set
      if($hide_nav ==  'true') {$classes[] = 'slider-show-nav';}
   
      // Slider Nav visebility
      $is_arrows = 'true';
      $is_bullets = 'true';
   
      if($arrows == 'false') $is_arrows = 'false';
      if($bullets == 'false') $is_bullets = 'false';
   
      if(is_rtl()) $rtl = 'true';
   
      $classes = implode(" ", $classes);
   
      // Inline CSS
      $css_args = array(
          'bg_color' => array(
            'attribute' => 'background-color',
            'value' => $bg_color,
          ),
          'margin' => array(
            'attribute' => 'margin-bottom',
            'value' => $margin,
          )
      );
  ?>
  <div class="<?php echo $wrapper_classes; ?>" id="<?php echo $_id; ?>" <?php echo get_shortcode_inline_css($css_args); ?>>
      <div class="<?php echo $classes; ?> <?php echo $_id; ?>"
          data-flickity-options='{
              
              "cellAlign": "<?php echo $slide_align; ?>",
              "imagesLoaded": true,
              "lazyLoad": 1,
              "freeScroll": <?php echo $freescroll; ?>,
              "wrapAround": <?php echo $infinitive; ?>,
              "autoPlay": <?php echo $auto_slide;?>,
              "pauseAutoPlayOnHover" : <?php echo $pause_hover; ?>,
              "prevNextButtons": <?php echo $is_arrows; ?>,
              "contain" : true,
              "adaptiveHeight" : <?php echo $auto_height;?>,
              "dragThreshold" : <?php echo $threshold ;?>,
              "percentPosition": true,
              "pageDots": <?php echo $is_bullets; ?>,
              "rightToLeft": <?php echo $rtl; ?>,
              "draggable": <?php echo $draggable; ?>,
              "selectedAttraction": <?php echo $selectedattraction; ?>,
              "parallax" : <?php echo $parallax; ?>,
              "friction": <?php echo $friction; ?>
          }'
          >
          <?php echo do_shortcode($content); ?>
      </div>
      <div class="slider-custom <?php echo $classes; ?> "
          data-flickity-options='{
              "asNavFor": "<?php echo '.'.$_id;?>",
               "cellAlign": "<?php echo $slide_align; ?>",
              "imagesLoaded": true,
              "freeScroll": <?php echo $freescroll; ?>,
              "wrapAround": <?php echo $infinitive; ?>,
              "autoPlay": <?php echo $auto_slide;?>,
              "pauseAutoPlayOnHover" : <?php echo $pause_hover; ?>,
              "prevNextButtons": <?php echo $is_arrows; ?>,
              "contain" : true,
              "adaptiveHeight" : <?php echo $auto_height;?>,
              "dragThreshold" : <?php echo $threshold ;?>,
              "percentPosition": true,
              "pageDots": <?php echo $is_bullets; ?>,
              "rightToLeft": <?php echo $rtl; ?>,
              "draggable": <?php echo $draggable; ?>,
              "selectedAttraction": <?php echo $selectedattraction; ?>,
              "parallax" : <?php echo $parallax; ?>,
              "friction": <?php echo $friction; ?>
          }'
            >
          <?php echo do_shortcode($content); ?>
      </div>
       <div class="loading-spin dark large centered"></div>
  </div><!-- .ux-slider-wrapper -->
   
  <?php
      $content = ob_get_contents();
      ob_end_clean();
      return $content;
  }
  add_shortcode('slider_thumnail', 'slider_thumnail');
  
/*
 * Code bài viết liên quan theo chuyên mục
*/
function bvlq_danh_muc() {
    $output = '';
    if (is_single()) {
      global $post;
      $categories = get_the_category($post->ID);
      if ($categories) {
        $category_ids = array();
        foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
        $args=array(
          'category__in' => $category_ids,
          'post__not_in' => array($post->ID),
          'posts_per_page'=>3,
          'caller_get_posts'=>1
        );
        
        $my_query = new wp_query( $args );
        if( $my_query->have_posts() ):
            $output .= '<div class="relatedcat">';
                $output .= '<p>Có thể bạn quan tâm:</p><div class="row related-post">';
                    while ($my_query->have_posts()):$my_query->the_post();
                    $output .= 
                        '<div class="col large-4">
                            <a href="'.get_the_permalink().'" title="'.get_the_title().'">
                                <div class="feature">
                                    <div class="image" style="background-image:url('. get_the_post_thumbnail_url() .');"></div>
                                </div>                            
                            </a>
                            <div class="related-title"><a href="'.get_the_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></div>
                        </div>';
                    endwhile;
                $output .= '</div>';
            $output .= '</div>';
        endif;   //End if.
      wp_reset_query();
    }
    return $output;
  }
}
add_shortcode('bvlq_danh_muc','bvlq_danh_muc');

//tach tab chi tiet product
if ( ! function_exists( 'woocommerce_output_product_data_tabs' ) ) {
    function woocommerce_output_product_data_tabs() {
       wc_get_template( 'single-product/tabs/tabs.php' );
    }
 }
 function woocommerce_output_product_data_tabs() {
    $product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
    if ( empty( $product_tabs ) ) return;
    echo '<div class="woocommerce-tabs wc-tabs-wrapper">';
    foreach ( $product_tabs as $key => $product_tab ) {
       ?>
          <div id="tab-<?php echo esc_attr( $key ); ?>">
             <?php
             if ( isset( $product_tab['callback'] ) ) {
                call_user_func( $product_tab['callback'], $key, $product_tab );
             }
             ?>
          </div>
       <?php         
    }
    echo '</div>';
 }
 //doc gia trong phan product
 function gia_num_forvietnamese( $num = false ) {
    $str = '';
    $num  = trim($num);
    
    $arr = str_split($num);
    $count = count( $arr );
    

    $f = number_format($num);
       //KHÔNG ĐỌC BẤT KÌ SỐ NÀO NHỎ DƯỚI 999 ngàn
    if ( $count < 7 ) {
        $str = $num;
    } else {
        // từ 6 số trở lên là triệu, ta sẽ đọc nó !
        // "32,000,000,000"
        $r = explode(',', $f);
        switch ( count ( $r ) ) {
            case 4:
                $str = $r[0] . ' tỉ';
                if ( (int) $r[1] ) { $str .= ' '. $r[1] . ' triệu'; }
            break;
            case 3:
                $str = $r[0] . ' Triệu';
                if ( (int) $r[1] ) { $str .= ' '. $r[1] . 'nghìn'; }
            break;
        }
    }
    return ( $str . ' ' );
}

function Gia_goc() {
    global $product;
    if( $product->is_on_sale() ) {
        return $product->get_regular_price();
    }else{
        return $product->get_regular_price();
    }
   
}
 /* Hiển thị giá bán*/
function giaban(){
	echo '<div class="gia-ban">';
	if( get_field('re_price') ){
		echo '<div class="left">';
		echo '<span>';
		echo the_field('re_price');
		echo '</span>';
		echo '</div>';
	}else{
        echo '<div class="left">';
        echo '<span>';
        echo gia_num_forvietnamese(gia_goc());
        echo '</span>';
        echo '</div>';
    }
	if( get_field('thoi_gian_giao_nha') ){
		echo '<div class="right">';
		echo 'Giao nhà : <span>';
		echo the_field('thoi_gian_giao_nha');
		echo '</span>';
		echo '</div>';
	}
	echo '</div>';
}					
add_action('flatsome_product_box_after','giaban');
/* End Hiển thị giá bán*/


/**code đếm lượt xem bài viết */
function gt_get_post_view() {
    $count = get_post_meta( get_the_ID(), 'post_views_count', true );
	return "🗣 <span class='meta_info_post'>Bài viết đăng bởi <a class='highlight_info' href='".get_author_posts_url(get_the_author_meta('ID'))."' >".get_the_author_meta('display_name')."</a> vào lúc <span class='highlight_info'>" . get_post_time( 'd-m-Y' ) . "</span> và cập nhật lúc <span class='highlight_info'>".get_post_modified_time( 'd-m-Y' )."</span> 👁 <span class='highlight_info'>$count lượt xem</span></span>";
}
function gt_set_post_view() {
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta( $post_id, $key, true );
    $count++;
    update_post_meta( $post_id, $key, $count );
}
function gt_posts_column_views( $columns ) {
    $columns['post_views'] = 'Views';
    return $columns;
}
function gt_posts_custom_column_views( $column ) {
    if ( $column === 'post_views') {
        echo gt_get_post_view();
    }
}
add_filter( 'manage_posts_columns', 'gt_posts_column_views' );
add_action( 'manage_posts_custom_column', 'gt_posts_custom_column_views' );
/**end code đếm lượt xem */

//xy ly item breadcrumb
add_action('bcn_after_fill', 'bcnext_remove_current_item');
 
function bcnext_remove_current_item($trail)
{
    //Make sure we have a type
    if(isset($trail->breadcrumbs[0]->type) && is_array($trail->breadcrumbs[0]->type) && isset($trail->breadcrumbs[0]->type[1]) && is_singular('post'))
    {
        //Check if we have a current item
        if(in_array('current-item', $trail->breadcrumbs[0]->type))
        {
            //Shift the current item off the front
            array_shift($trail->breadcrumbs);
        }
    }
}
/*
* Hiển thị Mô tả ngắn cho Danh mục Bài viết Flatsome 
* Chia sẻ bởi https://realdev.vn/
*/
function realdev_fl_archive_description()
{
    if (is_category() || is_tax()) {
        $term_id = get_queried_object_id();
        $content = get_term_meta($term_id, 'realdev_term_description', true);
        if (!empty($content)) {
            echo '<div class="row category-description"><div class="large-12 col"><div class="col-inner"><div class="taxonomy-full-description">' . apply_filters('the_content', $content) . '</div></div></div></div>';
        }
    }
}
add_action('flatsome_after_blog', 'realdev_fl_archive_description');
// chuyen mo ta danh muc san pham xuong duoi cung trong woocommerce webantam.com
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_taxonomy_archive_description', 100 );
// chuyen mo ta danh muc san pham xuong duoi cung trong woocommerce webantam.com end

//Hàm chèn tự động liên kết thẻ tag vào nội dung bài viết dựa vào từ khóa các thẻ tag
function auto_link_tags($content){
    $post_tags = get_the_tags();
    if ($post_tags) {
        $i = 0;
        foreach($post_tags as $tag) {
          $tags[$i] = "~<(?:a\\s.*?|[^>]+>)(*SKIP)(*FAIL)|\\b(?:\\b(" . $tag->name . ")\\b(?=[^>]*(<|$)))\\b~i"; $tag_url = get_tag_link($tag->term_id);
          $tag_html[$i] = '$1';
          $i++;
        }
        $content = preg_replace($tags, $tag_html, $content,1);
    }
    return $content;
  }
  //móc hàm vào hooks the_content
  add_filter('the_content', 'auto_link_tags');
