<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend;

use Stovendo\Omnisend\Exception\InvalidArgumentException;
use Stovendo\Omnisend\Exception\ProductAlreadyExistsException;
use Stovendo\Omnisend\Model\Cart;
use Stovendo\Omnisend\Model\CartProduct;
use Stovendo\Omnisend\Model\CartUpdate;
use Stovendo\Omnisend\Model\Categories;
use Stovendo\Omnisend\Model\Category;
use Stovendo\Omnisend\Model\Contact;
use Stovendo\Omnisend\Model\NewContact;
use Stovendo\Omnisend\Model\Order;
use Stovendo\Omnisend\Model\Product;
use Stovendo\Omnisend\Model\Products;

interface OmnisendApi
{
    /**
     * Test connection to Omnisend API.
     */
    public function ping(): bool;

    public function createContact(NewContact $contact): Contact;

    public function getContactByEmail(string $email): ?Contact;

    public function replaceContact(Contact $contact): void;

    public function createCategory(Category $category): void;

    public function getCategory(string $category): ?Category;

    public function getCategories(int $offset = 0, int $limit = 100): Categories;

    public function upsertCategory(Category $category): void;

    public function replaceCategory(Category $category): void;

    public function deleteCategory(string $categoryId): void;

    public function getCart(string $cartId): ?Cart;

    public function createCart(Cart $cart): void;

    /**
     * Update cart. Use to update cart info - add products or update existing in cart products.
     */
    public function updateCart(Cart|CartUpdate $cart): void;

    public function addProductToCart(string $cartId, CartProduct $cartProduct): void;

    public function removeProductFromCart(string $cartId, string $cartProductId): void;

    public function createOrder(Order $order): void;

    public function getOrder(string $orderId): ?Order;

    public function replaceOrder(Order $order): void;

    public function upsertOrder(Order $order): void;

    public function getProduct(string $productId): ?Product;

    /**
     * @throws ProductAlreadyExistsException If product with the same ID already exists
     */
    public function createProduct(Product $product): void;

    public function replaceProduct(Product $product): void;

    public function deleteProduct(string $productId): void;

    public function updateProduct(Product $product): void;

    public function upsertProduct(Product $product): void;

    /**
     * @param int $limit Must not be greater than 250
     *
     * @throws InvalidArgumentException If limit is greater than 250
     *
     * @return Products<Product>
     */
    public function getProducts(int $offset = 0, int $limit = 250): Products;
}
