<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

class ItemFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $customCategoryId = Category::where('name', 'Custom')->first()->id;
        $randomCategoryId = Category::where('id', '!=', $customCategoryId)->inRandomOrder()->first()->id;

        //GENERATE IMAGE
        static $imageFiles;
        static $usedImages = [];
        if (!$imageFiles) {
            $imageFiles = File::files(public_path('images/items'));
        }
        // Filter out used images
        $availableImages = array_diff($imageFiles, $usedImages);
        if (empty($availableImages)) {
            throw new \Exception('No available images left.');
        }
        // Select a random image from the list of available images
        $randomImage = $availableImages[array_rand($availableImages)];
        // Mark this image as used
        $usedImages[] = $randomImage;

        //GENERATE NAME
        $filename = pathinfo($randomImage->getFilename(), PATHINFO_FILENAME);

        return [
            //
            'id' => Item::generateId(),
            'name' => $filename,
            'price' => $this->faker->numberBetween(100000, 1500000),
            'image' => 'images/items/' . $randomImage->getFilename(),
            'category_id' => $randomCategoryId,
            'description' => $this->faker->sentence(rand(10, 20)),
        ];
    }
}
