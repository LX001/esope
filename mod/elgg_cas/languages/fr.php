<?php
/**
 * French strings
 */
global $CONFIG;

$fr = array(
	'elgg_cas:title' => "Connexion avec CAS",
	
	'elgg_cas:loginbutton' => "Connexion CAS",
	'elgg_cas:casdetected' => "Identification CAS détectée.",
	'elgg_cas:login:success' => "Connexion avec CAS réussie",
	
	'elgg_cas:settings:autologin' => "Login CAS automatique.",
	'elgg_cas:settings:autologin:details' => "Si l'identification automatique via CAS est activée, les membres seront connectés au réseau s'ils ont une authentification CAS active. Si elle n'est pas activée, il faut cliquer sur la connexion via CAS pour se connecter.",
	
	'elgg_cas:cas_host' => "URL de l'hôte CAS, par ex: cas.example.com",
	'elgg_cas:cas_context' => "CAS context, par ex: /cas",
	'elgg_cas:cas_port' => "Port, par ex: 443",
	'elgg_cas:ca_cert_path' => "(facultatif) Chemin du certificat PEM sur le serveur, par ex: /path/to/cachain.pem",
	
	// Errors
	'elgg_cas:missingparams' => "Paramètres du plugin CAS manquants. Veuillez les renseigner pour utiliser CAS.",
	'elgg_cas:user:banned' => "Compte désactivé",
	'elgg_cas:user:notexist' => "Ce compte n'existe pas encore. Pour le créer, veuillez vous connecter une première fois avec votre compte LDAP. Une fois votre compte créé, vous pourrez vous connecter via CAS.",
	'elgg_cas:loginfailed' => "Echec de la connexion",
	'elgg_cas:logged:nocas' => "Vous êtes actuellement connecté sans utiliser CAS.",
	'elgg_cas:logged:cas' => "Vous êtes actuellement connecté par CAS avec le compte <b>%s</b>.",
	'elgg_cas:confirmcaslogin' => 'Vous utilisez sur ce site le compte <b>%1$s</b> (%2$s). <br />Pour vous connecter avec votre compte CAS, veuillez d\'abord <a href="' . $CONFIG->url . 'action/logout">vous déconnecter</a>, puis vous identifier avec CAS.',
	'elgg_cas:confirmchangecaslogin' => 'Vous utilisez sur ce site le compte <b>%1$s</b> (%2$s). <br />Pour vous connecter avec un autre compte CAS, veuillez d\'abord <a href="' . $CONFIG->url . 'action/logout">vous déconnecter du compte que vous utilisez</a>, puis vous identifier avec CAS.',
	'elgg_cas:alreadylogged' => 'Vous utilisez actuellement le compte <b>%3$s</b> (%4$s), et tentez de vous connecter avec le compte CAS <b>%1$s</b> (%2$s). <br />Pour vous connecter avec votre compte CAS <b>%1$s</b>, veuillez d\'abord <a href="' . $CONFIG->url . 'action/logout">vous déconnecter du compte que vous utilisez</a>.',

	
);

add_translation('fr', $fr);
