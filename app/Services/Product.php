<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class Product
{
    /**
     * Store the uploaded file on a filesystem disk images.
     * @param  File $image
     * @return  String|false
     */
    public function storeImage($image, $imagePrevious = null)
    {
        if (!is_null($image)) {
            if (!is_null($imagePrevious)) {
                $this->deleteImage($imagePrevious);
            }

            return $image->store('', 'images');
        }

        return 'Default.jpg';
    }
/**
 * Delete image of the product
 * @param  String $image
 * @return Boolean
 */
    public function deleteImage($image)
    {
        return Storage::disk('images')->delete($image);
    }
}
