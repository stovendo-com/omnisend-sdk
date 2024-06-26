<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Trait;

use Stovendo\Omnisend\Exception\InvalidArgumentException;
use Stovendo\Omnisend\Exception\ProductNotFoundException;
use Stovendo\Omnisend\Model\Product;
use Stovendo\Omnisend\Model\Products;

trait ProductApiTrait
{
    private const ENDPOINT_PRODUCTS = '/products';

    public function getProduct(string $productId): ?Product
    {
        try {
            return $this->get(self::ENDPOINT_PRODUCTS.'/'.$productId, Product::class);
        } catch (ProductNotFoundException) {
            return null;
        }
    }

    public function createProduct(Product $product): void
    {
        $this->post(self::ENDPOINT_PRODUCTS, $product);
    }

    public function replaceProduct(Product $product): void
    {
        $this->put(self::ENDPOINT_PRODUCTS.'/'.$product->productID, $product);
    }

    public function deleteProduct(string $productId): void
    {
        try {
            $this->delete(self::ENDPOINT_PRODUCTS, $productId);
        } catch (ProductNotFoundException) {
            // if it's not there, ignore it
        }
    }

    public function updateProduct(Product $product): void
    {
        $this->put(self::ENDPOINT_PRODUCTS.'/'.$product->productID, $product);
    }

    public function upsertProduct(Product $product): void
    {
        try {
            $this->updateProduct($product);
        } catch (ProductNotFoundException) {
            $this->createProduct($product);
        }
    }

    public function getProducts(int $offset = 0, int $limit = 250): Products
    {
        if ($limit > 250) {
            throw new InvalidArgumentException('Limit cannot be greater than 250');
        }

        return $this->get(self::ENDPOINT_PRODUCTS, Products::class, ['offset' => $offset, 'limit' => $limit]);
    }
}
