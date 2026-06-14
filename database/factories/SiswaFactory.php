<?php

namespace Database\Factories;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Siswa>
 */
class SiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kelas = ['X', 'XI', 'XII'];
        $jurusan = ['IPA', 'IPS'];

        return [
            'nis' => fake()->unique()->numerify('NIS-#####'),
            'nama' => fake()->name(),
            'kelas' => fake()->randomElement($kelas).' '.fake()->randomElement($jurusan).' '.fake()->numberBetween(1, 3),
        ];
    }

    /**
     * Assign user account for student login.
     */
    public function withUser(?User $user = null): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user?->id ?? User::factory()->siswa(),
        ]);
    }
}
