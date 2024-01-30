<?php

namespace Database\Factories;

use App\Models\PhoneCallLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhoneCallLog>
 */
class PhoneCallLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = PhoneCallLog::class;

    public function definition()
    {
        return [
            'call_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'phone_number' => $this->faker->phoneNumber,
            'call_duration' => $this->faker->time(),
            'status' => $this->faker->randomElement(['Incoming', 'Outgoing', 'Missed']),
        ];
    }
}
