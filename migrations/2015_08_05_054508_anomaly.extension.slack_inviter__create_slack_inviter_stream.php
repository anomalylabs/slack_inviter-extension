<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class AnomalyExtensionSlackInviterCreateSlackInviterStream
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class AnomalyExtensionSlackInviterCreateSlackInviterStream extends Migration
{

    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'invites',
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'email' => [
            'required' => true,
        ],
        'name'  => [
            'required' => true,
        ],
        'error',
        'successful',
        'ip_address',
    ];

}
