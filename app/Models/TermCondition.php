<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermCondition extends Model
{
    use HasFactory;
    protected $table = 'term_conditions';
    protected $fillable = [
        'tenant_reg_term',
        'services_term',
        'pet_form_term',
        'maintenance_in_absentia_term',
        'automated_guest_access_term',
        'access_key_card_term',
        'vehicle_form_term',
        'housekeeping_form_term',
    ];
}
