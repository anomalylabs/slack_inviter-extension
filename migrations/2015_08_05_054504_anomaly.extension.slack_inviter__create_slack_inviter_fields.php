<?php

use Illuminate\Database\Schema\Blueprint;
use Anomaly\Streams\Platform\Database\Migration\Migration;

class AnomalyExtensionSlackInviterCreateSlackInviterFields extends Migration
{
    /**
     * The addon fields.
     *
     * @var array
     */
    protected $fields = [
        'type_form_id' => 'anomaly.field_type.integer',
        'email'        => 'anomaly.field_type.email',
        'name'         => 'anomaly.field_type.text',
        'status'       => 'anomaly.field_type.text'
    ];
}
