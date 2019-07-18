<?php

/*
 * Afficher du texte dans le pied de page - test
 */

// Hook 'admin_menu' action pour exécuter la fonction named 'myplugin_Add_My_Admin_Link()' au chargement du menu de l'admin Wordpress
add_action( 'admin_menu', 'myplugin_Add_My_Admin_Link_Sitemap' );

// Ajouter un nouveau lien dans le menu de l'admin Wordpress
function myplugin_Add_My_Admin_Link_Sitemap()
{
  add_menu_page(
        'Sitemap Generator', // Titre de la page
        'Sitemap Generator', // Texte du lien dans le menu
        'manage_options', // capacité nécessaire pour accéder au lien
        'sitemap/includes/toto-acp-page.php' // fichier à afficher quand on clique sur le lien
    );
}