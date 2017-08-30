<?php namespace MaddHatter\LaravelFullcalendar;

use DateTime;

interface Event
{
    /**
     * Get the event's title
     *
     * @return string
     */
    public function getTitle();

    /**
     * Get the event's title
     *
     * @return string
     */
    public function getDescripcion();
    /**
     * Is it an all day event?
     *
     * @return bool
     */
    public function isAllDay();

    /**
     * Get the start time
     *
     * @return DateTime
     */
    public function getStart();

    /**
     * Get the end time
     *
     * @return DateTime
     */
    public function getEnd();

}