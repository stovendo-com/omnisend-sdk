<?php

/**
 * (c) NFQ Technologies UAB <info@nfq.com>
 */

declare(strict_types=1);

namespace Stovendo\Omnisend\Trait;

use Stovendo\Omnisend\Model\CustomEvent;

trait CustomEventApiTrait
{
    private const ENDPOINT_EVENTS = '/events';

    public function triggerCustomEvent(CustomEvent $event): void
    {
        $this->post(endpoint: self::ENDPOINT_EVENTS, payload: $event);
    }
}
