<?php

declare(strict_types=1);

namespace App;

use Closure;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class CustomSerializer implements SerializerInterface
{
    private static array $dates = [
        'createdAt',
        'updatedAt',
    ];

    /**
     * {@inheritdoc}
     */
    public function deserialize($data, string $type, string $format, array $context = [])
    {
        return self::deserializing($data, $type, $context);
    }

    /**
     * Custom deserialize called static.
     *
     * @param mixed $data
     *
     * {@inheritdoc : deserialize}
     *
     * @return object|array
     */
    public static function deserializing($data, string $type, array $context = [])
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer($classMetadataFactory, new CamelCaseToSnakeCaseNameConverter());

        $serializer = new Serializer(
            [$normalizer],
            [new JsonEncoder()]
        );

        return $serializer->deserialize($data, $type, 'json', $context);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize($data, string $format, array $context = []): string
    {
        return self::serializing($data, $context);
    }

    /**
     * Custom serialize called static.
     *
     * @param mixed $data
     *
     * {@inheritdoc : serialize}
     */
    public static function serializing($data, array $context = []): string
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $normalizer = new ObjectNormalizer(
            $classMetadataFactory,
            new CamelCaseToSnakeCaseNameConverter(),
            null,
            null,
            null,
            null,
            self::serializeDefaultContext()
        );

        $serializer = new Serializer(
            [$normalizer],
            [new JsonEncoder()]
        );

        return $serializer->serialize($data, 'json', $context);
    }

    /**
     * Default context for serialize.
     */
    protected static function serializeDefaultContext(): array
    {
        return [
            // return only keys with values.
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true,
            // break children items into first repetition.
            AbstractObjectNormalizer::MAX_DEPTH_HANDLER => fn ($obj): int => $obj->id,
            // avoid circular reference on relationships.
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => fn ($obj): int => $obj->getId(),
            // call normalizers for typed entries.
            AbstractNormalizer::CALLBACKS => array_merge(
                (array) array_combine(
                    self::$dates,
                    array_fill(0, count(self::$dates), self::callbackDate())
                ),
            ),
        ];
    }

    /**
     * Callback object to normatize date objects into values. Rules by attribute.
     */
    private static function callbackDate(): Closure
    {
        return function ($value) {
            if ($value instanceof \DateTime) {
                return $value->format(\DateTime::ISO8601);
            }

            if ($value instanceof \DateTimeImmutable) {
                return $value->format(\DateTime::ISO8601);
            }

            if (is_string($value)) {
                return new \DateTime((string) strtotime($value));
            }

            return $value;
        };
    }
}
