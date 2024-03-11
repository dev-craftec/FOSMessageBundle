<?php

declare(strict_types=1);

namespace FOS\MessageBundle\Tests\EntityManager;

use FOS\MessageBundle\EntityManager\ThreadManager;
use FOS\MessageBundle\Model\ThreadInterface;

class TestThreadManager extends ThreadManager
{
    /**
     * Empty constructor.
     */
    public function __construct()
    {
    }

    /**
     * Make the function public.
     *
     * @param ThreadInterface $thread
     */
    public function doCreatedByAndAt(ThreadInterface $thread)
    {
        return parent::doCreatedByAndAt($thread);
    }
}