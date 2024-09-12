<?php

class Elementor_Banner_Slider_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'chintu_banner_slider';
    }

    public function get_title() {
        return esc_html__( 'Chintu Banner Slider', 'elementor-addon' );
    }

    public function get_icon() {
        return 'eicon-slider-album';
    }

    public function get_categories() {
        return ['basic'];
    }

    protected function _register_controls() {
        // Content section for the slider items
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Slider Content', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Repeater for multiple slides
        $repeater = new \Elementor\Repeater();

        // Slide background image
        $repeater->add_control(
            'background_image',
            [
                'label'   => esc_html__( 'Background Image', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Slide title
        $repeater->add_control(
            'title',
            [
                'label'   => esc_html__( 'Title', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Slide Title', 'elementor-addon' ),
            ]
        );

        // Button repeater for multiple buttons inside each slide
        $button_repeater = new \Elementor\Repeater();

        // Button text
        $button_repeater->add_control(
            'button_text',
            [
                'label'   => esc_html__( 'Button Text', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Click Here', 'elementor-addon' ),
            ]
        );

        // Button link
        $button_repeater->add_control(
            'button_link',
            [
                'label'       => esc_html__( 'Button Link', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'elementor-addon' ),
                'default'     => [
                    'url' => '#',
                ],
            ]
        );

        // Add button repeater control to each slide (this will not create new slides)
        $repeater->add_control(
            'buttons',
            [
                'label'       => esc_html__( 'Buttons', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $button_repeater->get_controls(),
                'default'     => [],
                'title_field' => '{{{ button_text }}}', // Shows button text in the Elementor editor
            ]
        );

        // Add the repeater control for slides
        $this->add_control(
            'slides',
            [
                'label'       => esc_html__( 'Slides', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ title }}}', // Displays the title of each slide
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $unique_id = 'chintu-banner-slider-' . $this->get_id(); // Unique ID for each widget instance

        if ( !empty( $settings['slides'] ) ) {
            echo '<div id="' . esc_attr( $unique_id ) . '" class="swiper-container chintu-banner-slider">';
            echo '<div class="swiper-wrapper">';

            // Loop through each slide
            foreach ( $settings['slides'] as $slide ) {
                echo '<div class="swiper-slide" style="background-image: url(' . esc_url( $slide['background_image']['url'] ) . ');">';
                echo '<div class="chintu-banner-text">' . esc_html( $slide['title'] ) . '</div>';

                // Loop through buttons within the current slide
                if ( !empty( $slide['buttons'] ) ) {
                    echo '<div class="chintu-banner-buttons">';
                    foreach ( $slide['buttons'] as $button ) {
                        echo '<a href="' . esc_url( $button['button_link']['url'] ) . '" class="chintu-banner-button">' . esc_html( $button['button_text'] ) . '</a>';
                    }
                    echo '</div>';
                }

                echo '</div>'; // .swiper-slide
            }

            echo '</div>'; // .swiper-wrapper

            // Navigation arrows
            echo '<div class="swiper-button-next"></div>';
            echo '<div class="swiper-button-prev"></div>';

            // Pagination
            echo '<div class="swiper-pagination"></div>';

            echo '</div>'; // .swiper-container

            // Swiper initialization script
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    new Swiper("#' . esc_js( $unique_id ) . '", {
                        spaceBetween: 30,
                        effect: "fade",
                        loop: true,
                        navigation: {
                            nextEl: "#' . esc_js( $unique_id ) . ' .swiper-button-next",
                            prevEl: "#' . esc_js( $unique_id ) . ' .swiper-button-prev",
                        },
                        pagination: {
                            el: "#' . esc_js( $unique_id ) . ' .swiper-pagination",
                            clickable: true,
                        },
                    });
                });
            </script>';
        }
    }

    // Enqueue Swiper JS and CSS
    public function get_script_depends() {
        return ['swiper-js'];
    }

    public function get_style_depends() {
        return ['swiper-css'];
    }
}