<?php

namespace App\Extensions;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Session\DatabaseSessionHandler as BaseDatabaseSessionHandler;

class DatabaseSessionHandler extends BaseDatabaseSessionHandler
{
    protected function addUserInformation(&$payload): DatabaseSessionHandler|static
    {
        if ($this->container->bound(Factory::class)) {
            $payload['user_id'] = $this->userId();
            $payload['customer_id'] = $this->customerId();
        }

        return $this;
    }

    protected function userId()
    {
        $user = $this->getUser('web');

        return $user ? $user->id : null;
    }

    protected function customerId()
    {
        $user = $this->getUser('customer');

        return $user ? $user->id : null;
    }

    protected function getUser($guard)
    {
        return $this->container->make(Factory::class)->guard($guard)->user();
    }
}
