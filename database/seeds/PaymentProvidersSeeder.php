<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentProvidersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table((new \App\PaymentProvider())->getTable())
            ->insert([
                [
                    'name' => 'paypal',
                    'label' => 'PayPal',
                    'types' => json_encode([
                        'deposit',
                        'withdraw'
                    ]),
                    'additional_data' => json_encode([
                        [
                            'name' => 'username',
                            'label' => 'User name',
                            'type' => 'text',
                            'required' => true
                        ],
                        [
                            'name' => 'password',
                            'label' => 'Password',
                            'type' => 'password',
                            'required' => true
                        ]
                    ])
                ],
                [
                    'name' => 'cashlib',
                    'label' => 'Cashlib',
                    'types' => json_encode([
                        'deposit'
                    ]),
                    'additional_data' => json_encode([
                        [
                            'name' => 'voucher_code',
                            'label' => 'Voucher Code',
                            'type' => 'text',
                            'required' => true
                        ]
                    ])
                ],
                [
                    'name' => 'visa',
                    'label' => 'VISA',
                    'types' => json_encode([
                        'deposit',
                        'withdraw'
                    ]),
                    'additional_data' => json_encode([
                        [
                            'name' => 'card_number',
                            'label' => 'card_number',
                            'type' => 'text',
                            'required' => true
                        ],
                        [
                            'name' => 'cvv',
                            'label' => 'CVV',
                            'type' => 'text',
                            'required' => true
                        ],
                        [
                            'name' => 'cardholder',
                            'label' => 'Card Holder Name',
                            'type' => 'text',
                            'required' => true
                        ]
                    ])
                ],
                [
                    'name' => 'entercash',
                    'label' => 'Bank Withdrawals',
                    'types' => json_encode([
                        'withdraw'
                    ]),
                    'additional_data' => json_encode([
                        [
                            'name' => 'iban',
                            'label' => 'IBAN',
                            'type' => 'text',
                            'required' => true
                        ],
                        [
                            'name' => 'bic',
                            'label' => 'Swift/BIN',
                            'type' => 'text',
                            'required' => true
                        ]
                    ])
                ]
            ]);
    }
}
