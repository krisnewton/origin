<?php

use App\SettingValue;

function setting($code)
{
	$result = SettingValue::where('code', $code)->value('value');

	if ($result) {
		return $result;
	}
	else {
		return false;
	}
}

?>