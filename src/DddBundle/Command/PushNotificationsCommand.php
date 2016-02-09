<?php

namespace Loobee\Ddd\DddBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Loobee\Ddd\Application\Notification\NotificationService;
use Loobee\Ddd\Application\Notification\NotificationRepositoryInterface;
use Loobee\Ddd\Application\Notification\PublishedMessageRepositoryInterface;
use Loobee\Ddd\Application\Notification\MessageProducerInterface;

class PushNotificationsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('domain:events:spread')
            ->setDescription('Notify all domain events via messaging')
            ->addArgument('exchange-name', InputArgument::OPTIONAL, 'Exchange name to publish events to');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var NotificationRepositoryInterface $notification_repository */
        $notification_repository_service_name = 'loobee_ddd.application.notification.notification_repository';
        $notification_repository = $this->getContainer()->get($notification_repository_service_name);

        /** @var PublishedMessageRepositoryInterface $published_message_repository */
        $published_message_repository_service_name = 'loobee_ddd.application.notification.published_message_repository';
        $published_message_repository = $this->getContainer()->get($published_message_repository_service_name);

        /** @var MessageProducerInterface $message_producer */
        $message_producer_service_name = 'loobee_ddd.application.notification.message_producer';
        $message_producer = $this->getContainer()->get($message_producer_service_name);


        $notification_service = new NotificationService(
            $notification_repository,
            $published_message_repository,
            $message_producer
        );

        $number_of_notifications = $notification_service->publishNotifications($input->getArgument('exchange-name'));
        $output->writeln(sprintf('<comment>%d</comment> <info>notification(s) sent!</info>', $number_of_notifications));
    }
}
