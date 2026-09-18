<?php

namespace Database\Factories;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CertificateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'enrollment_id' => Enrollment::factory(),
            'certificate_number' => 'CERT-' . strtoupper(Str::random(10)),
            'issued_at' => now(),
            'certificate_file' => null,
            'status' => 'active',
        ];
    }
}