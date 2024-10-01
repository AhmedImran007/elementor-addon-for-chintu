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
        // Content Section for Slider Items
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Slider Content', 'elementor-addon' ),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Repeater for Multiple Slides
        $repeater = new \Elementor\Repeater();

        // Slide Background Image
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

        // Slide Title
        $repeater->add_control(
            'title',
            [
                'label'   => esc_html__( 'Title', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Slide Title', 'elementor-addon' ),
            ]
        );

        // Top Text Fields with Color and Font Size Controls
        for ($i = 1; $i <= 3; $i++) {
            // Top Text
            $repeater->add_control(
                "top_text_$i",
                [
                    'label'   => esc_html__( "Top Text $i", 'elementor-addon' ),
                    'type'    => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__( "Top Text $i", 'elementor-addon' ),
                ]
            );

            // Top Text Color Control
            $repeater->add_control(
                "top_text_{$i}_color",
                [
                    'label'     => esc_html__( "Top Text $i Color", 'elementor-addon' ),
                    'type'      => \Elementor\Controls_Manager::COLOR,
                    'selectors' => [
                        "{{WRAPPER}} .chintu-top-texts h3:nth-child($i)" => 'color: {{VALUE}};',
                    ],
                ]
            );

            // Top Text Font Size Control
            $repeater->add_control(
                "top_text_{$i}_font_size",
                [
                    'label'      => esc_html__( "Top Text $i Font Size (px)", 'elementor-addon' ),
                    'type'       => \Elementor\Controls_Manager::NUMBER,
                    'default'    => '25', // Set default font size
                    'selectors'  => [
                        "{{WRAPPER}} .chintu-top-texts h3:nth-child($i)" => 'font-size: {{VALUE}}px', // Apply font size with !important
                    ],
                ]
            );
        }

        // Button Heading Text
        $repeater->add_control(
            'button_heading_text',
            [
                'label'   => esc_html__( 'Button Heading Text', 'elementor-addon' ),
                'type'    => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__( 'Button Heading', 'elementor-addon' ),
            ]
        );

        // Button 1 (First Button)
        $this->add_button_controls($repeater, 'button_1', esc_html__( 'First Button', 'elementor-addon' ));

        // Button 2 (Second Button)
        $this->add_button_controls($repeater, 'button_2', esc_html__( 'Second Button', 'elementor-addon' ));

        // Add Repeater Control for Slides
        $this->add_control(
            'slides',
            [
                'label'       => esc_html__( 'Slides', 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ title }}}',
            ]
        );

        $this->end_controls_section();
    }

    // Add Button Controls (Reusable)
    private function add_button_controls($repeater, $button_prefix, $button_label) {
        $repeater->add_control(
            "{$button_prefix}_enabled",
            [
                'label'        => esc_html__( "Enable $button_label", 'elementor-addon' ),
                'type'         => \Elementor\Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'elementor-addon' ),
                'label_off'    => esc_html__( 'No', 'elementor-addon' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $repeater->add_control(
            "{$button_prefix}_text",
            [
                'label'     => esc_html__( "$button_label Text", 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::TEXT,
                'default'   => esc_html__( "Click Here", 'elementor-addon' ),
                'condition' => ["{$button_prefix}_enabled" => 'yes'],
            ]
        );

        $repeater->add_control(
            "{$button_prefix}_image",
            [
                'label'     => esc_html__( "$button_label Image", 'elementor-addon' ),
                'type'      => \Elementor\Controls_Manager::MEDIA,
                'condition' => ["{$button_prefix}_enabled" => 'yes'],
            ]
        );

        $repeater->add_control(
            "{$button_prefix}_link",
            [
                'label'       => esc_html__( "$button_label Link", 'elementor-addon' ),
                'type'        => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__( 'https://your-link.com', 'elementor-addon' ),
                'default'     => ['url' => '#'],
                'condition'   => ["{$button_prefix}_enabled" => 'yes'],
            ]
        );
    }

    // Render the Slider
    protected function render() {
        $settings = $this->get_settings_for_display();
        $unique_id = 'chintu-banner-slider-' . $this->get_id();

        if (!empty($settings['slides'])) {
            echo '<div id="' . esc_attr($unique_id) . '" class="swiper-container chintu-banner-slider">';
            echo '<div class="swiper-wrapper">';

            foreach ($settings['slides'] as $index => $slide) {
                $top_text_style_1 = 'font-size: ' . $slide['top_text_1_font_size'] . 'px;';
                $top_text_style_2 = 'font-size: ' . $slide['top_text_2_font_size'] . 'px;';
                $top_text_style_3 = 'font-size: ' . $slide['top_text_3_font_size'] . 'px;';

                echo '<div class="swiper-slide" style="background-image: url(' . esc_url($slide['background_image']['url']) . ');">';

                // Top Texts
                echo '<div class="chintu-top-texts">';
                echo '<h3 style="' . esc_attr($top_text_style_1) . '">' . esc_html($slide['top_text_1']) . '</h3>';
                echo '<h3 style="' . esc_attr($top_text_style_2) . '">' . esc_html($slide['top_text_2']) . '</h3>';
                echo '<h3 style="' . esc_attr($top_text_style_3) . '">' . esc_html($slide['top_text_3']) . '</h3>';
                echo '</div>';

                // Title and Button Heading
                echo '<div class="chintu-banner-text">' . esc_html($slide['title']) . '</div>';
                echo '<div class="chintu-button-heading-text"><h4>' . esc_html($slide['button_heading_text']) . '</h4></div>';

                // Buttons
                echo '<div class="chintu-banner-buttons">';
                $this->render_button($slide, 'button_1');
                $this->render_button($slide, 'button_2');
                echo '</div>';

                echo '</div>'; // .swiper-slide
            }

            echo '</div>'; // .swiper-wrapper

            // Navigation Arrows
            echo '<div class="swiper-button-next"></div>';
            echo '<div class="swiper-button-prev"></div>';

            // Pagination
            echo '<div class="swiper-pagination"></div>';

            echo '</div>'; // .swiper-container

            $this->initialize_swiper($unique_id);
        }
    }

    // Render a Slide
    private function render_slide($slide) {
        echo '<div class="swiper-slide" style="background-image: url(' . esc_url($slide['background_image']['url']) . ');">';

        // Top Texts
        echo '<div class="chintu-top-texts">';
        for ($i = 1; $i <= 3; $i++) {
            echo '<h3>' . esc_html($slide["top_text_$i"]) . '</h3>';
        }
        echo '</div>';

        // Title and Button Heading
        echo '<div class="chintu-banner-text">' . esc_html($slide['title']) . '</div>';
        echo '<div class="chintu-button-heading-text"><h4>' . esc_html($slide['button_heading_text']) . '</h4></div>';

        // Buttons
        echo '<div class="chintu-banner-buttons">';
        $this->render_button($slide, 'button_1');
        $this->render_button($slide, 'button_2');
        echo '</div>';

        echo '</div>'; // .swiper-slide
    }

    // Render a Button
    private function render_button($slide, $button_prefix) {
        if ($slide["{$button_prefix}_enabled"] === 'yes') {
            $link = esc_url($slide["{$button_prefix}_link"]['url']);
            $title = esc_attr($slide['title']);

            if (!empty($slide["{$button_prefix}_image"]['url'])) {
                $image_url = esc_url($slide["{$button_prefix}_image"]['url']);
                echo "<a href='$link'><img src='$image_url' class='chintu-button-image' alt='$title' /></a>";
            } else {
                $text = esc_html($slide["{$button_prefix}_text"]);
                echo "<a href='$link' class='chintu-banner-button'>$text</a>";
            }
        }
    }

    // Swiper Initialization Script
    private function initialize_swiper($unique_id) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                new Swiper('#$unique_id', {
                    spaceBetween: 30,
                    effect: 'fade',
                    loop: true,
                    navigation: {
                        nextEl: '#$unique_id .swiper-button-next',
                        prevEl: '#$unique_id .swiper-button-prev',
                    },
                    pagination: {
                        el: '#$unique_id .swiper-pagination',
                        clickable: true,
                    },
                });
            });
        </script>";
    }

    public function get_script_depends() {
        return ['swiper-js'];
    }

    public function get_style_depends() {
        return ['swiper-css'];
    }
}
