<?php

namespace App\Event;

use App\Const\Mailchimp;
use App\Entity\User;
use MailchimpMarketing\ApiClient;

final class UserRegisteredListener
{
    public function __construct(
        private readonly ApiClient $mailchimp,
    )
    {
    }

    public function onUserRegistered(UserRegisteredEvent $event): void
    {
        $user = $event->getUser();

        $this->mailChimpAudienceNewSubscriber($user);
    }

    private function mailChimpAudienceNewSubscriber(User $user): void
    {
        try {
            $this->mailchimp->lists->addListMember(Mailchimp::REGISTRATION_SUB_LIST_ID, [
                'email_address' => $user->getEmail(),
                'status' => 'subscribed',
            ]);
        } catch (\Exception $e) {
            // TODO: log based on http state codes?
            // Email already exist or API doesn't work, just continue..
        }
    }
}
