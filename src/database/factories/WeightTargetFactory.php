<?php

namespace Database\Factories;

use App\Models\WeightTarget;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeightTargetFactory extends Factory
{
    protected $model = WeightTarget::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // userはseederで渡すため設定なし
            'target_weight' => $this->faker->randomFloat(1, 45, 80),
        ];
    }
}
