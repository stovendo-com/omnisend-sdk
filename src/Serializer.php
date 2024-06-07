<?php

/**
 * @copyright © UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * https://www.nfq.lt
 */

declare(strict_types=1);

namespace Stovendo\Omnisend;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\PropertyInfo\Extractor\ConstructorExtractor;
use Symfony\Component\PropertyInfo\Extractor\PhpStanExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AttributeLoader;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

class Serializer
{
    public const string DATE_FORMAT = 'Y-m-d\TH:i:s\Z';
    private SymfonySerializer $serializer;

    public function __construct(
        private readonly LoggerInterface $logger = new NullLogger()
    ) {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [
            new ArrayDenormalizer(),
            new DateTimeNormalizer([DateTimeNormalizer::FORMAT_KEY => self::DATE_FORMAT]),
            new BackedEnumNormalizer(),
            new ObjectNormalizer(
                classMetadataFactory: new ClassMetadataFactory(new AttributeLoader()),
                propertyTypeExtractor: new ConstructorExtractor([
                    new PhpStanExtractor(),
                    new ReflectionExtractor(),
                ]),
            ),
        ];

        $this->serializer = new SymfonySerializer(
            normalizers: $normalizers,
            encoders: $encoders
        );
    }

    /**
     * @param array<mixed> $context
     */
    public function serialize(mixed $payload, array $context = []): string
    {
        return $this->serializer->serialize($payload, 'json', $context);
    }

    /**
     * @template T of object
     *
     * @param class-string<T> $type
     *
     * @phpstan-return T
     */
    public function deserialize(string $payload, string $type): object
    {
        try {
            return $this->serializer->deserialize($payload, $type, 'json');
        } catch (NotNormalizableValueException $e) {
            $this->logger->error('Could not deserialize payload', [
                'exception' => $e,
                'unexpectedType' => $e->getCurrentType(),
                'path' => $e->getPath(),
            ]);

            throw $e;
        }
    }
}
