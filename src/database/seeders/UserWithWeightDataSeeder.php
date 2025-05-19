<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WeightLog;
use App\Models\WeightTarget;
use Illuminate\Support\Facades\Hash;

class UserWithWeightDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ダミーユーザーの作成
        $user = User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // 体重目標の設定
        WeightTarget::factory()->create([
            'user_id' => $user->id,
        ]);

        // 体重記録３５件の作成
        WeightLog::factory()->count(35)->create([
            'user_id' => $user->id,
        ]);
    }
}
