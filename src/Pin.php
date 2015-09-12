<?php

namespace Link0\Phpebble;

use DateTime;
use DateTimeInterface;

final class Pin
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var DateTimeInterface
     */
    private $dateTime;

    /**
     * @var string
     */
    private $title;

    /**
     * @param string             $id
     * @param DateTimeInterface $dateTime
     * @param string             $title
     */
    private function __construct($id, DateTimeInterface $dateTime, $title)
    {
        $this->id = $id;
        $this->dateTime = $dateTime;
        $this->title = $title;
    }

    /**
     * @param string            $id
     * @param DateTimeInterface $dateTime
     * @param string            $title
     *
     * @return Pin
     */
    public static function create($id, DateTimeInterface $dateTime, $title)
    {
        return new self($id, $dateTime, $title);
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return DateTimeInterface
     */
    public function dateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Returns a JSON-representation of the Pin for use with the Timeline API
     *
     * @return string
     */
    public function json()
    {
        return json_encode([
            'id' => $this->id(),
            'time' => $this->dateTime()->format(DateTime::ATOM),
            'layout' => [
                'title' => $this->title(),
            ],
        ], JSON_PRETTY_PRINT);
    }
}