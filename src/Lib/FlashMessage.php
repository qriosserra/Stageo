<?php

namespace Stageo\Lib;

use Stageo\Lib\enums\FlashType;
use Stageo\Lib\HTTP\Session;

class FlashMessage
{
    private static string $key = __CLASS__;
	public function __construct(private readonly string $content, private readonly FlashType $type)
	{
	}

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type->value;
    }

    /**
     * Adds a FlashMessage in the FlashMessage array stocked in $_SESSION[$key]
     * @param string $content
     * @param FlashType $type
     */
    public static function add(string $content, FlashType $type) : void
    {
        $flashMessages = Session::get(self::$key);
        $flashMessages[] = new FlashMessage($content, $type);
        Session::set(self::$key, $flashMessages);
    }

    /**
     * Returns all FlashMessage in an array and deletes it from session
     * @return  FlashMessage[]
     */
    public static function read() : array
    {
        $flashMessages = Session::get(self::$key);
        Session::delete(self::$key);
        return $flashMessages !== null ? $flashMessages : [];
    }
}