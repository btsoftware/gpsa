<?php
   /*
   Plugin Name: Heartbeat timelogger
   Plugin URI: http://codea.me
   Description: Plugin para recibir heartbeat con datos del usuario via ajax e incrementar un timer por usuario/pagina. 
   Version: 1.0
   Author: Miguel Chavez Gamboa
   Author URI: http://codea.me
   License: GPL2
   */

    global $wpdb;
    global $heartbeat_db_version;
    $heartbeat_db_version = '1.0';
    $table_name = $wpdb->prefix . 'heartbeattimelogger';
    $table_name_logs = $wpdb->prefix . 'heartbeattimelogger_logs';


    function get_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //check ip from share internet
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //to check ip is pass from proxy
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }




    // function act_session($arg='', $userlogin='') {
    //     global $wpdb, $options_act;
    //     if ( is_numeric($userlogin->ID) ) {
    //         $user_ID = $userlogin->ID;
    //     } else {
    //         $userlogin = get_user_by('login', $arg);
    //         if ($userlogin->ID) {
    //             $user_ID = $userlogin->ID;
    //         } else {
    //             $user_ID = '';
    //         }
    //     }
    //     if (!empty($user_ID) and !get_usermeta($user_ID, 'act_private') and !$_COOKIE['act_logged']) {
    //       $ip = act_real_ip();
    //       $act_time=current_time('mysql', true);
    //       $wpdb->query("INSERT INTO ".$wpdb->prefix."activity (user_id, act_type, act_date, act_params) VALUES($user_ID,'CONNECT', '".$act_time."', '".$ip."')");
    //       setcookie('act_logged',time());
    //     }
    //   }


    // login
    add_action( 'wp_login', 'do_at_login', 2,2 );
    function do_at_login($user_login, $user) {
        // Count login, save action to db..
        global $wpdb;
        
        $the_ip = get_ip();
        $fecha = current_time('mysql', true);
        $table_name_logs = $wpdb->prefix . 'heartbeattimelogger_logs';

        error_log('HEARTBEAT | =========> WP_LOGIN @heartbeat. User: '.print_r($user_login,true).'/'.print_r($user->ID,true).' IP:'.$the_ip.' FECHA:'.$fecha);

        // TODO: Checar que no se haya repetido.. por fecha, por cookie...

        if ( isset($user) && isset($the_ip) && isset($fecha) ) {
            $wpdb->insert( 
                $table_name_logs,
                array(
                    'userid' => $user->ID, 
                    'ip_add' => $the_ip,
                    'datetime' => $fecha 
                ),
                array( 
                    '%d', 
                    '%s',
                    '%s' 
                ) 
            );
        }
    }

    add_action('auth_cookie_valid', 'do_at_auth', 10, 2);
    function do_at_auth($cookie_elems, $user) {
        // Count login, save action to db..
        global $wpdb;
        
        $the_ip = get_ip();
        $fecha = current_time('mysql', true);
        $table_name_logs = $wpdb->prefix . 'heartbeattimelogger_logs';

        error_log('HEARTBEAT | =========> WP_AUTH @heartbeat. COOKIE: '.print_r($cookie_elems,true).'/'.print_r($user->data,true).' IP:'.$the_ip.' FECHA:'.$fecha);

        // TODO: Checar que no se haya repetido.. por fecha, por cookie...

        if ( isset($user) && isset($the_ip) && isset($fecha) ) {
            // $wpdb->insert( 
            //     $table_name_logs,
            //     array(
            //         'userid' => $user->ID, 
            //         'ip_add' => $the_ip,
            //         'datetime' => $fecha 
            //     ),
            //     array( 
            //         '%d', 
            //         '%s',
            //         '%d' 
            //     ) 
            // );
        }
    }

    // Agregar cookie con el id del usuario loggeado
    add_action('the_post', 'agregar_post_id');
    function agregar_post_id($post_object){
        if ( !is_admin() ) {
            //error_log('HEARTBEAT | POST TYPE:'.$post_object->post_type.' POST ID: '.$post_object->ID.' NAME: '.$post_object->post_name);
            if ($post_object->post_type == 'page') {
                setcookie( 'page_id', $post_object->ID, time()+3600*24*1, COOKIEPATH, COOKIE_DOMAIN );
                unset($_COOKIE['post_id']);
                unset($_COOKIE['blog_post_id']);
                setcookie( 'post_id', '', time()-(3600*24), COOKIEPATH, COOKIE_DOMAIN );
                setcookie( 'blog_post_id', '', time()-(3600*24), COOKIEPATH, COOKIE_DOMAIN );
            } else if ($post_object->post_type == 'post') {
                setcookie( 'post_id', $post_object->ID, time()+3600*24*1, COOKIEPATH, COOKIE_DOMAIN );
                unset($_COOKIE['page_id']);
                unset($_COOKIE['blog_post_id']);
                setcookie( 'page_id', '', time()-(3600*24), COOKIEPATH, COOKIE_DOMAIN );
                setcookie( 'blog_post_id', '', time()-(3600*24), COOKIEPATH, COOKIE_DOMAIN );
            } else if ($post_object->post_type == 'blog') {
                setcookie( 'blog_post_id', $post_object->ID, time()+3600*24*1, COOKIEPATH, COOKIE_DOMAIN );
                unset($_COOKIE['post_id']);
                unset($_COOKIE['page_id']);
                setcookie( 'post_id', '', time()-(3600*24), COOKIEPATH, COOKIE_DOMAIN );
                setcookie( 'page_id', '', time()-(3600*24), COOKIEPATH, COOKIE_DOMAIN );
            } else {
                //clear everything...
                unset($_COOKIE['post_id']);
                unset($_COOKIE['page_id']);
                unset($_COOKIE['blog_post_id']);
                setcookie( 'post_id', '', time()-(3600*24), COOKIEPATH, COOKIE_DOMAIN );
                setcookie( 'page_id', '', time()-(3600*24), COOKIEPATH, COOKIE_DOMAIN );
                setcookie( 'blog_post_id', '', time()-(3600*24), COOKIEPATH, COOKIE_DOMAIN );
            }
        }
    }
    add_action( 'init', 'agregar_cookie_userid' );
    function agregar_cookie_userid() {
        $current_user = wp_get_current_user();
        setcookie( 'uid', $current_user->ID, time()+3600*24*1, COOKIEPATH, COOKIE_DOMAIN );
    }
    // logout
    add_action('wp_logout', 'do_at_logout');
    function do_at_logout() {
        unset($_COOKIE['uid']);
        setcookie( 'uid', '', time()-(3600*24), COOKIEPATH, COOKIE_DOMAIN );
        unset($_COOKIE['page_id']);
    }

    // Agregar script para el heartbeat. Solo para usuarios loggeados y que no esten en el wp-admin.
    add_action( 'wp_enqueue_scripts', 'agregar_script' );
    function agregar_script() {
        if ( is_user_logged_in() && !is_admin() ) {
            wp_enqueue_script( 'heartbeat-timelogger-script', plugin_dir_url( __FILE__ ) . 'js/heartbeat.js', array( 'jquery' ), '1.6', true );
            wp_enqueue_script( 'jscookies-script', plugin_dir_url( __FILE__ ) . 'js/js.cookie.js', true );
            wp_localize_script( 'heartbeat-timelogger-script', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        } else {
            // error_log('Usuario no loggeado, no se agrega hearbeat.js');
        }
    }

    // Funciones de instalacion BD al activarse plugin.
    function heartbeat_install() {
        global $wpdb;
        global $heartbeat_db_version;
        $table_name = $wpdb->prefix . 'heartbeattimelogger';
        $table_name_logs = $wpdb->prefix . 'heartbeattimelogger_logs';
        
        $charset_collate = $wpdb->get_charset_collate();

        $sql_log = "CREATE TABLE $table_name_logs (
            id int NOT NULL AUTO_INCREMENT,
            userid int NOT NULL,
            ip_add VARCHAR(64) default '0.0.0.0',
            datetime DATETIME,
            PRIMARY KEY  (id),
            KEY SEC (userid, datetime)
        ) $charset_collate;";

        $sql = "CREATE TABLE $table_name (
            id int NOT NULL AUTO_INCREMENT,
            userid int NOT NULL,
            minutes int default 0,
            pageid int NOT NULL,
            PRIMARY KEY  (id),
            KEY SEC (userid, pageid)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
        dbDelta( $sql_log );

        add_option( 'heartbeattimelogger_db_version', $heartbeat_db_version );
    }
    register_activation_hook( __FILE__, 'heartbeat_install' );

    // add_action( 'wp_ajax_heartbeat_get_tiempousuarios', 'get_tiempousuarios' );
    // function get_tiempousuarios() {
    //     // Regresa el tiempo de cada usuario, en formato necesario para ..
    //     if ( is_user_logged_in() ) {
    //         global $wpdb;
    //         $table_name = $wpdb->prefix . 'heartbeattimelogger';
            
    //         $user_id;
    //         if ( isset( $_POST["uid"] ) ) {
    //             $user_id = $_POST["uid"];
    //         } else {
    //             error_log('No uid presente en el $_POST');
    //         }

    //         // Obtener o crear el registro de tiempo del usuario si existe.
    //         $tiempos_usuarios = $wpdb->get_results( "SELECT userid, SUM(minutes) as minutes_sum, AVG(minutes) as minutes_avg FROM $table_name GROUP BY userid ORDER BY userid;");
	    
   	//         $tiempos_usuariopages = $wpdb->get_results("SELECT userid, pageid, SUM(minutes) as minutes_sum, AVG(minutes) as minutes_avg  FROM $table_name  GROUP BY userid,pageid ORDER BY userid,pageid");

    //         // Tiempos de usuarios
    //         // $usuario = '';
    //         // foreach( $tiempos_usuarios as $reg ) {
    //         //     $usuario = get_user_by('id', $reg->userid);
    //         //     if ( $reg->userid == 1 ) {
    //         //         $usuario = 'admin';
    //         //     } else {
    //         //         $usuario = $usuario->first_name.' '.$usuario->last_name;
    //         //     }
    //         //     $minutos_sum = $reg->minutes_sum;
    //         //     $horas_sum = $reg->minutes_sum/60;
    //         //     $minutos_avg = $reg->minutes_avg;
    //         //     $horas_avg = $reg->minutes_avg/60;
    //         //     $usuarios[] = $usuario; // agregamos el usuario
    //         //     $tiempos_sum[] = number_format($horas_sum, 1, '.', ','); // formato :  4.1
    //         //     $tiempos_avg[] = number_format($horas_avg, 1, '.', ',');
    //         // }

            
            
            
    //         $resultado[] = array(
    //                 'usuarios_pages' => $tiempos_usuariopages,
    //                 'usuarios' => $tiempos_usuarios
    //         );
    //         wp_send_json_success( $resultado );

    //     }
    // }

    add_action( 'wp_ajax_heartbeat_get_logins', 'get_logins' );
    function get_logins() {
        // Regresa el tiempo de cada usuario, en formato necesario para ..
        if ( is_user_logged_in() ) {
            global $wpdb;
            $table_name_logs = $wpdb->prefix . 'heartbeattimelogger_logs';

            $user_id;
            // $_COOKIE["uid"]
            if ( isset( $_POST["uid"] ) ) {
                $user_id = $_POST["uid"];
            } else {
                error_log('No uid presente en el $_POST');
            }

            // Obtener o crear el registro de tiempo del usuario si existe.
            $logins = $wpdb->get_results( "SELECT userid, ip_add, datetime FROM $table_name_logs ORDER BY userid;");
	        
            wp_send_json_success( $logins );

        }
    }

    // Incrementar timer al recibir un heartbeat de un usuario y curso via ajax.
    add_action( 'wp_ajax_heartbeat_inc_time', 'inc_time' );
    function inc_time() {
        if ( is_user_logged_in() ) {
            global $wpdb;
            $table_name = $wpdb->prefix . 'heartbeattimelogger';
            $user_id; $page_id;
            // $_COOKIE["uid"]
            if ( isset( $_POST["uid"] ) ) {
                $user_id = $_POST["uid"];
            } else {
                error_log('heartbeattimelogger -- No uid presente en el $_POST');
            }
            if ( isset( $_POST["page_id"] ) ) {
                $page_id = $_POST["page_id"];
            } else {
                error_log('heartbeattimelogger -- No page_id presente en el $_POST');
            }
            
            if ( isset($user_id) && isset($page_id) ) {
                // Obtener o crear el registro de tiempo del page/usuario si existe.
                $registro = $wpdb->get_row( "SELECT id, userid, pageid, minutes FROM $table_name WHERE userid=$user_id AND pageid=$page_id", ARRAY_A );
                $minutos;

                if ( $registro !== null ) {
                    $minutos = (int) $registro['minutes'];
                    $minutos = $minutos + 1;

                    $str = 'Usuario:'.$registro['userid'].', Page: '.$registro['pageid'].' Old minutes:'.$registro['minutes'].' updated minutes:'.$minutos;
                    error_log($str);

                    // update
                    $wpdb->replace( 
                        $table_name,
                        array(
                            'id' => $registro['id'],
                            'userid' => $user_id, 
                            'pageid' => $page_id, 
                            'minutes' => $minutos 
                        ),
                        array( 
                            '%d',
                            '%d', 
                            '%d',
                            '%d' 
                        ) 
                    );
                } else {
                    error_log("No se encontro registro para clientid $user_id, pageid $page_id. Creando nuevo.");
                    $minutos = 1; // Como es registro nuevo, apenas el primer minuto.

                    // Nuevo
                    $wpdb->insert( 
                        $table_name,
                        array(
                            'userid' => $user_id, 
                            'pageid' => $page_id, 
                            'minutes' => $minutos 
                        ),
                        array( 
                            '%d', 
                            '%d',
                            '%d' 
                        ) 
                    );
                    //error_log('Row inserted: '.$wpdb->insert_id);
                }
            }

        } else {
            error_log('heartbeattimelogger -- No hay usuario loggeado, no se acepta el heartbeat.');
        }
        wp_die();
    }

?>
