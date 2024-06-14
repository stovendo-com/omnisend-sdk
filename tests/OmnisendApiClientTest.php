<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Tests;

use DateTimeImmutable;
use Http\Client\Common\PluginClient;
use Http\Client\Plugin\Vcr\NamingStrategy\NamingStrategyInterface;
use Http\Client\Plugin\Vcr\Recorder\FilesystemRecorder;
use Http\Client\Plugin\Vcr\RecordPlugin;
use Http\Client\Plugin\Vcr\ReplayPlugin;
use Http\Discovery\Psr18Client;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Stovendo\Omnisend\Exception\CategoryAlreadyExistsException;
use Stovendo\Omnisend\Exception\CategoryNotFoundException;
use Stovendo\Omnisend\Exception\ProductAlreadyExistsException;
use Stovendo\Omnisend\Exception\ProductAlreadyInCartException;
use Stovendo\Omnisend\Exception\ProductNotFoundException;
use Stovendo\Omnisend\Model\Cart;
use Stovendo\Omnisend\Model\Category;
use Stovendo\Omnisend\Model\Contact;
use Stovendo\Omnisend\Model\ContactIdentifierChannel;
use Stovendo\Omnisend\Model\Order;
use Stovendo\Omnisend\Model\Product;
use Stovendo\Omnisend\OmnisendApi;
use Stovendo\Omnisend\OmnisendApiClient;
use Stovendo\Omnisend\Serializer;
use Stovendo\Omnisend\Test\OmnisendFixtures;

/**
 * To record a new response, use .env.test.local and set OMNISEND_TEST_APIKEY there.
 */
#[CoversClass(OmnisendApiClient::class)]
class OmnisendApiClientTest extends TestCase
{
    public function test_create_product(): void
    {
        $product = OmnisendFixtures::createProduct();
        $product->productID = 'product-new';
        $this->createClient()->createProduct($product);
        $this->addToAssertionCount(1);
    }

    public function test_create_already_existing_product_throws_exception(): void
    {
        $this->expectException(ProductAlreadyExistsException::class);
        $product = OmnisendFixtures::createProduct();
        $product->productID = 'product-new';

        $this->createClient()->createProduct($product);
        $this->addToAssertionCount(1);
    }

    public function test_get_product(): void
    {
        $product = $this->createClient()->getProduct('product-new');

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('product-new', $product->productID);
    }

    public function test_get_product_that_does_not_exists_returns_null(): void
    {
        $product = $this->createClient()->getProduct('product-404');
        $this->assertNull($product);
    }

    public function test_delete_product(): void
    {
        $this->createClient()->deleteProduct('product-new');
        $this->addToAssertionCount(1);
    }

    public function test_delete_not_existing_product_does_not_throws_exception(): void
    {
        $this->createClient()->deleteProduct('product-404');
        $this->addToAssertionCount(1);
    }

    public function test_replace_product(): void
    {
        $product = OmnisendFixtures::createProduct();
        $product->productID = 'product-new';
        $product->title = 'Some new title';

        $this->createClient()->replaceProduct($product);
        $this->addToAssertionCount(1);
    }

    public function test_replace_not_existing_product_throws_exception(): void
    {
        $this->expectException(ProductNotFoundException::class);

        $product = OmnisendFixtures::createProduct();
        $product->productID = 'product-404';

        $this->createClient()->replaceProduct($product);
        $this->addToAssertionCount(1);
    }

    public function test_create_category(): void
    {
        $category = OmnisendFixtures::createCategory();
        $category->categoryID = 'category-2';

        $this->createClient()->createCategory($category);
        $this->addToAssertionCount(1);
    }

    public function test_create_already_existing_category_throws_exception(): void
    {
        $this->expectException(CategoryAlreadyExistsException::class);
        $category = OmnisendFixtures::createCategory();
        $this->createClient()->createCategory($category);
    }

    public function test_get_category(): void
    {
        $category = $this->createClient()->getCategory('category-1');

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals('category-1', $category->categoryID);
        $this->assertEquals('Category title', $category->title);
    }

    public function test_get_categories(): void
    {
        $categories = $this->createClient()->getCategories();
        $this->assertCount(1, $categories);
        $this->assertArrayHasKey(0, $categories);
        $this->assertInstanceOf(Category::class, $categories[0]);
    }

    public function test_get_category_that_does_not_exists_returns_null(): void
    {
        $category = $this->createClient()->getCategory('category-404');
        $this->assertNull($category);
    }

    public function test_replace_category(): void
    {
        $category = OmnisendFixtures::createCategory();
        $this->createClient()->replaceCategory($category);
        $this->addToAssertionCount(1);
    }

    public function test_replace_not_existing_category_throws_exception(): void
    {
        $this->expectException(CategoryNotFoundException::class);
        $category = OmnisendFixtures::createCategory();
        $category->categoryID = 'category-404';
        $this->createClient()->replaceCategory($category);
    }

    public function test_delete_category(): void
    {
        $this->createClient()->deleteCategory('category-1');
        $this->addToAssertionCount(1);
    }

    public function test_delete_not_existing_category_does_not_throw_exception(): void
    {
        $this->createClient()->deleteCategory('category-404');
        $this->addToAssertionCount(1);
    }

    public function test_create_contact(): void
    {
        $contact = OmnisendFixtures::createNewContact();
        $contact = $this->createClient()->createContact($contact);

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertSame('663cf8de1f539fef85c321f9', $contact->contactID);
        $this->assertSame('John', $contact->firstName);
        $this->assertSame('Doe', $contact->lastName);
    }

    public function test_create_cart(): void
    {
        $cart = OmnisendFixtures::createCart();
        $this->createClient()->createCart($cart);
        $this->addToAssertionCount(1);
    }

    public function test_update_cart(): void
    {
        $cart = OmnisendFixtures::createCart();
        $this->createClient()->updateCart($cart);
        $this->addToAssertionCount(1);
    }

    public function test_remove_product_from_cart(): void
    {
        $this->createClient()->removeProductFromCart('cart-1', 'cart-product-1');
        $this->addToAssertionCount(1);
    }

    public function test_add_product_to_cart(): void
    {
        $cartProduct = OmnisendFixtures::createCartProduct();

        $this->createClient()->addProductToCart('cart-1', $cartProduct);
        $this->addToAssertionCount(1);
    }

    public function test_get_cart(): void
    {
        $expectedCart = OmnisendFixtures::createCart();
        $expectedCart->cartID = 'cart-3';

        $client = $this->createClient();
        $client->createCart($expectedCart);
        $cart = $client->getCart('cart-3');

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertNotNull($cart->contactID);
        $this->assertArrayHasKey(0, $cart->products);
        $this->assertNull($cart->products[0]->currency);
        $this->assertInstanceOf(DateTimeImmutable::class, $cart->createdAt);
        $this->assertInstanceOf(DateTimeImmutable::class, $cart->updatedAt);
    }

    public function test_get_not_existing_cart_returns_null(): void
    {
        $cart = $this->createClient()->getCart('cart-125343789');
        $this->assertNull($cart);
    }

    public function test_add_product_that_is_already_in_cart_throws_exception(): void
    {
        $this->expectException(ProductAlreadyInCartException::class);
        $cartProduct = OmnisendFixtures::createCartProduct();

        $this->createClient()->addProductToCart('cart-1', $cartProduct);
        $this->addToAssertionCount(1);
    }

    public function test_get_products(): void
    {
        $products = $this->createClient()->getProducts(1, 100);
        $this->assertNotEmpty($products);
        $this->assertContainsOnlyInstancesOf(Product::class, $products);
    }

    public function test_update_product(): void
    {
        $this->createClient()->updateProduct(OmnisendFixtures::createProduct());
        $this->addToAssertionCount(1);
    }

    public function test_update_product_that_does_not_exists_throws_exception(): void
    {
        $this->expectException(ProductNotFoundException::class);

        $product = OmnisendFixtures::createProduct();
        $product->productID = 'product-404';
        $this->createClient()->updateProduct($product);
        $this->addToAssertionCount(1);
    }

    public function test_get_contact_by_email(): void
    {
        $contact = $this->createClient()->getContactByEmail('john.doe@example.com');
        $this->assertInstanceOf(Contact::class, $contact);
    }

    public function test_update_contact(): void
    {
        $client = $this->createClient();
        $contact = $client->getContactByEmail('john.doe@example.com');
        $this->assertInstanceOf(Contact::class, $contact);

        $contact->firstName = 'Jane';
        $contact->lastName = 'Doe';
        $client->replaceContact($contact);
    }

    public function test_change_email_subscription_status(): void
    {
        $client = $this->createClient();
        $contact = $client->getContactByEmail('john.doe@example.com');
        $this->assertInstanceOf(Contact::class, $contact);

        $contact->setEmailSubscriptionStatus(ContactIdentifierChannel::STATUS_UNSUBSCRIBED);
        $client->replaceContact($contact);
    }

    public function test_create_order(): void
    {
        $this->createClient()->createOrder(OmnisendFixtures::createOrder());
        $this->addToAssertionCount(1);
    }

    public function test_get_order(): void
    {
        $order = $this->createClient()->getOrder('order-1');
        $this->assertInstanceOf(Order::class, $order);
    }

    public function test_get_order_that_does_not_exists_throws_exception(): void
    {
        $order = $this->createClient()->getOrder('order-404');
        $this->assertNull($order);
    }

    public function test_upsert_existing_order(): void
    {
        $order = OmnisendFixtures::createOrder();
        $order->orderID = 'order-1';

        $this->createClient()->upsertOrder($order);
        $this->addToAssertionCount(1);
    }

    public function test_upsert_new_order(): void
    {
        $order = OmnisendFixtures::createOrder();
        $order->orderID = 'order-2';

        $this->createClient()->upsertOrder($order);
        $this->addToAssertionCount(1);
    }

    private function createClient(): OmnisendApi
    {
        $apikey = $_ENV['OMNISEND_TEST_APIKEY'] ?? 'none';
        $recorder = new FilesystemRecorder(__DIR__.'/recordings', null, [
            '#(CF-Cache-Status|(X|x)\-.*|CF-RAY|Report-To|NEL|alt-svc|set-cookie|strict-transport-security):.*\n#i' => '',
        ]);

        // this is a custom naming strategy that names the recordings based on the test method name.
        $namingStrategy = new class($this->name()) implements NamingStrategyInterface {
            private int $count = 0;

            public function __construct(private string $prefix)
            {
            }

            public function name(RequestInterface $request): string
            {
                $suffix = $this->count === 0 ? '' : '-'.$this->count;
                ++$this->count;

                return $this->prefix.$suffix;
            }
        };

        $psr18Client = new Psr18Client();
        $record = new RecordPlugin($namingStrategy, $recorder);
        $replay = new ReplayPlugin(clone $namingStrategy, $recorder, false);
        $httpClient = new PluginClient($psr18Client, [$replay, $record]);

        return new OmnisendApiClient(
            apikey: $apikey,
            httpClient: $httpClient,
            psrFactory: $psr18Client,
            serializer: new Serializer(),
        );
    }
}
