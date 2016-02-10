<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Domain\Mailer;

class DefaultMailerMessageBuilder extends MailerMessageBuilder
{
    public function build(array $parameters = [])
    {
        return new MailerMessage(
            $this->from,
            $this->to,
            $this->subject,
            $this->body_text,
            $this->body_html
        );
    }
}