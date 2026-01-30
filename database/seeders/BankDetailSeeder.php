<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BankDetail;

class BankDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'bank_name'       => 'Dutch-Bangla Bank Ltd',
                'branch_name'     => 'Motijheel Branch',
                'account_name'    => 'Samim Enterprise',
                'account_number'  => '12345678901',
                'routing_number'  => '090274658',
                'remarks'         => 'Primary business account',
            ],
            [
                'bank_name'       => 'BRAC Bank Ltd',
                'branch_name'     => 'Gulshan Branch',
                'account_name'    => 'Samim Enterprise',
                'account_number'  => '22334455667',
                'routing_number'  => '060121456',
                'remarks'         => 'Online transactions',
            ],
            [
                'bank_name'       => 'Islami Bank Bangladesh Ltd',
                'branch_name'     => 'Mirpur Branch',
                'account_name'    => 'Samim Enterprise',
                'account_number'  => '33445566778',
                'routing_number'  => '125263987',
                'remarks'         => 'Savings account',
            ],
            [
                'bank_name'       => 'Sonali Bank Ltd',
                'branch_name'     => 'Dhanmondi Branch',
                'account_name'    => 'Samim Enterprise',
                'account_number'  => '44556677889',
                'routing_number'  => '200263548',
                'remarks'         => 'Government payments',
            ],
            [
                'bank_name'       => 'City Bank Ltd',
                'branch_name'     => 'Uttara Branch',
                'account_name'    => 'Samim Enterprise',
                'account_number'  => '55667788990',
                'routing_number'  => '225264111',
                'remarks'         => 'Card & POS settlements',
            ],
        ];

        foreach ($banks as $bank) {
            BankDetail::create($bank);
        }
    }
}
