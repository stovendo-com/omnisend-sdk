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

namespace Stovendo\Omnisend\Trait;

use Stovendo\Omnisend\Exception\CategoryNotFoundException;
use Stovendo\Omnisend\Exception\InvalidArgumentException;
use Stovendo\Omnisend\Model\Categories;
use Stovendo\Omnisend\Model\Category;

trait CategoryApiTrait
{
    public function getCategory(string $categoryId): ?Category
    {
        try {
            return $this->get(self::ENDPOINT_CATEGORIES.'/'.$categoryId, Category::class);
        } catch (CategoryNotFoundException) {
            return null;
        }
    }

    public function getCategories(int $offset = 0, int $limit = 250): Categories
    {
        if ($limit > 250) {
            throw new InvalidArgumentException('Limit cannot be greater than 250');
        }

        return $this->get(self::ENDPOINT_CATEGORIES, Categories::class);
    }

    public function createCategory(Category $category): void
    {
        $this->post(self::ENDPOINT_CATEGORIES, $category);
    }

    public function replaceCategory(Category $category): void
    {
        $this->put(self::ENDPOINT_CATEGORIES.'/'.$category->categoryID, $category);
    }

    public function upsertCategory(Category $category): void
    {
        try {
            $this->replaceCategory($category);
        } catch (CategoryNotFoundException) {
            $this->createCategory($category);
        }
    }

    public function deleteCategory(string $categoryId): void
    {
        try {
            $this->delete(self::ENDPOINT_CATEGORIES, $categoryId);
        } catch (CategoryNotFoundException) {
            // if it's not there, ignore it
        }
    }
}
