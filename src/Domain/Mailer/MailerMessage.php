<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Mailer;

use Loobee\WorldWideWeb\Domain\Model\EmailAddress;

class MailerMessage
{
    /**
     * @var string
     */
    private $from;

    /**
     * @var string[]
     */
    private $to;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body_text;

    /**
     * @var string|null
     */
    private $body_html;

    /**
     * @param EmailAddress|string $from
     * @param array $to Массив из EmailAddress или string
     * @param $subject
     * @param $body_text
     * @param null $body_html
     */
    public function __construct($from, array $to, $subject, $body_text, $body_html = null)
    {
        $this->from = (string)$from;
        $this->to   = array_map(function($email)
        {
            return (string)$email;
        }, $to);

        $this->subject   = $subject;
        $this->body_text = $body_text;
        $this->body_html = $body_html;
    }

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string[]
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @return string
     */
    public function getBodyText()
    {
        return $this->body_text;
    }

    /**
     * @return string|null
     */
    public function getBodyHtml()
    {
        return $this->body_html;
    }
}