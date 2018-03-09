<?php

namespace App\Services;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageService {

    public function deleteProductImages($product)
    {
        foreach ($product->images as $image) {
            $fullFileName = 'public/image/' . $image->filename;
            Storage::delete($fullFileName);
            $image->delete($image->id);
        }
    }

    public function updateProductImages($product, $request)
    {

        //selecting featured image
        if (array_key_exists('featured',$request)) {
            foreach ($product->images as $image) {
                $image->update(['featured' => 0]);
            }
            $image = Image::findOrFail( $request['featured'] );
            $image->update(['featured' => 1]);
        }

        // deleting selected images
        if (array_key_exists('image_id', $request)) {
            foreach ($product->images as $image) {
                if (in_array($image->id, $request['image_id'])) {
                    $fullFileName = 'public/image/' . $image->filename;
                    Storage::delete($fullFileName);
                    $image->delete($image->id);
                }
            }
        }

        //adding new images
        if (array_key_exists('image', $request)) {
                $file = $request['image'];
                $path = $file->storePublicly('public/image');
                $filename = basename($path);
                Image::create(['filename' => $filename, 'product_id' => $product->id, 'featured' => 0]);
            }

        //setting featured image if product has no featured image
        if (!isset($product->featured_image_id)) {
            if ($product->images()->exists()) {
                $firstImage = $product->images()->first();
                $firstImage->update(['featured' => 1]);
            }
        }
    }

    public function storeProductImages($product, $image)
    {
        $featured = 1;
        $file = $image;
        $path = $file->storePublicly('public/image');
        $filename = basename($path);
        Image::create(['filename' => $filename, 'featured' => $featured, 'product_id' => $product->id]);

    }
}