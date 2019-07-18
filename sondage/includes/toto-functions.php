<?php

/*
 * Afficher du texte dans le pied de page - test
 */

// Hook 'wp-footer' pour placer la fonction myplugin_Footer_Add_Text() dans le footer
add_action("wp_footer", "myplugin_Footer_Add_Text");

// Texte à afficher dans le footer
function myplugin_Footer_Add_Text() {
	echo "<i>Mon plugin Sondage est activé!</i>";
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
        'Plugin Sondage Page', // Titre de la page
        'Plugin Sondage', // Texte du lien dans le menu
        'manage_options', // capacité nécessaire pour accéder au lien
        'sondage/includes/toto-acp-page.php' // fichier à afficher quand on clique sur le lien
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
		echo " <form method=\"post\" action=\"http://wantwant.eu/post.php\">
                    <h1>Est-ce que vous trouvez facile ce site ?</h1>
                    <select name=\"option\">
                        <option value='1'>oui</option>
                        <option value='2'>non</option>
                    </select>
                    <input type=\"submit\">
                </form>";

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