<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Mailer;

abstract class MailerMessageBuilder
{
    /**
     * @var string
     */
    protected $from  = "";

    /**
     * @var string[]
     */
    protected $to = [];

    /**
     * @var string
     */
    protected $subject = "";

    /**
     * @var string
     */
    protected $body_text = "";

    /**
     * @var string|null
     */
    protected $body_html = null;

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param string $from
     *
     * @return MailerMessageBuilder
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param string[] $to
     *
     * @return MailerMessageBuilder
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @param string $to
     *
     * @return MailerMessageBuilder
     */
    public function addTo($to)
    {
        $this->to[] = $to;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     *
     * @return MailerMessageBuilder
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getBodyText()
    {
        return $this->body_text;
    }

    /**
     * @param string $body_text
     *
     * @return MailerMessageBuilder
     */
    public function setBodyText($body_text)
    {
        $this->body_text = $body_text;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getBodyHtml()
    {
        return $this->body_html;
    }

    /**
     * @param string|null $body_html
     *
     * @return MailerMessageBuilder
     */
    public function setBodyHtml($body_html)
    {
        $this->body_html = $body_html;

        return $this;
    }

    /**
     * @param array $parameters
     *
     * @return MailerMessage
     */
    abstract function build(array $parameters = []);
}