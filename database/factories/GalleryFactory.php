<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class GalleryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gallery::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fileExtension = 'png';
        $filetype = $this->faker->randomElement(['jpeg', 'png']);
        $filepath = Str::random(10);

        if ($filetype === 'jpeg') {
            $fileExtension = 'jpg';
        }

        return [
            'user_id' => rand(1, 10),
            'filepath' => 'storage_for_test/'.$filepath.'.'.$fileExtension,
            'filetype' => $filetype,
            'filesize' => rand(1, 100) * 10000,
        ];
    }
}
