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

namespace Stovendo\Omnisend\Model;

class ProductImage
{
    /**
     * @param array<string> $variantIDs
     */
    public function __construct(
        public string $imageID,
        public ?string $url,
        public ?bool $isDefault = false,
        public array $variantIDs = []
    ) {
    }
}
