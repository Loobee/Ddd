# Loobee/Ddd

Search the best approach with DDD(Domain-Driven Design).

IN DEV

Based on http://github.com/dddinphp/ddd

# Sample
The sample application is not ready

## Application service
```php
<?php

namespace App\Application\Service\Samples\FirstSample;

use Loobee\Ddd\Application\Service\ApplicationServiceInterface;

class FirstSampleService implements ApplicationServiceInterface
{
    public function execute($request)
    {
        // ...
    }
}
```

### Declare service applications
```yml
    app.application.service.samples.first_sample:
      class: App\Application\Service\Samples\FirstSample\FirstSampleService
```
### Wrap service in transaction
```yml
     app.application.service.samples.first_sample_inner:
      class: App\Application\Service\Samples\FirstSample\FirstSampleService
      public: false
     app.application.service.samples.first_sample:
      class: Loobee\Ddd\Application\Service\TransactionalApplicationServiceAdapter
      arguments:
        - "@app.application.service.samples.first_sample_inner"
        - "@loobee_ddd.application.service.doctrine_session"
        - "@loobee_ddd.domain.event.event_manager"
```
## Declare subscriber
```php
<?php

namespace App\Application\Subscriber\User;

use App\Domain\Model\User\Event\UserCreated;
use Loobee\Ddd\Domain\Event\EventSubscriberInterface;
use Loobee\Ddd\Domain\Event\EventInterface;
use App\Domain\Model\User\UserRepositoryInterface;
use Loobee\Ddd\Domain\Mailer\MailerServiceInterface;
use Loobee\Ddd\Domain\Mailer\MailerMessageBuilder;
use Symfony\Component\Routing\Router;
use App\Domain\Model\User\User;


class OnUserCreatedSendNotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $user_repository;

    /**
     * @var MailerServiceInterface
     */
    private $mailer_service;

    /**
     * @var MailerMessageBuilder
     */
    private $mailer_message;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var string
     */
    private $route;

    /**
     * @param UserRepositoryInterface $user_repository
     * @param MailerServiceInterface $mailer_service
     * @param MailerMessageBuilder $mailer_message
     * @param Router $router
     * @param string $route
     */
    public function __construct(UserRepositoryInterface $user_repository, MailerServiceInterface $mailer_service, MailerMessageBuilder $mailer_message, Router $router, $route)
    {
        $this->user_repository = $user_repository;
        $this->mailer_service = $mailer_service;
        $this->mailer_message = $mailer_message;
        $this->router = $router;
        $this->route = $route;
    }


    public function isSubscribedTo(EventInterface $event)
    {
        return $event instanceof UserCreated;
    }

    public function handle(EventInterface $event)
    {
        /** @var UserCreated $event */
        /** @var User $user */

        $user = $this->user_repository->find($event->getId());

        if (empty($user) || $user->isEnabled())
        {
            return;
        }

        $url  = $this->router->generate($this->route, ['token' => $user->getConfirmationToken()]);

        $mail = $this->mailer_message
            ->addTo((string)$user->getEmail())
            ->build([
                'view' => 'Email/register.html.twig',
                'vars' => [
                    'user' => $user,
                    'url'  => $url
                ]
            ]);

        $this->mailer_service->send($mail);
    }
}
```

```yml
  app.application.subscriber.user.on_user_created_send_notification_subscriber:
    class: App\Application\Subscriber\User\OnUserCreatedSendNotificationSubscriber
    public: false
    tags: [{ name: loobee_ddd.event_subscriber }]
    arguments:
      - "@app.domain.model.user.user_repository"
      - "@loobee_ddd.domain.mailer.mailer_service"
      - "@loobee_ddd.domain.mailer.template_mailer_message_builder"
      - "@router"
      - "login_confirm"
```


## Criteria
```php
<?php

namespace App\Domain\Criteria;

use Loobee\Ddd\Domain\Criteria\Field;
use Loobee\Ddd\Domain\Criteria\InvalidCriteriaFieldNameException;

class UserField extends Field
{
    const kAccountName;
    const kEmailAddress;

    const kAllowedFields = [
        self::kAccountName,
        self::kEmailAddress
    ];

    /**
     * @param string $name
     *
     * @throws InvalidCriteriaFieldNameException
     */
    protected function assertFieldIsValid($name)
    {
        if (!in_array($name, self::kAllowedFields))
        {
            throw new InvalidCriteriaFieldNameException($name);
        }
    }
}
```

## Event
```php
<?php

namespace App\Domain\Model\User\Event;

use DateTime;
use Loobee\Ddd\Domain\Event\EventInterface;
use Loobee\Ddd\Domain\Event\PublicEventInterface;

final class UserCreated implements EventInterface, PublicEventInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var DateTime
     */
    private $occurred_on;

    public function __construct($id)
    {
        $this->id          = $id;
        $this->occurred_on = new DateTime();
    }

    public function getOccurredOn()
    {
        return $this->occurred_on;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
```

## Object Value
```php
<?php

namespace App\Domain\Model\User;

use Loobee\Ddd\Domain\ObjectValueInterface;

class AccountName implements ObjectValueInterface
{
    /**
     * @var string
     */
    private $account_name;

    /**
     * @var string
     */
    private $canonical_account_name;

    /**
     * @param string $account_name
     */
    public function __construct($account_name)
    {
        $this->account_name = $account_name;
        $this->canonical_account_name = mb_strtolower($account_name);
    }


    public function isEqual(ObjectValueInterface $object_value = null)
    {
        if (is_null($object_value) || get_class($object_value) != static::class)
        {
            return false;
        }

        /** @var AccountName $object_value */

        return $this->canonical_account_name == $object_value->canonical_account_name;
    }

    public function __toString()
    {
        return $this->account_name;
    }

    /**
     * @return string
     */
    public function getCanonicalAccountName()
    {
        return $this->canonical_account_name;
    }
}
```

## Entity
```php
<?php

namespace App\Domain\Model\User;

use Loobee\Ddd\Domain\EntityInterface;
use Loobee\Ddd\Domain\EntityDefaultImplementationTrait;
use Loobee\Ddd\Domain\Event\EventContainerInterface;
use Loobee\Ddd\Domain\Event\EventContainerDefaultImplementationTrait;
use Loobee\Ddd\Domain\Model\Identifier\Identity;
use App\Domain\Model\User\Event\UserCreated;

class User implements EntityInterface, EventContainerInterface
{
    use EntityDefaultImplementationTrait;
    use EventContainerDefaultImplementationTrait;

    /**
     * @var AccountName
     */
    private $account_name;

    public function __construct(Identity $identity, AccountName $account_name)
    {
        $this->setId($identity);

        $this->account_name = $account_name;

        $this->createEvent(new UserCreated($this->getId()));
    }

    /**
     * @return AccountName
     */
    public function getAccountName()
    {
        return $this->account_name;
    }
}
```

## Repository
```php
<?php

namespace App\Infrastructure\Persistence\Domain\Model\User;

use Exception;
use Doctrine\ORM\EntityManager;
use App\Domain\Model\User\User;
use App\Domain\Model\User\AccountName;
use Loobee\Ddd\Domain\EntityInterface;
use Loobee\Ddd\Infrastructure\Persistence\Domain\DoctrineEntityRepository;
use Loobee\Ddd\Domain\Cache\CacheManagerInterface;

class DoctrineUserRepository extends DoctrineEntityRepository implements UserRepositoryInterface
{
    /**
     * @var CacheManagerInterface
     */
    private $cache_manager;

    public function __construct(EntityManager $entity_manager, CacheManagerInterface $cache_manager)
    {
        parent::__construct($entity_manager);

        $this->cache_manager = $cache_manager;
    }

    protected function getEntity()
    {
        return User::class;
    }

    public function findByAccountName(AccountName $account)
    {
        return $this->getEntityRepository()->findOneBy([
            'account_name.canonical_account_name' => $account->getCanonicalAccountName()
        ]);
    }
}
```