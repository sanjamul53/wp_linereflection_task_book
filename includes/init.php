<?php

namespace BK5\Inc;

class Init
{

    use Traits\Singleton;

    public string $cpt_name = 'bk5_book';
    private string $cpt_metabox = 'bk5_book_gallery_mbox';
    private string $gallery_mata = 'bk5_book_gallery';
    public string $cpt_tax = 'book_category';

    private function __construct()
    {

        $this->define_ajax();

        add_filter('template_include', array($this, 'loadTemplate'));

        add_action('init', [$this, 'register_post_type']);

        add_action('add_meta_boxes', [$this, 'register_meta_box']);
        add_action('save_post', [$this, 'save_meta_box_data']);

        add_action('init', [$this, 'register_taxonomy'], 1);

        add_action('wp_enqueue_scripts', [$this, 'user_loadScripts']);
    }



    // ================== handle templates ==================
    public function loadTemplate($template)
    {

        if (is_page('pl_test')) {
            return  BK5_ROOTPATH . 'templates/test.php';
        }
        if (is_page('books')) {
            return  BK5_ROOTPATH . 'templates/book_ui.php';
        }

        return $template;
    }

    private function define_ajax()
    {

        add_action(
            'wp_ajax_bk5_get_books',
            array($this, 'bk5_get_books')
        );

        add_action(
            'wp_ajax_nopriv_bk5_get_books',
            array($this, 'bk5_get_books')
        );
    }

    // ================== handle script files ==================
    public function user_loadScripts()
    {

        if (is_page('books')) {

            wp_enqueue_script(
                'bk5_book_ui_script',
                Bk5_ROOTURL . 'assets/books_page.js',
                // array('wp-element')
            );

            // wp_localize_script(
            //     'bk5_book_ui_script',
            //     'php_var_list',
            //     array(
            //     // 'nonce' => wp_create_nonce('wp_rest'),
            //     'site_url' => site_url()
            //     )
            // );

            wp_enqueue_style(
                'bk5_book_ui_style',
                Bk5_ROOTURL . 'assets/books_page.css',
            );
        }
    }

    // ==================== create book post type ====================
    public function register_post_type() {

        register_post_type(
            $this->cpt_name,
            array(

                'label'               => __('Book', 'BK5'),
                'description'         => __('Books', 'BK5'),
                'labels'              => [
                    'name'               => __('Books', 'Post Type General Name', 'BK5'),
                    'singular_name'      => __('Book', 'Post Type Singular Name', 'BK5'),
                ],
                'supports'            => array(
                    'title', 'editor', 'thumbnail',
                    // 'custom-fields'
                ),
                'public'              => true,
                'show_ui'             => true,
                'show_in_menu'        => true,
                'menu_position'       => 5,
                'menu_icon'           => 'dashicons-book',
                'show_in_admin_bar'   => true,
                'show_in_nav_menus'   => true,
                'can_export'          => true,
                'has_archive'         => true,
                'capability_type'     => 'post',
                'rewrite'             => array('slug' => 'book')

            )
        );
    }


    // ==================== create meta box ====================
    public function register_meta_box() {

        add_meta_box(
            $this->cpt_metabox,
            'Gallery',
            [$this, 'meta_box_ui'],  // cb
            $this->cpt_name,                    // Post type
            'normal',                  // Context (normal, advanced, side)
            'default'                  // Priority (high, core, default, low)
        );
    }

    // public function meta_box_ui($post) {

    //     $book_gallery = get_post_meta( $post->ID, 'book_gallery', true );

    //     require_once(BK5_ROOTPATH."templates/book_cpt_gallery.php");
    // }

    public function meta_box_ui($post) {

        wp_nonce_field('bk5_metabox', 'bk5_metabox_nonce');

        $gallery_list = get_post_meta($post->ID, $this->gallery_mata, true);

        require_once(BK5_ROOTPATH . "templates/book_cpt_gallery_metabox.php");
    }

    // Save book gallery meta box data
    public function save_meta_box_data($post_id) {

        if (isset($_POST['bk5_metabox_nonce'])) {
            if (!wp_verify_nonce($_POST['bk5_metabox_nonce'], 'bk5_metabox')) {
                return null;
            }
        }
        else {
            return null;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return null;
        }

        if (isset($_POST['post_type']) && $_POST['post_type'] === $this->cpt_name) {
            if (!current_user_can('edit_page', $post_id)) {
                return null;
            } 
            else if (!current_user_can('edit_post', $post_id)) {
                return null;
            }
        }

        if (isset($_POST['action']) && $_POST['action'] == 'editpost') {

            $new_gallery_list = isset($_POST['book_gallery_idList']) ? 
            sanitize_text_field($_POST['book_gallery_idList']) : '';

            if ($new_gallery_list) {
                update_post_meta($post_id, $this->gallery_mata, $new_gallery_list);
            }
            else {
                delete_post_meta($post_id, $this->gallery_mata);
            }
        }
    }


    // register taxinomy
    public function register_taxonomy() {

        register_taxonomy($this->cpt_tax, $this->cpt_name, [
            'labels' => [
                'name'                       => 'Book Categories',
                'singular_name'              => 'Book Category',
            ],
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'rewrite'           => array('slug' => 'book_category'),
        ]);
    }



    // ================ ajax functions - upload ================
    public function bk5_get_books() {

        // try {
        // } catch (Exception $e) {
        //     wp_die(
        //         wp_json_encode(array('message' => 'Error during start process')),
        //         'Error',
        //         array('response' => 500)
        //     );
        // } finally {
        //     exit();
        // }

    }
}
