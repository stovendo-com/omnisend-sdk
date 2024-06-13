<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Test;

use DateTimeImmutable;
use Stovendo\Omnisend\Model\Cart;
use Stovendo\Omnisend\Model\CartProduct;
use Stovendo\Omnisend\Model\Category;
use Stovendo\Omnisend\Model\ContactIdentifier;
use Stovendo\Omnisend\Model\ContactIdentifierChannel;
use Stovendo\Omnisend\Model\NewContact;
use Stovendo\Omnisend\Model\Order;
use Stovendo\Omnisend\Model\OrderItemProduct;
use Stovendo\Omnisend\Model\Product;
use Stovendo\Omnisend\Model\ProductStatus;
use Stovendo\Omnisend\Model\ProductVariant;

class OmnisendFixtures
{
    public static function createProduct(): Product
    {
        $defaultVariant = new ProductVariant(
            variantID: 'product-1-1',
            title: 'Apple Juice in a bottle',
            status: ProductStatus::IN_STOCK,
            price: 1399,
            sku: 'apple-1',
            oldPrice: 1299,
            productUrl: 'https://example.com/product',
            imageID: 'image-id'
        );

        return new Product(
            productID: 'product-1',
            title: 'Apple Juice',
            status: ProductStatus::IN_STOCK,
            description: 'Product description',
            currency: 'EUR',
            updatedAt: new DateTimeImmutable('2021-01-01T00:00:00Z'),
            productUrl: 'https://example.com/product',
            vendor: 'Vendor name',
            type: 'product-type',
            createdAt: new DateTimeImmutable('2021-01-01T00:00:00Z'),
            tags: ['tag1', 'tag2'],
            categoryIDs: ['category1', 'category2'],
            images: [],
            variants: [
                $defaultVariant,
            ]
        );
    }

    public static function createCategory(): Category
    {
        return new Category(
            categoryID: 'category-1',
            title: 'Category title',
        );
    }

    public static function createNewContact(): NewContact
    {
        return new NewContact(
            identifiers: [
                ContactIdentifier::email('john.doe@example.com', ContactIdentifierChannel::STATUS_SUBSCRIBED),
            ],
            firstName: 'John',
            lastName: 'Doe',
            tags: ['tag1', 'tag2'],
            country: 'Lithuania',
            countryCode: 'LT',
            state: 'Vilnius',
            city: 'Vilnius',
            address: 'Street 1',
            postalCode: 'LT-12345',
            birthdate: new DateTimeImmutable('1990-01-01'),
            sendWelcomeEmail: true,
        );
    }

    public static function createCart(): Cart
    {
        return new Cart(
            cartID: 'cart-1',
            currency: 'EUR',
            cartSum: 1560,
            email: 'john@doe.example.com',
            products: [
                self::createCartProduct(),
            ],
        );
    }

    public static function createCartProduct(): CartProduct
    {
        return new CartProduct(
            cartProductID: 'cart-product-1',
            productID: 'product-1',
            variantID: 'product-1-1',
            title: 'Apple Juice in a bottle',
            price: 1560,
            quantity: 1,
            currency: 'EUR',
        );
    }

    public static function createOrder(): Order
    {
        return new Order(
            orderID: 'order-1',
            email: 'john.doe@example.com',
            orderNumber: 10001,
            currency: 'EUR',
            orderSum: 3120,
            createdAt: new DateTimeImmutable('2021-01-01T00:00:00Z'),
            paymentStatus: 'paid',
            fulfillmentStatus: 'fulfilled',
            orderItems: [
                new OrderItemProduct(
                    productID: 'product-1',
                    sku: 'apple-1',
                    variantID: 'product-1-1',
                    variantTitle: 'Apple Juice in a bottle',
                    title: 'Apple Juice in a bottle',
                    price: 1560,
                    quantity: 1,
                ),
                new OrderItemProduct(
                    productID: 'product-2',
                    sku: 'banana-1',
                    variantID: 'product-2-1',
                    variantTitle: 'Banana Juice in a bottle',
                    title: 'Banana Juice in a bottle',
                    price: 1560,
                    quantity: 1,
                ),
            ],
        );
    }
}
