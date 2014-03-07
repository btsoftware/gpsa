<?php

// Essentials
include_once 'includes/config.php';
include_once 'includes/init.php';

// Register & Functions
include_once 'includes/register.php';
include_once 'includes/func.php';


include_once 'includes/ratings.php';


// Customizer
include_once 'includes/customizer/customizer.php';
include_once 'includes/customizer/css.php';


include_once 'includes/vibe-menu.php';

include_once 'includes/author.php';

if ( function_exists('bp_get_signup_allowed')) {
    include_once 'includes/bp-custom.php';
}

include_once '_inc/ajax.php';

//Widgets
include_once('includes/widgets/custom_widgets.php');
if ( function_exists('bp_get_signup_allowed')) {
include_once('includes/widgets/custom_bp_widgets.php');
}
include_once('includes/widgets/advanced_woocommerce_widgets.php');
include_once('includes/widgets/twitter.php');
include_once('includes/widgets/flickr.php');
include_once('includes/widgets/instagram.php');

//Misc
include_once 'includes/sharing.php';
include_once 'includes/tour.php';

// Options Panel
get_template_part('vibe','options');


//Redirect user
function redirect_based_on_role()
{
    //comprueba informacion usuario actual
    global $current_user;
    get_currentuserinfo();
    die(var_dump($current_user));
    if ($current_user->user_level == 0)
    {
     // Usuario es sucriptor
     // Redirección a la respectiva página.
    }
    else if ($current_user->user_level > 1)
    {
      // Usuario es colaborador
      // Redirección a la respectiva página.
    }
    else if ($current_user->user_level >8)
    {
      // Usuario es un editor
      // Redirección a la respectiva página.
    }
    else
    {
      // No se encontró el perfil de usaurio
      // Salir de aquí
    }
}
// Utiliza esta acción para hacerlo posible.
add_action("admin_init","redirect_based_on_role");
?>
