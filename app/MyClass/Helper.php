<?php

namespace App\MyClass;

use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class Helper
{

	public static function validFloat($number)
	{
		return str_replace(',', '', number_format($number));
	}

	public static function validNumber($number)
	{
		$number = (string) $number;
		$arrNumber = explode('.', $number);
		$result = '';

		$result = str_replace(',', '.', number_format($arrNumber[0]));
		if(count($arrNumber) == 2) {
			$result .= ','.$arrNumber[1];
		}

		return $result;
	}

	public static function idPhoneNumberFormat($phone)
	{
		$output = $phone;
		$output = substr($output, 0, 1) == '0'? "62".substr($output, 1) : $output;
		$output = substr($output, 0, 3) == '+62'? substr($output, 1) : $output;
		$output = substr($output, 0, 2) != '62'? "62".$output : $output;

		return $output;
	}

	public static function fixContent($content)
	{
		$result = str_replace('../../storage', url('storage'), $content);
		$result = str_replace('../storage', url('storage'), $result);
		$result = str_replace('../'.url('/'), url('/'), $result);
		return $result;
	}
}
