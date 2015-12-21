<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'critique2');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'root');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'ppHTNa3i');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8mb4');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '(kj 3P5fr>/g)04NkUCcP+9*]m{HjA.aB Va/n5f`>Y7k+ 5O@,6<F!|3KNQ5*Bi');
define('SECURE_AUTH_KEY',  '+If^V-JIire;]5{c)rV=Qc09I@<0f3jHB;`/?V$c-4:34^Zqj8K(9}Le,_.fAZsg');
define('LOGGED_IN_KEY',    '0sdo5xKN4Ft!;KcI3mPb7+^syN%<j*eJ3T8-HI2~eI5zid68}:c,SIm/8<W:*gVl');
define('NONCE_KEY',        'LC:`I%l+E;9W?SWq0Yq^6YPOC)HL2xC>MEv3Ne>R8zfpic/2Y?NBrv.yJRV-<,YI');
define('AUTH_SALT',        'j*2iAU3Uv=%~63DwgeDDA^aipoOxJEr@<PhhdVR---zX)pXAj3}C/c_7_B~uQ/H[');
define('SECURE_AUTH_SALT', '[W)%m`Jyam$8;[KbNROqLwHalx!_RVW$`C?ga(Ka9o3ZdK0RAmDx1z>3> Mjbu4R');
define('LOGGED_IN_SALT',   'b/u4jHeS<(i jKRIJ},L>1qsJy*?dX%L@^V7I~>[nFCGa+*V{hJWk%O|<3(xFD|t');
define('NONCE_SALT',       'GFRd}r6&MdfvgS:C%c9hN.aDr/R3RKd _ 2qB6ECj^C588^}=$NroRbO67ZKr.{q');
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'wp_';

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', false); 

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');