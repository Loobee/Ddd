<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

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