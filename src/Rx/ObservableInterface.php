<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections\Rx;

use Closure;

/**
 * Defines a provider for push-based notification.
 */
interface ObservableInterface
{

    /**
     * Notifies the provider that an observer is to receive notifications.
     *
     * @param ObserverInterface $observer The object that is to receive notifications.
     *
     * @return boolean A reference to disposable that allows observers to stop receiving notifications before the provider has finished sending them.
     */
    public function subscribeObject(ObserverInterface $observer);

    /**
     * Notifies the provider that an observer is to receive notifications.
     *
     * @param Closure $onNext Provides the observer with new data.
     * @param Closure $onError Notifies the observer that the provider has experienced an error condition.
     * @param Closure $onCompleted Notifies the observer that the provider has finished sending push-based notifications.
     * 
     * @return boolean A reference to disposable that allows observers to stop receiving notifications before the provider has finished sending them.
     */
    public function subscribe(Closure $onNext, Closure $onError = null, Closure $onCompleted = null);
}
