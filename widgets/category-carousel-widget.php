<?php
class Elementor_Category_Carousel_Widget extends \Elementor\Widget_Base {

    // Widget name
    public function get_name() {
        return 'category_carousel';
    }

    // Widget title
    public function get_title() {
        return esc_html__( 'Category Post Carousel', 'chintu' );
    }

    // Widget icon
    public function get_icon() {
        return 'eicon-post-list';
    }

    // Widget categories
    public function get_categories() {
        return ['general'];
    }

    // Widget controls
    protected function register_controls() {
        // Content section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'chintu' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Select category control
        $this->add_control(
            'post_category',
            [
                'label'   => esc_html__( 'Post Category', 'chintu' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_post_categories(),
                'default' => 'uncategorized',
            ]
        );

        // Number of posts
        $this->add_control(
            'post_count',
            [
                'label'   => esc_html__( 'Number of Posts', 'chintu' ),
                'type'    => \Elementor\Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        // See More Text Control
        $this->add_control(
            'see_more_text',
            [
                'label'   => esc_html__( 'See More Text', 'chintu' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'See More', 'chintu' ),
                'placeholder' => esc_html__( 'Type your custom text', 'chintu' ),
            ]
        );

        $this->end_controls_section();
    }

    // Get available post categories
    private function get_post_categories() {
        $categories = get_categories();
        $options = [];
        foreach ( $categories as $category ) {
            $options[$category->slug] = $category->name;
        }
        return $options;
    }

    // Render widget output
    protected function render() {
        $settings = $this->get_settings_for_display();
        $category = $settings['post_category'];
        $post_count = $settings['post_count'];
        $see_more_text = $settings['see_more_text']; // Get custom See More text

        // Unique ID for the widget instance
        $widget_id = $this->get_id();

        $args = [
            'category_name'  => $category,
            'posts_per_page' => $post_count,
        ];

        $query = new WP_Query( $args );

        if ( $query->have_posts() ) {
            ?>
            <div class="chintu-carousel-container" id="carousel-container-<?php echo esc_attr( $widget_id ); ?>">
                <div class="chintu-header">
                    <h2><a href="<?php echo get_category_link( get_category_by_slug( $category )->term_id ); ?>">
                            <?php echo esc_html( get_cat_name( get_category_by_slug( $category )->term_id ) ); ?>
                        </a></h2>
                    <div class="chintu-header-right">
                        <a href="<?php echo get_category_link( get_category_by_slug( $category )->term_id ); ?>" class="chintu-see-more">
                            <?php echo esc_html( $see_more_text ); // Display custom See More text ?>
                        </a>
                        <div class="chintu-nav-buttons">
                            <!-- Left Arrow Icon -->
                            <button class="chintu-prev-button-<?php echo esc_attr( $widget_id ); ?>">
                                <i class="eicon-chevron-left"></i>
                            </button>
                            <!-- Right Arrow Icon -->
                            <button class="chintu-next-button-<?php echo esc_attr( $widget_id ); ?>">
                                <i class="eicon-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="swiper-container" id="swiper-container-<?php echo esc_attr( $widget_id ); ?>">
                    <div class="swiper-wrapper">
                        <?php while ( $query->have_posts() ): $query->the_post();?>
                            <div class="swiper-slide">
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>" alt="<?php the_title();?>" />
                                </a>
                                <h3><a href="<?php the_permalink(); ?>"><?php the_title();?></a></h3>
                            </div>
                        <?php endwhile;?>
                    </div>
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const swiper_<?php echo esc_js( $widget_id ); ?> = new Swiper('#swiper-container-<?php echo esc_js( $widget_id ); ?>', {
                        slidesPerView: 2,
                        slidesPerGroup: 1,
                        grid: {
                            rows: 2
                        },
                        spaceBetween: 25,
                        navigation: {
                            nextEl: '.chintu-next-button-<?php echo esc_js( $widget_id ); ?>',
                            prevEl: '.chintu-prev-button-<?php echo esc_js( $widget_id ); ?>',
                        },
                    });
                });
            </script>
            <?php
            wp_reset_postdata();
        } else {
            esc_html_e( 'No posts found', 'chintu' );
        }
    }

    // Enqueue Swiper scripts
    public function get_script_depends() {
        return ['swiper-js'];
    }

    public function get_style_depends() {
        return ['swiper-css'];
    }
}
