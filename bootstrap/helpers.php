<?php

if (!function_exists('admin_toastr')) {


	function admin_toastr($message = '', $type = 'success', $options = [])
	{
		$toastr = new \Illuminate\Support\MessageBag(get_defined_vars());

		\Illuminate\Support\Facades\Session::flash('toastr', $toastr);
	}
}
