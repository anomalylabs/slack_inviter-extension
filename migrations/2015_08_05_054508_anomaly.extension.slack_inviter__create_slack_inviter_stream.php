<?php

use Illuminate\Database\Schema\Blueprint;
use Anomaly\Streams\Platform\Database\Migration\Migration;

class AnomalyExtensionSlackInviterCreateSlackInviterStream extends Migration
{
    /**
     * The stream definition.
     *
     * @var array
     */
    protected $stream = [
        'slug' => 'invites'
    ];

    /**
     * The stream assignments.
     *
     * @var array
     */
    protected $assignments = [
        'type_form_id',
        'email',
        'name',
        'status'
    ];
}
