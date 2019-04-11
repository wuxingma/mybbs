<?php 



	function getSm($fileName)
	{
		$arr = explode('/',$fileName);
		$arr[3] = 'sm_'.$arr[3];
		return implode('/',$arr);
	}













 ?>