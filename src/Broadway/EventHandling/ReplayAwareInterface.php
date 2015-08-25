<?php

/*
 * This file is part of the broadway/broadway package.
 *
 * (c) Qandidate.com <opensource@qandidate.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Broadway\EventHandling;

use Broadway\Domain\DomainEventStreamInterface;

/**
 * Publishes events to the subscribed event listeners.
 */
interface ReplayAwareInterface
{
    /**
     * Invoked when a replay is started.
     */
    public function beforeReplay();

    /**
     * Invoked when a replay has finished.
     */
    public function afterReplay();

    /**
     * Invoked when a replay has failed due to an exception.
     *
     * @param \Exception $cause The exception that stopped the replay;
     */
    public function onReplayFailed(\Exception $cause = null);
}
