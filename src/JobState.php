<?php

/*
 * This file is part of the Aureja package.
 *
 * (c) Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Aureja\JobQueue;

/**
 * @author Tadas Gliaubicas <tadcka89@gmail.com>
 *
 * @since 4/16/15 12:32 AM
 */
class JobState
{
    /**
     * State if job is inserted, but not yet ready to be started.
     */
    const STATE_NEW = 'new';

    /**
     * State if job is inserted, and might be started.
     */
    const STATE_PENDING = 'pending';

    /**
     * State if job was never started, and will never be started.
     */
    const STATE_CANCELED = 'canceled';

    /**
     * State if job was started and has not exited, yet.
     */
    const STATE_RUNNING = 'running';

    /**
     * State if job exists with a successful exit code.
     */
    const STATE_FINISHED = 'finished';

    /**
     * State if job exits with a non-successful exit code.
     */
    const STATE_FAILED = 'failed';
}
