<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            [
                'name' => 'Other - Please contact me to discuss',
                'fee' => 0,
                'instructions' => 'Game Control will reach out to discuss your needs.',
                'additional_info_required' => 0,
                'is_active' => 1
            ],
            [
                'name' => 'Day Of - Any Method',
                'fee' => 0,
                'instructions' => 'Pay by any payment method when you arrive on game day.',
                'additional_info_required' => 0,
                'is_active' => 1
            ],
            [
                'name' => 'In Advance - Google Pay',
                'fee' => 0,
                'instructions' => 'Payment will be requested from the account provided.',
                'additional_info_required' => 1,
                'additional_info_instructions' => 'Please provide the email address or phone number attached to your Google Pay account.',
                'is_active' => 1
            ],
            [
                'name' => 'In Advance - Credit/Debit Card',
                'fee' => 2.0,
                'instructions' => 'Invoice will be sent via Square to your email as defined in your profile',
                'additional_info_required' => 0,
                'is_active' => 1
            ],
            [
                'name' => 'In Advance - Venmo',
                'fee' => 0,
                'instructions' => 'Payment will be requested from the account provided.',
                'additional_info_required' => 1,
                'additional_info_instructions' => 'Please provide your Venmo @username.',
                'is_active' => 1
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
