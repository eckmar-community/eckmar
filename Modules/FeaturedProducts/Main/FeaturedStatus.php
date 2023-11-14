<?php


namespace Modules\FeaturedProducts\Main;


use App\Product;

class FeaturedStatus
{
    public function getFeaturedProducts(){
        try{
            $cacheMinutes = intval(config('marketplace.front_page_cache.featured_products'));
            $featuredProducts = \Cache::remember('featured_products_front_page', $cacheMinutes, function () {
                return Product::where('featured',1)->inRandomOrder()->limit(3)->get();
            });
        } catch (\Exception $e){
            $featuredProducts = null;
        }
        return $featuredProducts;
    }
}