<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    public function run()
    {
        AboutUs::create([
            'title' => 'About Cheap Laos Train',
            'subtitle' => 'Your trusted partner for comfortable and affordable train travel across Laos',
            'content' => '<p>Welcome to Cheap Laos Train, your premier destination for affordable and comfortable train travel throughout Laos. We are dedicated to making train travel accessible to everyone, offering competitive prices without compromising on quality and safety.</p><p>Our mission is to connect people, places, and cultures through reliable train services that showcase the beautiful landscapes of Laos. Whether you\'re a local commuter or an international traveler, we provide seamless booking experiences and exceptional customer service.</p>',
            'mission_title' => 'Our Mission',
            'mission_content' => 'To provide safe, reliable, and affordable train travel that connects communities and creates unforgettable journeys across Laos.',
            'vision_title' => 'Our Vision',
            'vision_content' => 'To be the leading train booking platform in Laos, making train travel accessible and enjoyable for everyone.',
            'values_title' => 'Our Values',
            'values_content' => 'Safety, reliability, affordability, and exceptional customer service guide everything we do.',
            'features' => [
                [
                    'icon' => 'fas fa-ticket-alt',
                    'title' => 'Easy Booking',
                    'description' => 'Simple and fast online booking system for all train routes'
                ],
                [
                    'icon' => 'fas fa-shield-alt',
                    'title' => 'Safe Travel',
                    'description' => 'Highest safety standards and well-maintained trains'
                ],
                [
                    'icon' => 'fas fa-dollar-sign',
                    'title' => 'Best Prices',
                    'description' => 'Competitive prices and regular promotions'
                ],
                [
                    'icon' => 'fas fa-clock',
                    'title' => '24/7 Support',
                    'description' => 'Round-the-clock customer support for your convenience'
                ]
            ],
            'stats' => [
                [
                    'icon' => 'fas fa-users',
                    'number' => '50,000+',
                    'label' => 'Happy Customers'
                ],
                [
                    'icon' => 'fas fa-train',
                    'number' => '500+',
                    'label' => 'Daily Trips'
                ],
                [
                    'icon' => 'fas fa-map-marker-alt',
                    'number' => '25+',
                    'label' => 'Destinations'
                ],
                [
                    'icon' => 'fas fa-star',
                    'number' => '4.8/5',
                    'label' => 'Rating'
                ]
            ],
            'is_active' => true
        ]);
    }
}