<?php

/*
 * Afficher du texte dans le pied de page - test
 */

// Hook 'wp-footer' pour placer la fonction myplugin_Footer_Add_Text() dans le footer
add_action("wp_footer", "myplugin_Footer_Add_Text");

// Texte à afficher dans le footer
function myplugin_Footer_Add_Text() {
	echo "<i>Bienvenu chez vous</i>";
}

/*
 * Ajouter un menu d'administration du plugin
 */

// Hook 'admin_menu' action pour exécuter la fonction named 'myplugin_Add_My_Admin_Link()' au chargement du menu de l'admin Wordpress
add_action( 'admin_menu', 'myplugin_Add_My_Admin_Link' );

// Ajouter un nouveau lien dans le menu de l'admin Wordpress
function myplugin_Add_My_Admin_Link()
{
  add_menu_page(
        'Plugin TOTO Page', // Titre de la page
        'Plugin TOTO', // Texte du lien dans le menu
        'manage_options', // capacité nécessaire pour accéder au lien
        'Projet-Wordpress/includes/toto-acp-page.php' // fichier à afficher quand on clique sur le lien
    );
}

/**
 * Ajouter un widget qui affiche du texte avec un titre éditable en BO
 */

class Toto_Widget extends WP_Widget {

	/**
	 * Créer le widget
	 */
	function __construct() {
		parent::__construct(
			'toto_widget', // Base ID
			esc_html__( 'Widget Toto', 'text_domain' ), // Name
			array( 'description' => esc_html__( 'Un widget du plugin Toto', 'text_domain' ), ) // Args
		);
	}

	/**
	 * Affichage en front
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		echo esc_html__( 'Lorem ipsum', 'text_domain' );
		echo $args['after_widget'];
	}

	/**
	 * Formulaire en back
	 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Nouveau titre', 'text_domain' );
		echo '<p> 
			<label for="'.esc_attr($this->get_field_id('title')).'">'.esc_attr_e('Titre:','text_domain').'</label>
			<input class="widefat" id="'.esc_attr($this->get_field_name('title')).'" name="'.esc_attr($this->get_field_name('title')).'" type="text" value="'.esc_attr($title).'">
			</p>';
	}

	/**
	 * Sauvegarde des valeurs rentrées dans le formulaire
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';

		return $instance;
	}

} 

// Hook 'widgets_init' pour charger la fonction 'register_myplugin_widget'
add_action( 'widgets_init', 'myplugin_register_widgets' );

// Déclarer le/les widget(s)
function myplugin_register_widgets() {
    register_widget( 'Toto_Widget' );
}


/*
 * Shortcodes
 */

//[toto]
add_shortcode( 'toto', 'myplugin_toto_func' );

function myplugin_toto_func( $atts ){
	return "<i>mon shortcode toto</i>";
}

// [titi att="value"]
add_shortcode( 'titi', 'myplugin_titi_func' );

function myplugin_titi_func( $atts ) {
	$a = shortcode_atts( array(
		'x' => 'un truc',
		'y' => 'puis un autre',
	), $atts );

	return "<p>x = {$a['x']} & y = {$a['y']}</p>";
}


add_shortcode( 'SEO', 'myplugin_SEO_func' );

function myplugin_SEO_func( $atts ) {

    $i = 1;

    $referencement = 0 + i;

    $voyantVert = '<div><input type="color" id="head" name="head"value="#7FDD4C"><label for="head">Head</label></div>';
    $voyantRouge = '<div><input type="color" id="head" name="head"value="#7FDD4C"><label for="head">Head</label></div>';
    $voyantOrange = '<div><input type="color" id="head" name="head"value="#7FDD4C"><label for="head">Head</label></div>';
    
    if(referencement == 1){
        return (voyantVert);
    }else if(referencement == 2){
        return (voyantOrange);
    }else if(referencement == 3){
        return (voyantRouge);
    }
}

// Les Test SEO
/*
$var = file_get_contents($file);

$valeur = $title; // nous cherchons la valeur 1

if(in_array($valeur, $tableau)){
	echo 'valeur trouvée';
} else{
	echo 'valeur non trouvée';
}*/

/*
 * Afficher du texte dans le pied de page - test
 */

 

// Plugin SEO Meta-Descirption & Titre
function tes_mb_create() {
 
    add_meta_box(
        'tes-meta', 
        'Search Engine Listing', 
        'tes_mb_function', 
        'post', 
        'normal', 
        'high'
    );
 
    add_meta_box(
        'tes-meta', 
        'Search Engine Listing', 
        'tes_mb_function', 
        'page', 
        'normal', 
        'high'
    );
}
add_action('add_meta_boxes', 'tes_mb_create');

function tes_mb_function($post) {
 

    $tes_meta_title = get_post_meta( $post->ID, '_tes_meta_title', true );
    $tes_meta_description = get_post_meta( $post->ID, '_tes_meta_description', true );
 

    wp_nonce_field( 'tes_inner_custom_box', 'tes_inner_custom_box_nonce' );
 
    echo '<div style="margin: 10px 100px; text-align: center">
    <table>
        <tr>
            <td><strong>Title Tag:</strong></td><td>
            <input style="padding: 6px 4px; width: 300px" type="text" name="tes_meta_title" value="' . esc_attr($tes_meta_title) . '" />
            </td>
        </tr>
        <tr>
            <td><strong>Meta Description:</strong></td><td>           <textarea  rows="3" cols="50" name="tes_meta_description">' . esc_attr($tes_meta_description) . '</textarea></td>
        </tr>
    </table>
</div>';
}

function tes_mb_save_data($post_id) {
 
    if ( ! isset( $_POST['tes_inner_custom_box_nonce'] ) )
        return $post_id;
 
    $nonce = $_POST['tes_inner_custom_box_nonce'];
 
    if ( ! wp_verify_nonce( $nonce, 'tes_inner_custom_box' ) )
        return $post_id;
 
    if ( defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
 
    if ( 'page' == $_POST['post_type'] ) {
 
        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;
    } else {
 
        if ( ! current_user_can( 'edit_post', $post_id ) )
            return $post_id;
    }
 

    $old_title = get_post_meta( $post_id, '_tes_meta_title', true );
    $old_description = get_post_meta( $post_id, '_tes_meta_description', true );
 

    $title = sanitize_text_field( $_POST['tes_meta_title'] );
    $description = sanitize_text_field( $_POST['tes_meta_description'] );


    update_post_meta( $post_id, '_tes_meta_title', $title, $old_title );
    update_post_meta( $post_id, '_tes_meta_description', $description, $old_description );
}
add_action( 'save_post', 'tes_mb_save_data' );

function tes_mb_display() {
 
    global $post;
     

    $tes_meta_title = get_post_meta( $post->ID, '_tes_meta_title', true );
    $tes_meta_description = get_post_meta( $post->ID, '_tes_meta_description', true );
 
    echo ' <meta property="og:title" content="' . $tes_meta_title . '" />
    <meta property="og:description" content="' . $tes_meta_description . '" />
    <meta name="description" content="' . $tes_meta_description . '" />
    ';
}
add_action( 'wp_head', 'tes_mb_display' );


// Hook 'admin_menu' action pour exécuter la fonction named 'myplugin_Add_My_Admin_Link()' au chargement du menu de l'admin Wordpress
add_action( 'admin_menu', 'myplugin_Add_My_Admin_Link_Sitemap' );

// Ajouter un nouveau lien dans le menu de l'admin Wordpress
function myplugin_Add_My_Admin_Link_Sitemap()
{
  add_menu_page(
        'Sitemap Generator', // Titre de la page
        'Sitemap Generator', // Texte du lien dans le menu
        'manage_options', // capacité nécessaire pour accéder au lien
        'Projet-Wordpress/includes/sitemap/toto-acp-page.php' // fichier à afficher quand on clique sur le lien
    );
}