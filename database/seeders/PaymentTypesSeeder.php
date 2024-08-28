<?php

namespace Database\Seeders;

use App\Models\PaymentCurrency;
use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_types')->delete();

        $data = [['name'=>'Income'], ['name'=>'Expenses']];
        foreach ($data as $paymentType){
            PaymentType::create($paymentType);
        }

        $data = [['name'=>'UAN'], ['name'=>'USD'], ['name'=>'EUR']];
        foreach ($data as $paymentCurrency){
            PaymentCurrency::create($paymentCurrency);
        }
    }
}
