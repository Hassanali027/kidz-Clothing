<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\Product;
use App\Models\Blog;

class HomeController extends Controller
{
    /**
     * Show the Home Page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $heroBanner1 = SiteSetting::get('hero_1_banner', SiteSetting::get('hero_banner', 'images/img-home/hero-banner.jpg'));
        $heroBanner2 = SiteSetting::get('hero_2_banner', 'images/img-home/hero-banner.jpg');
        $heroBanner3 = SiteSetting::get('hero_3_banner', 'images/img-home/hero-banner.jpg');
        $ctaBanner = SiteSetting::get('cta_banner', 'images/img-home/home-cta.jpg');
        $preFeaturedBanner = SiteSetting::get('pre_featured_banner', 'images/img-home/home-cta.jpg');
        
        $preFeaturedTitle = SiteSetting::get('pre_featured_title', 'Summer Sale');
        $preFeaturedSubtitle = SiteSetting::get('pre_featured_subtitle', 'Up to 50% Off on Kids Collection');
        $preFeaturedBtnText = SiteSetting::get('pre_featured_button_text', 'Shop Now');
        $preFeaturedBtnLink = SiteSetting::get('pre_featured_button_link', route('categories.index'));

        $ctaTitle = SiteSetting::get('cta_title', 'Summer Sale');
        $ctaSubtitle = SiteSetting::get('cta_subtitle', 'Up to 50% Off on Kids Collection');
        $ctaBtnText = SiteSetting::get('cta_button_text', 'Shop Now');
        $ctaBtnLink = SiteSetting::get('cta_button_link', route('categories.index'));

        // Category images
        $categoryImages = [
            'boys' => SiteSetting::get('category_boys', 'images/img-home/boys-wear.jpg'),
            'girls' => SiteSetting::get('category_girls', 'images/img-home/girls-wear.jpg'),
            'baby' => SiteSetting::get('category_baby', 'images/img-home/baby-wear.jpg'),
            'party' => SiteSetting::get('category_party', 'images/img-home/partywear.jpg'),
        ];

        // Fetch products for different sections
        $featuredProducts = Product::where('status', 'active')
            ->whereJsonContains('display_sections', 'featured_products')
            ->orderBy('created_at', 'desc')
            ->get();

        $newArrivals = Product::where('status', 'active')
            ->whereJsonContains('display_sections', 'new_arrivals')
            ->take(4)
            ->get();

        $shopByCategory = [
            'boys' => Product::where('status', 'active')
                ->where('category', 'LIKE', '%boys%')
                ->whereJsonContains('display_sections', 'shop_by_category')
                ->orderBy('updated_at', 'desc')
                ->take(3)
                ->get(),
            'girls' => Product::where('status', 'active')
                ->where('category', 'LIKE', '%girls%')
                ->whereJsonContains('display_sections', 'shop_by_category')
                ->orderBy('updated_at', 'desc')
                ->take(3)
                ->get(),
            'baby' => Product::where('status', 'active')
                ->where('category', 'LIKE', '%baby%')
                ->whereJsonContains('display_sections', 'shop_by_category')
                ->orderBy('updated_at', 'desc')
                ->take(3)
                ->get(),
            'party' => Product::where('status', 'active')
                ->where('category', 'LIKE', '%party%')
                ->whereJsonContains('display_sections', 'shop_by_category')
                ->orderBy('updated_at', 'desc')
                ->take(3)
                ->get(),
        ];

        $shopByAge = [
            '0-2' => Product::where('status', 'active')
                ->where('age_group', '0-2')
                ->whereJsonContains('display_sections', 'shop_by_age')
                ->orderBy('updated_at', 'desc')
                ->take(3)
                ->get(),
            '2-5' => Product::where('status', 'active')
                ->where('age_group', '2-5')
                ->whereJsonContains('display_sections', 'shop_by_age')
                ->orderBy('updated_at', 'desc')
                ->take(3)
                ->get(),
            '5-8' => Product::where('status', 'active')
                ->where('age_group', '5-8')
                ->whereJsonContains('display_sections', 'shop_by_age')
                ->orderBy('updated_at', 'desc')
                ->take(3)
                ->get(),
            '8-14' => Product::where('status', 'active')
                ->where('age_group', '8-14')
                ->whereJsonContains('display_sections', 'shop_by_age')
                ->orderBy('updated_at', 'desc')
                ->take(3)
                ->get(),
        ];

        $homeBlogs = Blog::where('status', 'published')
            ->where('show_on_home', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('Home-page', [
            'pageTitle' => SiteSetting::get('home_seo_title', 'Kidz Wear - Kids Clothing Store'),
            'metaDescription' => SiteSetting::get('home_seo_description', 'Kidz Wear - Premium Kids Clothing Collection. Shop the latest trends for your little ones.'),
            'heroBanner1' => $heroBanner1,
            'heroBanner2' => $heroBanner2,
            'heroBanner3' => $heroBanner3,
            'ctaBanner' => $ctaBanner,
            'preFeaturedBanner' => $preFeaturedBanner,
            'preFeaturedTitle' => $preFeaturedTitle,
            'preFeaturedSubtitle' => $preFeaturedSubtitle,
            'preFeaturedBtnText' => $preFeaturedBtnText,
            'preFeaturedBtnLink' => $preFeaturedBtnLink,
            'ctaTitle' => $ctaTitle,
            'ctaSubtitle' => $ctaSubtitle,
            'ctaBtnText' => $ctaBtnText,
            'ctaBtnLink' => $ctaBtnLink,
            'categoryImages' => $categoryImages,
            'featuredProducts' => $featuredProducts,
            'newArrivals' => $newArrivals,
            'shopByCategory' => $shopByCategory,
            'shopByAge' => $shopByAge,
            'homeBlogs' => $homeBlogs
        ]);
    }

    /**
     * Show the FAQs Page.
     *
     * @return \Illuminate\View\View
     */
    public function faqs()
    {
        return view('Faqs', [
            'pageTitle'       => 'FAQs | Kidz Clothing',
            'metaDescription' => 'Find answers to frequently asked questions about Kidz Clothing - orders, delivery, returns, sizing and more.',
        ]);
    }
}
