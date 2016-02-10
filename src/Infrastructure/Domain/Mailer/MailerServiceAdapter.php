<?php // Copyright (c) 2016 Andrey <qRoC.Work@gmail.com> Savitsky. All rights reserved.

namespace Loobee\Ddd\Infrastructure\Domain\Mailer;

use Loobee\Ddd\Domain\Mailer\MailerServiceInterface;
use Loobee\Ddd\Domain\Mailer\MailerException;
use Loobee\Ddd\Domain\Mailer\MailerMessage;
use Swift_Mailer;
use Swift_Message;
use Exception;

class MailerServiceAdapter implements MailerServiceInterface
{
    /**
     * @var Swift_Mailer
     */
    private $swift_mailer;

    /**
     * @param Swift_Mailer $swift_mailer
     */
    public function __construct(Swift_Mailer $swift_mailer)
    {
        $this->swift_mailer = $swift_mailer;
    }

    public function send(MailerMessage $message)
    {
        try
        {
            $swift_message = $this->transformMessage($message);

            return $this->swift_mailer->send($swift_message) > 0;
        }
        catch (Exception $e)
        {
            throw new MailerException(sprintf('Error on send message: %s', $e->getMessage()));
        }
    }

    private function transformMessage(MailerMessage $message)
    {
        return Swift_Message::newInstance()
            ->setSubject($message->getSubject())
            ->setFrom($message->getFrom())
            ->setTo($message->getTo())
            ->setBody($message->getBodyText(), 'text/plain')
            ->addPart($message->getBodyHtml(), 'text/html');
    }
}