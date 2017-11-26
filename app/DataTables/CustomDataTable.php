<?php

namespace App\DataTables;

use Carbon\Carbon;

trait CustomDataTable  {
	

	public function printDateTime($date){

		$timezone = $this->request->timezone;
		static $datetime_format;

		$datetime_format ?: $datetime_format = \Cache::get('settings.datetime_format');
		$date instanceof Carbon ?:$date=Carbon::parse($date);
		$timezone?:$timezone=\Config::get('app.timezone');

		return $date?$date->setTimezone($timezone)->format($datetime_format):'';
	}
}