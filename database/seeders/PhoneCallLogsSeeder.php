<?php

namespace Database\Seeders;

use App\Models\PhoneCallLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhoneCallLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PhoneCallLog::factory()->create([
            'call_date' => '2024-01-01T09:30:00',
            'phone_number' => '+1234567890',
            'call_duration' => '5:15',
            'status' => 'Incoming',
        ]);

        PhoneCallLog::factory()->create([
            'call_date' => '2024-01-02T12:45:00',
            'phone_number' => '+9876543210',
            'call_duration' => '8:20',
            'status' => 'Outgoing',
        ]);

        // ... (add more records as needed)

        PhoneCallLog::factory()->count(498)->create(); 
    }
}
