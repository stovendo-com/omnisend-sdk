<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Trait;

use Stovendo\Omnisend\Exception\ContactNotFoundException;
use Stovendo\Omnisend\Model\Contact;
use Stovendo\Omnisend\Model\Contacts;
use Stovendo\Omnisend\Model\NewContact;
use Stovendo\Omnisend\Model\NewContactSuccess;

trait ContactApiTrait
{
    private const string ENDPOINT_CONTACTS = '/contacts';

    public function createContact(NewContact $contact): Contact
    {
        $result = $this->post(self::ENDPOINT_CONTACTS, $contact, NewContactSuccess::class);

        return $this->getContact($result->contactID) ?? throw new ContactNotFoundException('Contact not found after creation');
    }

    public function getContact(string $contactId): ?Contact
    {
        try {
            return $this->get(self::ENDPOINT_CONTACTS.'/'.$contactId, Contact::class);
        } catch (ContactNotFoundException) {
            return null;
        }
    }

    public function getContactByEmail(string $email): ?Contact
    {
        try {
            return $this->get(self::ENDPOINT_CONTACTS, Contacts::class, query: ['email' => $email])->first();
        } catch (ContactNotFoundException) {
            return null;
        }
    }

    public function replaceContact(Contact $contact): void
    {
        $this->patch(self::ENDPOINT_CONTACTS.'/'.$contact->contactID, $contact);
    }

    public function deleteContact(string $contactId): void
    {
        try {
            $this->delete(self::ENDPOINT_CONTACTS, $contactId);
        } catch (ContactNotFoundException) {
            // if it's not there, ignore it
        }
    }
}
