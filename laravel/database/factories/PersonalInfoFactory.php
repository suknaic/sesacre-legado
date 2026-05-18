<?php

namespace Database\Factories;

use App\Models\PersonalInfo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonalInfoFactory extends Factory
{
    protected $model = PersonalInfo::class;

    public function definition(): array
    {
        $cpf = $this->generateValidCpf();

        return [
            'user_id' => User::factory()->state(['cpf' => $cpf]),
            'gender' => fake()->randomElement(['M', 'F']),
            'is_active' => true,
        ];
    }

    public function withUser(User $user): static
    {
        return $this->state(fn (array $attrs) => [
            'user_id' => $user->id,
        ]);
    }

    private function generateValidCpf(): string
    {
        $n1 = random_int(0, 9);
        $n2 = random_int(0, 9);
        $n3 = random_int(0, 9);
        $n4 = random_int(0, 9);
        $n5 = random_int(0, 9);
        $n6 = random_int(0, 9);
        $n7 = random_int(0, 9);
        $n8 = random_int(0, 9);
        $n9 = random_int(0, 9);

        $d1 = $n1 * 10 + $n2 * 9 + $n3 * 8 + $n4 * 7 + $n5 * 6 + $n6 * 5 + $n7 * 4 + $n8 * 3 + $n9 * 2;
        $d1 = 11 - ($d1 % 11);
        $d1 = $d1 >= 10 ? 0 : $d1;

        $d2 = $n1 * 11 + $n2 * 10 + $n3 * 9 + $n4 * 8 + $n5 * 7 + $n6 * 6 + $n7 * 5 + $n8 * 4 + $n9 * 3 + $d1 * 2;
        $d2 = 11 - ($d2 % 11);
        $d2 = $d2 >= 10 ? 0 : $d2;

        return "{$n1}{$n2}{$n3}{$n4}{$n5}{$n6}{$n7}{$n8}{$n9}{$d1}{$d2}";
    }
}
