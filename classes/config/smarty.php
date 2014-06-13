<?php

Define('TEMPLATES_HOME', "./templates");
Define('TEMPLATES_C_HOME', "./templates_c");
// put full path to Smarty.class.php
require('./smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = TEMPLATES_HOME;
$smarty->compile_dir = TEMPLATES_C_HOME;
//$smarty->cache_dir = '/web/www.domain.com/smarty/cache';
//$smarty->config_dir = '/web/www.domain.com/smarty/configs';

?>