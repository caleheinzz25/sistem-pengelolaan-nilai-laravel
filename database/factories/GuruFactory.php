<?php

namespace Database\Factories;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guru>
 */
class GuruFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mapel = ['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'Fisika', 'Kimia', 'Biologi', 'Sejarah', 'Ekonomi'];

        return [
            'kode_guru' => fake()->unique()->numerify('GRU-#####'),
            'nama' => fake()->name(),
            'mata_pelajaran' => fake()->randomElement($mapel),
        ];
    }

    /**
     * Assign user account for teacher login.
     */
    public function withUser(?User $user = null): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user?->id ?? User::factory()->guru(),
        ]);
    }
}
