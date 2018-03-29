<?php

namespace App\Services;

use App\Image;
use Image as Resizer;
use App\SpecialOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    private $image_dir = 'public/image/';

    private function getPath($filename)
    {
        $path = $this->image_dir . $filename;
        return $path;
    }

    public function deleteProductImages($product)
    {
        foreach ($product->images as $image) {
            $fullFileName = $this->getPath($image->filename);
            Storage::delete($fullFileName);
            $image->delete($image->id);
        }
    }

    public function updateProductImages($product, $request)
    {

        //selecting featured image
        if (array_key_exists('featured', $request)) {
            foreach ($product->images as $image) {
                $image->update(['featured' => 0]);
            }
            $image = Image::findOrFail($request['featured']);
            $image->update(['featured' => 1]);
        }

        // deleting selected images
        if (array_key_exists('image_id', $request)) {
            foreach ($product->images as $image) {
                if (in_array($image->id, $request['image_id'])) {
                    $fullFileName = $this->getPath($image->filename);
                    Storage::delete($fullFileName);
                    $image->delete($image->id);
                }
            }
        }

        //adding new images
        if (array_key_exists('image', $request)) {
            $filename = $this->uploadResizedImage($request['image']);
            if ($product->images()->exists()) {
                $is_featured = 0;
            } else {
                $is_featured = 1;
            }
            Image::create(['filename' => $filename, 'product_id' => $product->id, 'featured' => $is_featured]);
        }
    }

    public function storeProductImages($product, $image)
    {
        $featured = 1;

        $filename = $this->uploadResizedImage($image);

        Image::create(['filename' => $thumb_filename, 'featured' => $featured, 'product_id' => $product->id]);
    }

    public function uploadResizedImage($image) {

        $filename = $image->getClientOriginalName();

        $width = 600;
        $height = 600;

        $img_thumb = Resizer::make($image->getRealPath());

        $img_thumb->height() > $img_thumb->width() ? $width=null : $height=null;
        $img_thumb->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        while (file_exists( storage_path('app/public/image/medium-' . $filename ) )) {
            $six_digit_random_number = mt_rand(100000, 999999);
            $filename = $six_digit_random_number . $filename;
        }   

        $img_thumb->save( storage_path('app/public/image/medium-' . $filename ) ); 

        $filename = $img_thumb->basename;
        return $filename;
    }

    public function uploadImage($file)
    {
        $path = $file->storePublicly($this->image_dir);
        $filename = basename($path);
        return $filename;
    }
}