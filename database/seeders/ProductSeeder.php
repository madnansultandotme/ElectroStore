<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $microcontrollers = Category::where('name', 'Microcontrollers')->first()->id;
        $sensors = Category::where('name', 'Sensors')->first()->id;
        $devBoards = Category::where('name', 'Development Boards')->first()->id;
        $components = Category::where('name', 'Components')->first()->id;

        $products = [
            // Microcontrollers
            [
                'name' => 'Arduino Uno R3',
                'description' => 'The Arduino Uno R3 is a microcontroller board based on the ATmega328P. It has 14 digital input/output pins, 6 analog inputs, a 16 MHz ceramic resonator, a USB connection, a power jack, an ICSP header, and a reset button.',
                'price' => 25.99,
                'stock' => 50,
                'category_id' => $microcontrollers,
            ],
            [
                'name' => 'ESP32 DevKit V1',
                'description' => 'ESP32 is a series of low-cost, low-power system on a chip microcontrollers with integrated Wi-Fi and dual-mode Bluetooth. Perfect for IoT projects.',
                'price' => 12.99,
                'stock' => 75,
                'category_id' => $microcontrollers,
            ],
            [
                'name' => 'STM32F103C8T6',
                'description' => 'ARM Cortex-M3 32-bit microcontroller with 64KB Flash memory, 20KB RAM, and rich peripheral set. Also known as Blue Pill.',
                'price' => 8.50,
                'stock' => 60,
                'category_id' => $microcontrollers,
            ],
            [
                'name' => 'Raspberry Pi Pico',
                'description' => 'Low-cost, high-performance microcontroller board with flexible digital interfaces. Features the RP2040 microcontroller chip designed by Raspberry Pi.',
                'price' => 4.99,
                'stock' => 100,
                'category_id' => $microcontrollers,
            ],

            // Sensors
            [
                'name' => 'DHT22 Temperature & Humidity Sensor',
                'description' => 'Digital temperature and humidity sensor with high accuracy and excellent long-term stability. Operating range: -40°C to 80°C, 0-100% RH.',
                'price' => 9.99,
                'stock' => 80,
                'category_id' => $sensors,
            ],
            [
                'name' => 'HC-SR04 Ultrasonic Sensor',
                'description' => 'Ultrasonic ranging module that provides 2cm-400cm non-contact measurement function. Ranging accuracy can reach up to 3mm.',
                'price' => 3.99,
                'stock' => 120,
                'category_id' => $sensors,
            ],
            [
                'name' => 'MPU6050 6-Axis Gyroscope',
                'description' => '6-axis motion tracking device that combines a 3-axis gyroscope and 3-axis accelerometer. Perfect for motion detection and orientation sensing.',
                'price' => 7.50,
                'stock' => 90,
                'category_id' => $sensors,
            ],
            [
                'name' => 'BMP280 Pressure Sensor',
                'description' => 'Absolute barometric pressure sensor with high precision and low power consumption. Can measure pressure and temperature.',
                'price' => 6.99,
                'stock' => 70,
                'category_id' => $sensors,
            ],

            // Development Boards
            [
                'name' => 'NodeMCU ESP8266',
                'description' => 'Open-source IoT platform with built-in Wi-Fi. Based on ESP8266 chip with Arduino-compatible programming environment.',
                'price' => 8.99,
                'stock' => 65,
                'category_id' => $devBoards,
            ],
            [
                'name' => 'Raspberry Pi 4 Model B 4GB',
                'description' => 'Latest Raspberry Pi 4 with 4GB RAM, dual 4K display support, Gigabit Ethernet, USB 3.0, and dual-band Wi-Fi.',
                'price' => 75.99,
                'stock' => 30,
                'category_id' => $devBoards,
            ],
            [
                'name' => 'Arduino Nano',
                'description' => 'Small, complete, and breadboard-friendly board based on the ATmega328P. Same functionality as Arduino Uno but in a compact size.',
                'price' => 15.99,
                'stock' => 85,
                'category_id' => $devBoards,
            ],

            // Components
            [
                'name' => 'Breadboard 830 Points',
                'description' => 'Half-size breadboard with 830 tie points. Perfect for prototyping circuits. Includes power rails and numbered rows.',
                'price' => 4.99,
                'stock' => 150,
                'category_id' => $components,
            ],
            [
                'name' => 'Jumper Wires Set (120pcs)',
                'description' => 'Set of 120 jumper wires in 3 types: Male to Male, Male to Female, and Female to Female. Multiple colors for easy circuit identification.',
                'price' => 6.99,
                'stock' => 200,
                'category_id' => $components,
            ],
            [
                'name' => 'Resistor Kit 600pcs',
                'description' => 'Complete resistor kit with 30 different values from 10Ω to 1MΩ. Each value includes 20 pieces. 1/4W carbon film resistors.',
                'price' => 12.99,
                'stock' => 40,
                'category_id' => $components,
            ],
            [
                'name' => 'LED Kit 200pcs',
                'description' => 'Assorted LED kit with 5 colors (Red, Green, Blue, Yellow, White). Each color includes 40 pieces. 5mm diameter, 20mA current.',
                'price' => 8.99,
                'stock' => 60,
                'category_id' => $components,
            ],
            [
                'name' => 'Servo Motor SG90',
                'description' => 'Micro servo motor with 180-degree rotation. Perfect for robotics projects. Operating voltage: 4.8V-6V, torque: 1.8kg/cm.',
                'price' => 3.50,
                'stock' => 110,
                'category_id' => $components,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
