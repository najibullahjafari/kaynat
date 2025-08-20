<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\admin_login as AdminLogin;
use App\Models\TechnologyItem;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Test User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
        ]);
        $technologies = [
            [
                'name' => 'Kaynat GPS Device X1',
                'type' => 'Hardware',
                'description' => 'Rugged, waterproof GPS tracker with long battery life and real-time location updates.',
                'image' => 'tech/hardware-x1.png',
                'specifications' => [
                    'IP67 Waterproof',
                    'Battery: 10,000mAh',
                    '4G LTE Connectivity',
                    'Real-time Tracking',
                    'Geo-fencing Support',
                ],
            ],
            [
                'name' => 'Kaynat SIM Connectivity',
                'type' => 'Connectivity',
                'description' => 'Multi-network SIM for seamless GPS data transmission across regions.',
                'image' => 'tech/sim-connectivity.png',
                'specifications' => [
                    'Global Roaming',
                    'Supports 2G/3G/4G',
                    'Encrypted Data Transfer',
                    'Low Latency',
                ],
            ],
            [
                'name' => 'Kaynat Web Dashboard',
                'type' => 'Software',
                'description' => 'User-friendly dashboard for monitoring, reporting, and managing all your GPS devices.',
                'image' => 'tech/web-dashboard.png',
                'specifications' => [
                    'Live Map View',
                    'Custom Alerts',
                    'Analytics & Reports',
                    'Multi-user Access',
                ],
            ],
            [
                'name' => 'Bluetooth Beacon',
                'type' => 'Hardware',
                'description' => 'Short-range Bluetooth beacon for indoor asset tracking and proximity alerts.',
                'image' => 'tech/bluetooth-beacon.png',
                'specifications' => [
                    'BLE 5.0',
                    'Battery: 2 years',
                    'Range: 100m',
                    'Easy Installation',
                ],
            ],
        ];
        foreach ($technologies as $tech) {
            TechnologyItem::create($tech);
        }
    }
}
