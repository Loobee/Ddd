<?php

namespace Loobee\Ddd\Domain\Mailer;

interface MailerServiceInterface
{
    /**
     * @param MailerMessage $message
     *
     * @return bool
     *
     * @throws MailerException
     */
    public function send(MailerMessage $message);
}