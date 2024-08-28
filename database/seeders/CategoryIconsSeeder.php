<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\CategoryIcon;
use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryIconsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //MusicalNoteIcon, PaintBrushIcon, PhoneIcon

        $icons = [
            ['icon' => 'AcademicCapIcon', 'name' => 'Education', 'color' => '#047cb6'],
            ['icon' => 'CreditCardIcon', 'name' => 'Leisure', 'color' => '#8ecd62'],
            ['icon' => 'HeartIcon', 'name' => 'Health', 'color' => '#bb3429'],
            ['icon' => 'GiftIcon', 'name' => 'Gifts', 'color' => '#6075de'],
            ['icon' => 'HomeIcon', 'name' => 'Home', 'color' => '#e4d953'],
            ['icon' => 'ShoppingBagIcon', 'name' => 'Shopping', 'color' => '#149c90'],
            ['icon' => 'ShoppingCartIcon', 'name' => 'Groceries', 'color' => '#1b34b4'],
            ['icon' => 'TicketIcon', 'name' => 'Tickets', 'color' => '#de53cb']
        ];

        foreach ($icons as $icon){
            $iconObj = CategoryIcon::create($icon);

            $iconObj->categories()->create([
                'name'=>$icon['name']
            ]);

        }

    }
}
