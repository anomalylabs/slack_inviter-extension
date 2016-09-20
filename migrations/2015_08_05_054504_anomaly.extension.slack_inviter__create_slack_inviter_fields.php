<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class AnomalyExtensionSlackInviterCreateSlackInviterFields
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 */
class AnomalyExtensionSlackInviterCreateSlackInviterFields extends Migration
{

    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'email'      => 'anomaly.field_type.email',
        'name'       => 'anomaly.field_type.text',
        'error'      => 'anomaly.field_type.text',
        'successful' => 'anomaly.field_type.boolean',
        'ip_address' => 'anomaly.field_type.text',
    ];

}
