<?php
/**
 * Template Name: Archive Dự án BĐS (UX Blocks - Grid/List Toggle)
 *
 * Hiển thị trang lưu trữ dự án, sử dụng UX Blocks cho items
 * và cho phép chuyển đổi giữa Grid và List view.
 *
 * @package flatsome-child
 */

get_header();

// --- Lấy chế độ xem hiện tại (mặc định là grid) ---
// Ưu tiên lấy từ query param (nếu có), sau đó từ cookie hoặc localStorage (JS sẽ xử lý)
$current_view = isset($_GET['view']) && $_GET['view'] === 'list' ? 'list' : 'grid';
// Thêm class vào body để dễ dàng style toàn trang nếu cần
// add_filter('body_class', function($classes) use ($current_view) { $classes[] = 'archive-view-' . $current_view; return $classes; });

?>

<?php // do_action( 'flatsome_title_breadcrumbs' ); ?>
<?php
    if ( is_tax('loai_bds') ) { // Kiểm tra nếu đang ở trang taxonomy 'loai_bds'
        $term = get_queried_object();
        echo '<h1 class="page-title">' . esc_html( $term->name ) . '</h1>';
        // Hiển thị mô tả của term nếu có
        $description = term_description();
        if ( $description ) {
            echo '<div class="taxonomy-description">' . $description . '</div>';
        }
    } elseif ( is_post_type_archive('du_an_bds') ) { // Kiểm tra nếu đang ở trang archive chính
        echo '<h1 class="page-title">' . post_type_archive_title( '', false ) . '</h1>';
    }
    // Có thể thêm breadcrumbs ở đây nếu muốn
    // flatsome_breadcrumb();
    ?>


<div class="page-wrapper archive-du_an_bds archive-du_an_bds-toggle-view">
<div class="row">

	<?php
	$sidebar = false; // Đặt 'left' hoặc 'right' nếu muốn sidebar
	$content_class = $sidebar ? 'large-9' : 'large-12';
	?>

	<?php if($sidebar === 'left') { get_sidebar('du_an_bds'); } ?>

	<div id="content" class="col <?php echo esc_attr($content_class); ?>" role="main">
		<div class="page-inner">

			<?php if ( have_posts() ) : ?>

				<?php // --- View Switcher Buttons --- ?>
				<div class="bds-view-switcher text-right mb-half">
					<button class="button is-outline is-small bds-view-trigger <?php echo $current_view === 'grid' ? 'active' : ''; ?>" data-view="grid" aria-label="Xem dạng lưới">
						<i class="icon-menu"></i> <?php // Icon Grid của Flatsome ?>
					</button>
					<button class="button is-outline is-small bds-view-trigger <?php echo $current_view === 'list' ? 'active' : ''; ?>" data-view="list" aria-label="Xem dạng danh sách">
						<i class="icon-list"></i> <?php // Icon List của Flatsome ?>
					</button>
				</div>

			<?php
				// --- Container cho kết quả ---
				// Class ban đầu dựa trên $current_view, JS sẽ cập nhật sau
				// Thêm class grid của Flatsome nếu là grid view
				$container_classes = array('bds-archive-results-container');
				$container_classes[] = 'view-' . $current_view; // class view-grid hoặc view-list

                // Chỉ thêm class row và columns khi là grid view
                $grid_classes_string = '';
				if ($current_view === 'grid') {
                    $grid_columns = 2; // !!! Số cột Grid bạn muốn !!!
                    $grid_columns_tablet = 2;
                    $grid_columns_mobile = 1;

                    $grid_classes_array = array('row');
                    $grid_classes_array[] = 'large-columns-' . $grid_columns;
                    $grid_classes_array[] = 'medium-columns-' . $grid_columns_tablet;
                    $grid_classes_array[] = 'small-columns-' . $grid_columns_mobile;
                    $grid_classes_array[] = 'row-large';
                    $grid_classes_array[] = 'col-large';
                    $grid_classes_array[] = 'grid'; // Class cơ bản
                    $grid_classes_string = implode(' ', $grid_classes_array);
				}
			?>

			<div id="bds-archive-container" class="<?php echo esc_attr(implode(' ', $container_classes)); ?> <?php echo esc_attr($grid_classes_string); ?>">

				<?php /* Bắt đầu vòng lặp WordPress */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php // --- Wrapper cho mỗi item --- ?>
					<?php // Class 'col' chỉ cần thiết cho grid view, nhưng để đây cũng không sao ?>
					<div class="post-item col">
						<div class="col-inner"> <?php // col-inner để tương thích Flatsome ?>
							<?php
							// !!! THAY ID/SLUG CỦA UX BLOCKS BẠN ĐÃ TẠO !!!
							$grid_block_id = 'bds-grid-item-layout'; // Thay bằng ID/Slug Block Grid
							$list_block_id = 'bds-list-item-layout'; // Thay bằng ID/Slug Block List

							// Render CẢ HAI block, CSS sẽ ẩn/hiện block phù hợp
							echo '<div class="bds-item-view bds-grid-view">';
							echo do_shortcode('[block id="' . $grid_block_id . '"]');
							echo '</div>';

							echo '<div class="bds-item-view bds-list-view">';
							echo do_shortcode('[block id="' . $list_block_id . '"]');
							echo '</div>';
							?>
						</div>
					</div><!-- .post-item -->

				<?php endwhile; ?>
				<?php /* Kết thúc vòng lặp */ ?>

			</div><!-- #bds-archive-container -->

			<?php
				// --- Hiển thị Phân trang ---
				flatsome_posts_pagination();
			?>

			<?php else : ?>

				<?php get_template_part( 'template-parts/content/content', 'none' ); ?>

			<?php endif; ?>

		</div><!-- .page-inner -->
	</div><!-- #content .col -->

	<?php if($sidebar === 'right') { get_sidebar('du_an_bds'); } ?>

</div><!-- .row -->
</div><!-- .page-wrapper -->

<?php // --- JavaScript cho View Switcher --- ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	const container = $('#bds-archive-container');
	const triggers = $('.bds-view-trigger');
    const storageKey = 'bds_archive_view'; // Key để lưu vào localStorage

    // 1. Đọc trạng thái đã lưu khi tải trang
    const savedView = localStorage.getItem(storageKey);
    let currentView = '<?php echo $current_view; ?>'; // Lấy view từ PHP làm mặc định

    if (savedView && (savedView === 'grid' || savedView === 'list')) {
         currentView = savedView;
         // Cập nhật class container và trạng thái active của button nếu khác với PHP default
         if (currentView !== '<?php echo $current_view; ?>') {
             setViewState(currentView, false); // Cập nhật UI không cần lưu lại
         }
    } else {
         // Nếu chưa lưu gì, dùng default từ PHP và lưu lại
         localStorage.setItem(storageKey, currentView);
    }

    // Đặt trạng thái active ban đầu cho button
    triggers.removeClass('active');
    triggers.filter('[data-view="' + currentView + '"]').addClass('active');
    // Đặt class ban đầu cho container (an toàn hơn là dựa hoàn toàn vào PHP)
    container.removeClass('view-grid view-list').addClass('view-' + currentView);
    toggleGridClasses(currentView === 'grid'); // Thêm/xóa class grid của Flatsome


	// 2. Xử lý khi click nút chuyển view
	triggers.on('click', function(e) {
		e.preventDefault();
		const newView = $(this).data('view');

		if (newView !== currentView) {
            setViewState(newView, true); // Cập nhật UI và lưu trạng thái
            currentView = newView; // Cập nhật biến JS
		}
	});

    // Hàm để cập nhật UI và lưu trạng thái
    function setViewState(view, saveState) {
        // Cập nhật class container
        container.removeClass('view-grid view-list').addClass('view-' + view);
        toggleGridClasses(view === 'grid'); // Thêm/xóa class grid

        // Cập nhật trạng thái active của nút
        triggers.removeClass('active');
        triggers.filter('[data-view="' + view + '"]').addClass('active');

        // Lưu trạng thái vào localStorage (nếu cần)
        if (saveState) {
            localStorage.setItem(storageKey, view);
        }

        // Tùy chọn: Trigger một sự kiện resize để các thư viện khác (nếu có) cập nhật layout
         $(window).trigger('resize');
         // Hoặc nếu dùng Masonry/Isotope thì gọi lệnh relayout
         // if (container.data('isotope')) { container.isotope('layout'); }
    }

    // Hàm thêm/xóa class grid của Flatsome
    function toggleGridClasses(isGridView) {
         const gridClassesToAdd = '<?php
             // Lấy lại các class grid từ PHP để đảm bảo nhất quán
             $grid_columns = 2; // !!! Đồng bộ với PHP ở trên !!!
             $grid_columns_tablet = 2;
             $grid_columns_mobile = 1;
             $grid_classes_array = array('row');
             $grid_classes_array[] = 'large-columns-' . $grid_columns;
             $grid_classes_array[] = 'medium-columns-' . $grid_columns_tablet;
             $grid_classes_array[] = 'small-columns-' . $grid_columns_mobile;
             $grid_classes_array[] = 'row-large';
             $grid_classes_array[] = 'col-large';
             $grid_classes_array[] = 'grid';
             echo implode(' ', $grid_classes_array);
         ?>';

         if (isGridView) {
             container.addClass(gridClassesToAdd);
         } else {
              // Lấy danh sách class cần xóa bằng cách tách chuỗi
              const classesToRemove = gridClassesToAdd.split(' ');
              classesToRemove.forEach(cls => {
                  if (cls) container.removeClass(cls);
              });
         }
    }

});
</script>

<?php get_footer(); ?>