<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections\Rx;

/**
 * Provides a mechanism for receiving push-based notifications.
 */
interface ObserverInterface
{

    /**
     * Provides the observer with new data.
     *
     * @param mixed $value The current notification information.
     */
    public function onNext($value);

    /**
     * Notifies the observer that the provider has experienced an error condition.
     *
     * @param mixed $error An object that provides additional information about the error.
     */
    public function onError($error);

    /**
     * Notifies the observer that the provider has finished sending push-based notifications.
     *
     * @param Closure $p The current notification information.
     */
    public function onCompleted();
}
