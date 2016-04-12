<?php
	declare(strict_types=1);

	namespace Bolt;

	use Bolt\Exceptions\Validation as Exception;
	use DateTimeZone;

	class Validator
	{
		private $throw;

		public function __construct(bool $throw = true)
		{
			$this->throw = $throw;
		}

		/**
		 * Checks validity of given UUID against RFC4122
		 * @link https://tools.ietf.org/html/rfc4122
		 * @param $UUID
		 * @throws \Exception
		 * @return boolean
		 */
		public function uuid($UUID)
		{
            if (!preg_match('/^([a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12})$/', strtolower($UUID)))
            {
				if ($this->throw === true)
				{
					throw new Exception("Invalid UUID provided");
				}

				return false;
			}

			return true;
		}

		/**
		 * For now only checks if valid hex is sent
		 * @param $pushToken
		 * @throws \Exception
		 * @return boolean
		 */
		public function pushToken($pushToken)
		{
			if (!ctype_xdigit($pushToken))
			{
				if ($this->throw === true)
				{
					throw new Exception("Invalid APN device token provided");
				}

				return false;
			}

			return true;
		}

		/**
		 * Check the validity of locale against the Unicode Consortium's Common Locale Data Repository
		 * releases 1.4.1 and releases 1.9
		 * @link http://cldr.unicode.org/
		 * @param $locale
		 * @throws \Exception
		 * @return boolean
		 */
		public function locale($locale)
		{
			if (!preg_match("/^[a-z]{2}(_([a-zA-Z]{2}){1,2})?_[A-Z]{2}$/", $locale))
			{
				if ($this->throw === true)
				{
					throw new Exception("Invalid locale provided");
				}

				return false;
			}

			return true;
		}

		/**
		 * Checks the validity of a timezone against PHP's own DateTimeZone::listIdentifiers
		 * @link http://php.net/manual/en/datetimezone.listidentifiers.php
		 * @param $timezone string
		 * @throws \Exception
		 * @return boolean
		 */
		public function timezone($timezone)
		{
			if (!in_array($timezone, DateTimeZone::listIdentifiers()))
			{
				if ($this->throw === true)
				{
					throw new Exception("Invalid timezone provided");
				}

				return false;
			}

			return true;
		}

		/**
		 * Checks the validity of a latitude and longitude in degrees
		 * @param $lat
		 * @param $lng
		 * @return bool|void
		 * @throws \Exception
		 * @return boolean
		 */
		public function coordinates($lat, $lng)
		{
			$vLat = is_numeric($lat) && (-90 <= $lat) && ($lat <= 90);
			$vLng = is_numeric($lng) && (-180 <= $lng) && ($lng <= 180);

			if ($vLat === true && $vLng === true)
			{
				return true;
			}
			else
			{
				if ($this->throw === true)
				{
					throw new Exception("Invalid coordinates provided");
				}

				return false;
			}
		}
	}
?>
