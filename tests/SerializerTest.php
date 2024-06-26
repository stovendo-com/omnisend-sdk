<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Stovendo\Omnisend\Model\ContactIdentifierChannel;
use Stovendo\Omnisend\Model\ContactIdentifierChannels;
use Stovendo\Omnisend\Model\Product;
use Stovendo\Omnisend\Serializer;
use Stovendo\Omnisend\Test\OmnisendFixtures;

#[CoversClass(Serializer::class)]
class SerializerTest extends TestCase
{
    public function test_serialize(): void
    {
        $product = OmnisendFixtures::createProduct();
        $serializer = new Serializer();
        $serialized = $serializer->serialize($product);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/data/serializer1.json', $serialized);
    }

    public function test_deserialize(): void
    {
        $serializer = new Serializer();
        $product = OmnisendFixtures::createProduct();
        $serialized = $serializer->serialize($product);

        $deserialized = $serializer->deserialize($serialized, Product::class);
        $this->assertEquals($product, $deserialized);
    }

    public function test_skip_null_values_during_contact_identifier_serialization(): void
    {
        $serializer = new Serializer();
        $contactIdentifierChannels = new ContactIdentifierChannels(
            email: new ContactIdentifierChannel(ContactIdentifierChannel::STATUS_NON_SUBSCRIBED)
        );

        $serialized = $serializer->serialize($contactIdentifierChannels);
        $this->assertJsonStringEqualsJsonString('{"email":{"status":"nonSubscribed","statusDate":null}}', $serialized);
    }
}
