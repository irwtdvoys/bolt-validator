<?php
	namespace Bolt;

	use DateTimeZone;

	class Validator
	{
		/**
		 * Checks validity of given UUID against RFC4122
		 * @link https://tools.ietf.org/html/rfc4122
		 * @param $UUID
		 * @throws \Exception
		 */
		public function uuid($UUID)
		{
			if (preg_match('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/', $UUID))
			{
				return;
			}
			else
			{
				throw new Exceptions\Validation("Invalid UUID provided");
			}
		}

		/**
		 * For now only checks if valid hex is sent
		 * @param $pushToken
		 * @throws \Exception
		 */
		public function pushToken($pushToken)
		{
			if (ctype_xdigit($pushToken))
			{
				return;
			}
			else
			{
				throw new Exceptions\Validation("Invalid APN device token provided");
			}
		}

		/**
		 * Check the validity of locale against the Unicode Consortium's Common Locale Data Repository
		 * releases 1.4.1 and releases 1.9
		 * @link http://cldr.unicode.org/
		 * @param $locale
		 * @throws \Exception
		 */
		public function locale($locale)
		{
			if (preg_match("/^[a-z]{2}(_([a-zA-Z]{2}){1,2})?_[A-Z]{2}$/", $locale))
			{
				return;
			}
			else
			{
				throw new Exceptions\Validation("Invalid locale provided");
			}
		}

		/**
		 * Checks the validity of a timezone against PHP's own DateTimeZone::listIdentifiers
		 * @link http://php.net/manual/en/datetimezone.listidentifiers.php
		 * @param $timezone string
		 * @throws \Exception
		 */
		public function timezone($timezone)
		{
			if (in_array($timezone, DateTimeZone::listIdentifiers()))
			{
				return;
			}
			else
			{
				throw new Exceptions\Validation("Invalid timezone provided");
			}
		}

		/**
		 * Checks the validity of a latitude and longitude in degrees
		 * @param $lat
		 * @param $lng
		 * @return bool|void
		 * @throws \Exception
		 */
		public function coordinates($lat, $lng)
		{
			$vLat = is_numeric($lat) && floor($lat) !== $lat;
			$vLng = is_numeric($lng) && floor($lng) !== $lng;

			if ($vLat === true && $vLng === true)
			{
				return;
			}
			else
			{
				throw new Exceptions\Validation("Invalid coordinates provided");
			}
		}
	}
?>
