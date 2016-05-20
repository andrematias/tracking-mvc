<?php

	$page = "
		<select>
		{options}
		</select>
	";

	$v = array('var1', 'var 2');

	$novosOptions = '';

	foreach ($v as $value) {
		$novosOptions .= '<option>'.$value.'</option>';
	}
		$page = str_replace('{options}', $novosOptions, $page);
	echo $page;
