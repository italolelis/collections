<?php

// Copyright (c) Lellys Informática. All rights reserved. See License.txt in the project root for license information.
namespace Easy\Collections\Rx;

use Closure;

class CallbackObserver implements ObserverInterface
{
    protected $onCompleted;
    protected $onError;
    protected $onNext;

    public function __construct(Closure $onCompleted, Closure $onError, Closure $onNext)
    {
        $this->onCompleted = $onCompleted;
        $this->onError = $onError;
        $this->onNext = $onNext;
    }

    public function onCompleted()
    {
        $this->{onCompleted}();
        return $this;
    }

    public function onError($error)
    {
        $this->{onError}($error);
        return $this;
    }

    public function onNext($value)
    {
        $this->{onNext}($value);
        return $this;
    }
}
