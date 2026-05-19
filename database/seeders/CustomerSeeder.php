<?php

namespace Database\Seeders;

use App\Models\user;
use Illuminate\Database\Seeder;

class userSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['Aarav Sharma', 'aarav.sharma@example.test', 'Mumbai'],
            ['Ananya Iyer', 'ananya.iyer@example.test', 'Chennai'],
            ['Rohan Gupta', 'rohan.gupta@example.test', 'Delhi'],
            ['Priya Menon', 'priya.menon@example.test', 'Kochi'],
            ['Vikram Rao', 'vikram.rao@example.test', 'Hyderabad'],
            ['Neha Kapoor', 'neha.kapoor@example.test', 'Pune'],
            ['Ishaan Das', 'ishaan.das@example.test', 'Kolkata'],
            ['Sara Khan', 'sara.khan@example.test', 'Bangalore'],
            ['Karan Patel', 'karan.patel@example.test', 'Ahmedabad'],
            ['Maya Nair', 'maya.nair@example.test', 'Kochi'],
            ['Dev Mehta', 'dev.mehta@example.test', 'Jaipur'],
            ['Tara Sen', 'tara.sen@example.test', 'Guwahati'],
            ['Nikhil Bansal', 'nikhil.bansal@example.test', 'Lucknow'],
            ['Pooja Kulkarni', 'pooja.kulkarni@example.test', 'Pune'],
            ['Aditya Bose', 'aditya.bose@example.test', 'Kolkata'],
        ];

        foreach ($users as $index => [$name, $email, $city]) {
            user::updateOrCreate(['email' => $email], [
                'name' => $name,
                'phone' => '+91 9' . str_pad((string) (800000000 + $index * 7311), 9, '0', STR_PAD_LEFT),
                'address' => ($index + 11) . ', Logistics Park Road, ' . $city,
                'city' => $city,
                'status' => $index % 6 === 0 ? 'inactive' : 'active',
                'notes' => 'Preferred delivery window: business hours.',
            ]);
        }
    }
}
