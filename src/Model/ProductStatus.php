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

use JsonSerializable;

enum ProductStatus: string implements JsonSerializable
{
    case IN_STOCK = 'inStock';
    case OUT_OF_STOCK = 'outOfStock';
    case NOT_AVAILABLE = 'notAvailable';

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
