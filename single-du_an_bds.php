<?php

/**

 * Template Name: Single Dự án BĐS (Slider PHP Trực Tiếp)

 * Template Post Type: du_an_bds

 *

 * Hiển thị chi tiết dự án với slider full-width ở đầu trang, code PHP trực tiếp.

 * Bố cục: Slider -> Title -> Breadcrumbs -> Thông tin -> Mô tả -> Form -> Comments

 * * @package          Flatsome\Templates
 * @flatsome-version 3.16.0

 * @package flatsome-child

 */



get_header(); ?>



<?php // KHÔNG dùng do_action('flatsome_title_breadcrumbs'); ?>



<div class="page-wrapper single-project-page single-du_an_bds-layout-direct-php"> <?php // Class mới để CSS nếu cần ?>

    <div id="content" class="col large-12" role="main"> <?php // Content full cột ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <?php // ========================================================================= ?>

                <?php // **** PHẦN 1: SLIDER FLICKITY CHÍNH + THUMBNAIL NAV + LIGHTBOX **** ?>

                <?php // ========================================================================= ?>

                <?php

                $images = get_field('hinh_anh_du_an'); // !!! THAY TÊN FIELD GALLERY CỦA BẠN !!!

                $image_size_main = 'medium_large'; // Kích thước ảnh hiển thị trong slider chính

                $image_size_thumb = 'thumbnail'; // Kích thước ảnh hiển thị trong slider thumbnail

                $lightbox_size = 'full'; // Kích thước ảnh cho lightbox



                // Lấy ảnh đại diện làm fallback nếu không có gallery ACF

                $fallback_image = null;

                if ( empty( $images ) || ! is_array( $images ) ) {

                    if ( has_post_thumbnail() ) {

                        $fallback_image_id = get_post_thumbnail_id();

                        $fallback_image = array(

                            'ID'      => $fallback_image_id,

                            'url'     => wp_get_attachment_url( $fallback_image_id ),

                            'title'   => get_the_title(),

                            'alt'     => get_post_meta( $fallback_image_id, '_wp_attachment_image_alt', true ),

                            'caption' => '', // Mặc định không có caption cho ảnh đại diện

                            'sizes'   => array( // Cần tạo mảng sizes giả nếu ảnh đại diện không có sẵn các sizes này trong ACF

                                $image_size_main  => wp_get_attachment_image_url( $fallback_image_id, $image_size_main ),

                                $image_size_thumb => wp_get_attachment_image_url( $fallback_image_id, $image_size_thumb ),

                                $lightbox_size    => wp_get_attachment_image_url( $fallback_image_id, $lightbox_size ),

                            )

                        );

                        // Sử dụng ảnh đại diện làm mảng images để vòng lặp hoạt động

                        $images = array($fallback_image);

                    } else {

                         // Nếu không có cả gallery và ảnh đại diện, không hiển thị gì

                         $images = false; // Đảm bảo biến images là false/empty array

                    }

                }





                if( $images && !empty($images) ):

                    $gallery_id = 'project-gallery-' . get_the_ID();

                    $slider_id_main = 'project-slider-main-' . get_the_ID();

                    $slider_id_nav = 'project-slider-nav-' . get_the_ID();

                ?>

                    <div class="project-main-slider-container alignfull mb-0 relative"> <?php // Container chung cho cả hai slider ?>



                         <?php // --- Slider Chính --- ?>

                        <div id="<?php echo esc_attr($slider_id_main); ?>" class="project-slider-main slider-container relative lightbox" <?php // *** Thêm class 'lightbox' vào container chính *** ?>

                             data-lightbox-gallery="<?php echo esc_attr($gallery_id); ?>"

                             data-lightbox-image-selector=".slide-link"> <?php // *** Chỉ định selector cho link kích hoạt lightbox *** ?>



                            <div class="slider slider-nav-circle slider-nav-large slider-nav-light slider-style-normal slider-show-on-init"

                                 data-flickity-options='{

                                                            "cellAlign": "left", "contain": true, "wrapAround": true,

                                                            "autoPlay": 5000, <?php // Đặt thời gian tự động chuyển slide (ví dụ 5000ms = 5 giây) ?>

                                                            "prevNextButtons": true, "percentPosition": true, "imagesLoaded": false,

                                                            "pageDots": false, "adaptiveHeight": false, "rightToLeft": false,

                                                            "selectedAttraction": 0.02, "friction": 0.3,

                                                            "lazyLoad": 1, "imagesLoaded": false

                                                        }'

                                 >

                                <?php foreach( $images as $image ): ?>

                                    <?php

                                        $image_id = $image['ID'];

                                        $image_src_data = wp_get_attachment_image_src( $image_id, $image_size_main );

                                        $image_display_url = $image_src_data ? $image_src_data[0] : $image['url'];

                                        $image_width = $image_src_data ? $image_src_data[1] : $image['width'];

                                        $image_height = $image_src_data ? $image_src_data[2] : $image['height'];

                                        $image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size_main );

                                        $image_sizes = '100vw';



                                        // Lấy URL ảnh gốc cho lightbox

                                        $image_full_url = wp_get_attachment_image_url( $image_id, $lightbox_size );

                                        if (!$image_full_url) $image_full_url = $image['url'];



                                        $image_caption = !empty($image['caption']) ? $image['caption'] : $image['title'];

                                        $image_alt = !empty($image['alt']) ? $image['alt'] : $image['title'];

                                    ?>

                                    <div class="img-item ux-slide">

                                        <div class="slide-wrapper">

                                             <?php // Link này sẽ kích hoạt lightbox ?>

                                             <a href="<?php echo esc_url($image_full_url); ?>"

                                                title="<?php echo esc_attr($image_caption); ?>"

                                                class="slide-link" <?php // Class để lightbox selector nhận dạng ?>

                                                >

                                                <img

                                                    data-flickity-lazyload-srcset="<?php echo esc_attr( $image_srcset ); ?>"

                                                    data-flickity-lazyload-src="<?php echo esc_url( $image_display_url ); ?>"

                                                    sizes="<?php echo esc_attr( $image_sizes ); ?>"

                                                    width="<?php echo esc_attr( $image_width ); ?>"

                                                    height="<?php echo esc_attr( $image_height ); ?>"

                                                    alt="<?php echo esc_attr( $image_alt ); ?>"

                                                    />

                                             </a>

                                            <?php // Caption trên ảnh (tùy chọn) ?>

                                             <?php if(!empty($image['caption'])): ?>

                                                <div class="caption absolute-bottom dark text-center op-8 pd-x-small fs-medium">

                                                    <?php echo esc_html($image['caption']); ?>

                                                </div>

                                             <?php endif; ?>

                                        </div> <?php // end .slide-wrapper ?>

                                    </div> <?php // end .img-item ?>

                                <?php endforeach; ?>

                            </div> <?php // end .slider ?>

                        </div> <?php // end .project-slider-main ?>



                        <?php // --- Slider Thumbnail Nav --- ?>

                        <div id="<?php echo esc_attr($slider_id_nav); ?>" class="project-slider-nav slider-container relative"

                             data-flickity-options='{

                                 "asNavFor": "#<?php echo esc_attr($slider_id_main); ?> .slider", <?php // *** Liên kết với slider chính *** ?>

                                 "contain": true, "wrapAround": false, <?php // Nav thường không wrapAround ?>

                                 "prevNextButtons": false, <?php // Nav thường không có nút prev/next riêng ?>

                                 "pageDots": false, <?php // Nav không có chấm tròn ?>

                                 "cellAlign": "left",

                                 "imagesLoaded": true,

                                 "lazyLoad": 1,

                                 "percentPosition": true,

                                 "groupCells": true, <?php // Group cells để cuộn cả nhóm ?>

                                 "dragThreshold": 5 <?php // Ngưỡng kéo thấp để dễ cuộn bằng tay ?>

                             }'

                             >

                            <div class="slider" <?php // Không cần nhiều class style cho nav slider ?>>

                                <?php foreach( $images as $image ): ?>

                                    <?php

                                        $image_id = $image['ID'];

                                        $image_src_data = wp_get_attachment_image_src( $image_id, $image_size_thumb );

                                        $image_display_url = $image_src_data ? $image_src_data[0] : $image['url'];

                                        $image_width = $image_src_data ? $image_src_data[1] : ''; // Thumb ít cần width/height

                                        $image_height = $image_src_data ? $image_src_data[2] : '';

                                        $image_alt = !empty($image['alt']) ? $image['alt'] : $image['title'];

                                    ?>

                                    <div class="is-nav-selected-bg nav-slide" <?php // Class của Flatsome cho nav slide ?>>

                                         <div class="nav-slide-inner">

                                            <img

                                                data-flickity-lazyload="<?php echo esc_url( $image_display_url ); ?>"

                                                width="<?php echo esc_attr( $image_width ); ?>"

                                                height="<?php echo esc_attr( $image_height ); ?>"

                                                alt="<?php echo esc_attr( $image_alt ); ?>"

                                                />

                                         </div>

                                    </div> <?php // end .nav-slide ?>

                                <?php endforeach; ?>

                            </div> <?php // end .slider ?>

                             <?php // Tùy chọn: Nút Prev/Next cho nav nếu muốn ?>

                            <?php /* <div class="flickity-button flickity-prev"></div> <div class="flickity-button flickity-next"></div> */ ?>

                        </div> <?php // end .project-slider-nav ?>



                    </div> <?php // end .project-main-slider-container ?>



                <?php else : // Không có ảnh đại diện hoặc gallery ?>

                    <?php // Hiển thị placeholder hoặc không làm gì cả ?>

                    <div class="project-main-slider-container alignfull mb-0 relative" style="min-height: 400px; background-color: #f0f0f0; display: flex; align-items: center; justify-content: center;">

                        <p style="color: #aaa; font-style: italic;">Hình ảnh đang cập nhật</p>

                    </div>

                <?php endif; ?>

                <?php // ========================================================================= ?>

                <?php // **** KẾT THÚC PHẦN 1: SLIDER **** ?>



                <?php // ... (Các phần còn lại của trang single giữ nguyên) ... ?>



                <?php // ========================================================================= ?>

                <?php // **** CONTAINER CHÍNH CHO NỘI DUNG (Giới hạn chiều rộng) **** ?>

                <?php // ========================================================================= ?>

                <div class="project-content-main container mt">



                    <?php // **** PHẦN 2: TIÊU ĐỀ **** ?>

                    <header class="entry-header project-header-container mb">

                        <?php the_title( '<h1 class="entry-title project-title text-center">', '</h1>' ); ?>

                        <?php // Nút Sửa/Xóa ?>

                        <div class="project-actions text-center mt-half">

                             <?php

                                $project_id_to_edit = get_the_ID();

                                $current_user_id = get_current_user_id();

                                $post_author_id = get_post_field( 'post_author', $project_id_to_edit );

                                // (Code PHP cho nút Sửa/Xóa giữ nguyên như file hoàn chỉnh trước)

                                if ( is_user_logged_in() && ( $post_author_id == $current_user_id || current_user_can('edit_others_posts') ) ) { $edit_url = add_query_arg( 'project_id', $project_id_to_edit, home_url('/sua-du-an/') ); echo '<a href="'.esc_url( $edit_url ).'" class="button secondary is-outline is-small" style="margin-right: 10px;">Sửa dự án</a>';} if ( is_user_logged_in() && ( $post_author_id == $current_user_id || current_user_can('delete_others_posts') ) ) {$delete_nonce = wp_create_nonce( 'bds_delete_project_nonce_' . $project_id_to_edit ); $delete_url = add_query_arg( array( 'action' => 'bds_delete_project', 'project_id' => $project_id_to_edit, '_wpnonce' => $delete_nonce ), get_post_type_archive_link('du_an_bds') ); echo '<a href="'.esc_url( $delete_url ).'" onclick="return confirm(\'Bạn chắc chắn muốn xóa dự án này?\');" class="button alert is-outline is-small">Xóa dự án</a>';}

                            ?>

                        </div>

                    </header><!-- .entry-header -->



                     <?php // **** PHẦN 3: BREADCRUMBS **** ?>

                     <div class="breadcrumbs-container mb">

                         <?php

                            // (Code PHP gọi breadcrumbs giữ nguyên như file hoàn chỉnh trước)

                            if (function_exists('flatsome_breadcrumb')) { flatsome_breadcrumb();} elseif (function_exists('yoast_breadcrumb')) { yoast_breadcrumb('<p id="breadcrumbs">','</p>');} elseif (function_exists('rank_math_the_breadcrumbs')) { rank_math_the_breadcrumbs();}

                         ?>

                     </div>



                     <?php // **** PHẦN 4: THÔNG TIN BDS CHÍNH **** ?>

 <section class="project-key-info widget mb">

    <!--<h3 class="widget-title section-title">Thông tin tổng quan</h3> 

     <div class="is-divider small"></div>-->

     <ul class="project-meta no-bullet">

         <?php

             // Loại BĐS (Dùng hàm WP chuẩn hoặc shortcode [bds_terms] vẫn ổn)

             echo get_the_term_list( $post->ID, 'loai_bds', '<li class="meta-item meta-loai"><strong>Loại BĐS:</strong> ', ', ', '</li>' );



             // Giá (Lấy giá trị rồi tự bọc HTML)

             $gia_value = do_shortcode('[bds_field name="gia_bds"]'); // Chỉ lấy giá trị

             if ( !empty($gia_value) ) {

                 echo '<li class="meta-item meta-gia"><strong>Mức giá:</strong> <span class="price">' . esc_html($gia_value) . '</span></li>';

             }



             // Diện tích

             $dien_tich_value = do_shortcode('[bds_field name="dien_tich_bds"]');

             if ( !empty($dien_tich_value) ) {

                  echo '<li class="meta-item meta-dientich"><strong>Diện tích:</strong> ' . esc_html($dien_tich_value) . ' m²</li>';

             }



             // Phòng ngủ

             $phong_ngu_value = do_shortcode('[bds_field name="so_phong_ngu_bds"]');

             if ( !empty($phong_ngu_value) ) {

                  echo '<li class="meta-item meta-phongngu"><strong>Phòng ngủ:</strong> ' . esc_html($phong_ngu_value) . '</li>';

             }



             // Phòng tắm

             $phong_tam_value = do_shortcode('[bds_field name="so_phong_tam_bds"]');

              if ( !empty($phong_tam_value) ) {

                  echo '<li class="meta-item meta-phongtam"><strong>Phòng tắm:</strong> ' . esc_html($phong_tam_value) . '</li>';

             }



             // Vị trí (Kết hợp taxonomy và ACF field)

             $dia_chi = get_field('dia_chi_chi_tiet_bds'); // !!! THAY FIELD NAME !!!

             $khu_vuc_html = get_the_term_list( $post->ID, 'khu_vuc', '', ', ', '' );

             if (!empty($khu_vuc_html) || !empty($dia_chi)) { // Chỉ hiển thị li nếu có ít nhất 1 thông tin

                echo '<li class="meta-item meta-vitri"><strong>Vị trí:</strong> ';

                if (!empty($khu_vuc_html)) echo $khu_vuc_html;

                if (!empty($khu_vuc_html) && $dia_chi) echo ' - ';

                if ($dia_chi) echo esc_html($dia_chi);

                echo '</li>';

             }





             // Hướng nhà (Dùng hàm WP chuẩn hoặc shortcode [bds_terms] vẫn ổn)

             echo get_the_term_list( $post->ID, 'huong_nha', '<li class="meta-item meta-huong"><strong>Hướng nhà:</strong> ', ', ', '</li>' );



             // Pháp lý (Dùng hàm WP chuẩn hoặc shortcode [bds_terms] vẫn ổn)

             echo get_the_term_list( $post->ID, 'phap_ly', '<li class="meta-item meta-phaply"><strong>Pháp lý:</strong> ', ', ', '</li>' );



             // Mặt tiền

             $mat_tien_value = do_shortcode('[bds_field name="mat_tien_bds"]');

             if ( !empty($mat_tien_value) ) {

                echo '<li class="meta-item meta-mattien"><strong>Mặt tiền:</strong> ' . esc_html($mat_tien_value) . ' m</li>';

             }

         ?>

     </ul>

 </section>



                    <?php // **** PHẦN 5: MÔ TẢ CHI TIẾT **** ?>

                    <section class="entry-content project-main-description mb">

                         <div class="is-divider small"></div>

                         <?php the_content(); // Nội dung từ trình soạn thảo WordPress ?>



                         <?php // Hiển thị Video/Map (Code PHP trực tiếp) ?>

                         <?php

                            $video_url = get_field('video_du_an'); // !!! THAY FIELD NAME !!!

                            if($video_url):

                         ?>

                            <div class="project-video mt"> <h4 class="section-title">Video Dự án</h4> <div class="is-divider small"></div> <div class="video-responsive"><?php echo wp_oembed_get($video_url); ?></div> </div>

                         <?php endif; ?>

                         <?php

                            $location = get_field('ban_do_du_an'); // !!! THAY FIELD NAME !!!

                            if( $location ):

                         ?>

                            <div class="project-map mt"> <h4 class="section-title">Vị trí trên bản đồ</h4> <div class="is-divider small"></div> <div class="acf-map" style="height: 400px; border: 1px solid #ccc;"><div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div></div> <?php if(!empty($location['address'])): ?><p class="fs-small mt-half"><strong>Địa chỉ map:</strong> <?php echo esc_html($location['address']); ?></p><?php endif; ?> </div>

                         <?php endif; ?>



                    </section>



                    <?php // **** PHẦN 6: FORM LIÊN HỆ **** ?>

                    <section class="project-contact-form widget mb">

                        <h3 class="widget-title section-title" style="color:red; font-weight: 600;">ĐĂNG KÝ NHẬN BÁO GIÁ CHI TIẾT VÀ PHÁP LÝ DỰ ÁN</h3>

                        <div class="is-divider small"></div>

                        <?php echo do_shortcode('[wpforms id="17551"]'); // !!! THAY ID FORM CỦA BẠN !!! ?>

                    </section>

                    <?php

                            // --- Hiển thị Thẻ Dự án ---

                            $project_tags = get_the_term_list( get_the_ID(), 'the_du_an', '', ', ', '' ); // Lấy danh sách thẻ có link

                            if ( $project_tags && ! is_wp_error( $project_tags ) ) :

                            ?>

                                <div class="project-tags-container tags-container mt mb"> <?php // Thêm class để CSS ?>

                                    <span class="tags-label"><strong><i class="icon-tag"></i> Thẻ:</strong></span>

                                    <?php echo $project_tags; ?>

                                </div>

                            <?php endif; ?>

                            <?php // --- Kết thúc hiển thị thẻ --- ?>

                </div> <?php // end .project-content-main.container ?>

                <?php // **** KẾT THÚC CONTAINER NỘI DUNG CHÍNH **** ?>





                <?php // ========================================================================= ?>

                <?php // **** PHẦN 7: BÌNH LUẬN **** ?>

                <?php // ========================================================================= ?>

                <section class="project-comments container">

                    <?php

                    if ( comments_open() || get_comments_number() ) :

                        comments_template();

                    endif;

                    ?>

                </section>

                <?php // **** KẾT THÚC PHẦN 7: BÌNH LUẬN **** ?>



            </article><!-- #post-## -->

        <?php endwhile; // Kết thúc vòng lặp WordPress. ?>

    </div><!-- #content .col -->

</div><!-- .page-wrapper -->



<?php

// QUAN TRỌNG: Nếu bạn đã thêm đoạn JavaScript setTimeout để resize/reposition Flickity ở bước trước,

// HÃY XÓA HOẶC COMMENT OUT NÓ ĐI. Nó không còn cần thiết và có thể gây lỗi với cách này.

?>



<?php get_footer(); ?>