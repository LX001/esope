<?php
/**
 * English strings
 */
global $CONFIG;

$en = array(
	'elgg_cas:title' => "Login with CAS",
	
	'elgg_cas:loginbutton' => "CAS login",
	'elgg_cas:casdetected' => "CAS login detected.",
	'elgg_cas:login:success' => "Successfully logged in with CAS",
	
	'elgg_cas:settings:autologin' => "CAS autologin.",
	'elgg_cas:settings:autologin:details' => "If activated, a valid CAS authentication will log the user in. If disabled, members need to connect through a login page.",
	
	'elgg_cas:cas_host' => "CAS host, eg: cas.example.com",
	'elgg_cas:cas_context' => "CAS context, eg: /cas",
	'elgg_cas:cas_port' => "Port, eg: 443",
	'elgg_cas:ca_cert_path' => "(optional) Path to PEM certificate, eg: /path/to/cachain.pem",
	
	// Errors
	'elgg_cas:missingparams' => "Missing CAS parameters. Please set up the plugin settings to use CAS.",
	'elgg_cas:user:banned' => "Disabled account",
	'elgg_cas:user:notexist' => "This account doesn't exist yet. Please create it first the regular way. Once your account exists, you can connect with CAS.",
	'elgg_cas:loginfailed' => "Login failed",
	'elgg_cas:logged:nocas' => "You're now logged in without CAS.",
	'elgg_cas:logged:cas' => "You're now logged in with CAS account <b>%s</b>.",
	'elgg_cas:confirmcaslogin' => 'You are logged in on this site with <b>%1$s</b> (%2$s). <br />To login with your CAS account, please <a href="' . $CONFIG->url . 'action/logout">logout first</a>, then connect again with CAS.',
	'elgg_cas:confirmchangecaslogin' => 'You are logged in on this site with <b>%1$s</b> (%2$s). <br />To login with an other CAS account, please <a href="' . $CONFIG->url . 'action/logout">logout first</a>, then connect again with CAS.',
	'elgg_cas:alreadylogged' => 'You are logged in on this site with <b>%3$s</b> (%4$s), and trying to login with CAS account <b>%1$s</b> (%2$s). <br />To login with your CAS account <b>%1$s</b>, please <a href="' . $CONFIG->url . 'action/logout">logout first</a>.',

	
);

add_translation('en', $en);
