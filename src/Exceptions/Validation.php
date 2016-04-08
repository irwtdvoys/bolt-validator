<?php
	namespace Bolt\Exceptions;

	use \Exception;

	class Validation extends Exception
	{
		public function __construct($message, Exception $previous = null)
		{
			parent::__construct($message, 0, $previous);
		}
	}
?>
