<?php

namespace Database\Factories;

use App\Models\WeightLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class WeightLogFactory extends Factory
{
    protected $model = WeightLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $date = Carbon::now()->subDays(rand(0, 34));

        return [
            // userはseederで渡すため設定なし
            // null値のダミーデータも入れるために確率を出す
            'date' => $date->format('Y-m-d'),
            'weight' => $this->faker->randomFloat(1, 50, 100), 
            'calories' => $this->faker->optional(0.7)->numberBetween(1000, 3000), 
            'exercise_time' => $this->faker->optional(0.5)->time('H:i:s'), 
            'exercise_content' => $this->faker->optional(0.5)->paragraph(1), 
        ];
    }
}
