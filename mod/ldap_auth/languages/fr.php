<?php
/**
 * Elgg LDAP authentication
 * 
 * @package ElggLDAPAuth
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Misja Hoebe <misja@elgg.com>
 * @copyright Curverider Ltd 2008
 * @link http://elgg.com
 */

$fr = array(
	
	'ldap_auth:missingsettings' => "Veuillez configurer le plugin ldap_auth plugin en créant un fichier settings.php à la racine du plugin. Voyez le fichier settings_dist.php pour un exemple de fichier de configuration.",
	
	'ldap_auth:settings:label:host' => "Host settings",
	'ldap_auth:settings:label:connection_search' => "LDAP settings",
	'ldap_auth:settings:label:hostname' => "Hostname",
	'ldap_auth:settings:help:hostname' => "Enter the canonical hostname, for example <i>ldap.yourcompany.com</i>",
	'ldap_auth:settings:label:port' => "The LDAP server port",
	'ldap_auth:settings:help:port' => "The LDAP server port. Defaults is 389, which mosts hosts will use.",
	'ldap_auth:settings:label:version' => "LDAP protocol version",
	'ldap_auth:settings:help:version' => "LDAP protocol version. Defaults to 3, which most current LDAP hosts will use.",
	'ldap_auth:settings:label:ldap_bind_dn' => "LDAP bind DN",
	'ldap_auth:settings:help:ldap_bind_dn' => "Which DN to use for a non-anonymous bind, for exampe <i>cn=admin,dc=yourcompany,dc=com</i>",
	'ldap_auth:settings:label:ldap_bind_pwd' => "LDAP bind password",
	'ldap_auth:settings:help:ldap_bind_pwd' => "Which password to use when performing a non-anonymous bind.",
	'ldap_auth:settings:label:basedn' => "Based DN",
	'ldap_auth:settings:help:basedn' => "The base DN. Separate with a colon (:) to enter multiple DNs, for example <i>dc=yourcompany,dc=com : dc=othercompany,dc=com</i>",
	'ldap_auth:settings:label:filter_attr' => "Username filter attribute",
	'ldap_auth:settings:help:filter_attr' => "The filter to use for the username, common are <i>cn</i>, <i>uid</i> or <i>sAMAccountName</i>.",
	'ldap_auth:settings:label:search_attr' => "Search attributes",
	'ldap_auth:settings:help:search_attr' => "Enter search attibutes as key, value pairs with the key being the attribute description, and the value being the actual LDAP attribute.
	 <i>firstname</i>, <i>lastname</i> and <i>mail</i> are used to create the Elgg user profile. The following example will work for ActiveDirectory:<br/>
	 <blockquote><i>firstname:givenname, lastname:sn, mail:mail</i></blockquote>",
	'ldap_auth:settings:label:user_create' => "Create users",
	'ldap_auth:settings:help:user_create' => "Optionally, an account can get created when a LDAP authentication was succesful.",
	'ldap_auth:settings:label:start_tls' => "Start TLS",
	'ldap_auth:settings:help:start_tls' => "Start TLS to secure LDAP authentication (server needs to support LDAPS).",
	
	'ldap_auth:settings:updatename' => "Forcer la mise à jour des noms affichés sur la base des informations du LDAP (NOM Prénom) ?",
	
	'ldap_auth:no_account' => "Your credentials are valid, but no account was found - please contact the system administrator",
	'ldap_auth:no_register' => 'An account could not get created for you - please contact the system administrator.',
	'ldap_auth:invalid:password' => 'LDAP : votre mot de passe est incorrect',
	'ldap_auth:invalid:username' => 'LDAP : votre login est inconnu (attention à la casse)',
	
	'ldap_auth:title' => "Authentification LDAP",
	'ldap_auth:settings:allow_registration' => "Permettre de créer un compte à partir d'un compte LDAP (l'identifiant doit exister dans LDAP) ?",
	'elgg_ldap:mail_field_name' => "Nom du champ donnant l'email du compte dans LDAP",
	'elgg_ldap:username_field_name' => "Nom du champ donnant l'username du compte dans LDAP (et Elgg)",
	'elgg_ldap:status_field_name' => "Nom du champ donnant le statut du compte LDAP actif/inactif",
	'elgg_ldap:generic_register_email' => "Adresse email générique pour la création des comptes (avant MAJ via LDAP)",
	
);

add_translation('fr', $fr);

