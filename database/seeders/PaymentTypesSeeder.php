<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [['name'=>'UAN'], ['name'=>'USD'], ['name'=>'EUR']];
        foreach ($data as $paymentType){
            PaymentType::create($paymentType);
        }
    }
}
