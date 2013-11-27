<?php
/**
 * Elgg CMIS authentication settings
 */
$own = elgg_get_page_owner_entity();

$no_yes_opt = array( 'no' => elgg_echo('option:no'), 'yes' => elgg_echo('option:yes') );

//$user_cmis_url = $vars['entity']->getUserSetting("elgg_cmis_user_cmis_url", $own->guid);
$cmis_login = $vars['entity']->getUserSetting("cmis_login", $own->guid);

// Note : paswword should not be displayed
$cmis_password = $vars['entity']->getUserSetting("cmis_password", $own->guid);
$cmis_password2 = $vars['entity']->getUserSetting("cmis_password2", $own->guid);

// Si le mot de passe a changé, on crypte le nouveau et on enregistre le tout
// Cryptage avec des données stables pour l'user (username et salt)
if (!empty($cmis_password) && ($cmis_password != $cmis_password2)) {
	$key = $own->guid . $own->salt;
	$cmis_password2 = esope_vernam_crypt($cmis_password, $key);
	$vars['entity']->setUserSetting("cmis_password2", $cmis_password2, $own->guid);
	$vars['entity']->setUserSetting("cmis_password", $cmis_password2, $own->guid);
}

?>
<p>
	<fieldset style="border: 1px solid; padding: 15px; margin: 0 10px 0 10px">
		<legend><?php echo elgg_echo('elgg_cmis:title');?></legend>
		
		<!--
		<label for="params[user_cmis_url]"><?php echo elgg_echo('elgg_cmis:user_cmis_url');?></label><br/>
		<input type="text" name="params[user_cmis_url]" value="<?php echo $user_cmis_url;?>" /><br/>
		//-->
		
		<label for="params[cmis_login]"><?php echo elgg_echo('elgg_cmis:cmis_login');?></label><br/>
		<input type="text" name="params[cmis_login]" value="<?php echo $cmis_login; ?>" /><br/>
		
		<label for="params[elgg_cmis:cmis_password]"><?php echo elgg_echo('elgg_cmis:cmis_password');?></label><br/>
		<input type="password" name="params[cmis_password]" value="" /><br/>
		
	</fieldset>
</p>
