<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function coupons()
    {
        return view('admin.coupons', [
            'coupons' => Coupon::withCount('usages')->latest()->get(),
        ]);
    }

    public function storeCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'discount_percent' => 'required|in:5,10',
        ]);

        $discountPercent = (int) $request->discount_percent;
        Coupon::create([
            'code' => strtoupper(trim($request->code)),
            'discount_percent' => $discountPercent,
            'single_use_per_user' => $discountPercent === 10,
            'is_active' => true,
        ]);

        return redirect()->route('admin.coupons')->with('success', 'Coupon created successfully.');
    }

    public function toggleCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update(['is_active' => ! $coupon->is_active]);

        return redirect()->route('admin.coupons')->with('success', 'Coupon status updated.');
    }

    public function deleteCoupon($id)
    {
        Coupon::findOrFail($id)->delete();

        return redirect()->route('admin.coupons')->with('success', 'Coupon deleted successfully.');
    }

    // ============================================
    // Authentication Functions
    // ============================================

    public function showLogin()
    {
        // If already logged in, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'pageTitle' => 'Dashboard'
        ]);
    }

    public function home()
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

        $seoTitle = SiteSetting::get('home_seo_title', 'Kidz Wear - Kids Clothing Store');
        $seoDescription = SiteSetting::get('home_seo_description', 'Kidz Wear - Premium Kids Clothing Collection. Shop the latest trends for your little ones.');

        $socialTwitter = SiteSetting::get('social_twitter', '#');
        $socialFacebook = SiteSetting::get('social_facebook', '#');
        $socialInstagram = SiteSetting::get('social_instagram', '#');
        $socialTiktok = SiteSetting::get('social_tiktok', '#');
        
        // Category images
        $categoryImages = [
            'boys' => SiteSetting::get('category_boys', 'images/img-home/boys-wear.jpg'),
            'girls' => SiteSetting::get('category_girls', 'images/img-home/girls-wear.jpg'),
            'baby' => SiteSetting::get('category_baby', 'images/img-home/baby-wear.jpg'),
            'party' => SiteSetting::get('category_party', 'images/img-home/partywear.jpg'),
        ];
        
        return view('admin.home', [
            'pageTitle' => 'Home Page Management',
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
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription,
            'socialTwitter' => $socialTwitter,
            'socialFacebook' => $socialFacebook,
            'socialInstagram' => $socialInstagram,
            'socialTiktok' => $socialTiktok
        ]);
    }

    public function updateBanner(Request $request)
    {
        try {
            $request->validate([
                'banner_type' => 'required|in:hero,hero_1,hero_2,hero_3,cta,pre_featured,category_boys,category_girls,category_baby,category_party',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'title' => 'nullable|string|max:255',
                'subtitle' => 'nullable|string|max:255',
                'button_text' => 'nullable|string|max:255',
                'button_link' => 'nullable|string|max:255',
            ]);

            $bannerType = $request->banner_type;
            $key = $bannerType . '_banner';
            
            // For category images, use different key format
            if (strpos($bannerType, 'category_') === 0) {
                $key = $bannerType;
            } else {
                $key = $bannerType . '_banner';
            }

            if ($request->has('title')) {
                SiteSetting::set($bannerType.'_title', $request->title);
            }
            if ($request->has('subtitle')) {
                SiteSetting::set($bannerType.'_subtitle', $request->subtitle);
            }
            if ($request->has('button_text')) {
                SiteSetting::set($bannerType.'_button_text', $request->button_text);
            }
            if ($request->has('button_link')) {
                SiteSetting::set($bannerType.'_button_link', $request->button_link);
            }

            if ($request->hasFile('banner_image')) {
                $image = $request->file('banner_image');
                $imageName = str_replace('_', '-', $bannerType) . '-' . time() . '.' . $image->getClientOriginalExtension();
                
                // Ensure directory exists
                $uploadPath = public_path('images/banners');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                // Move the file
                $moved = $image->move($uploadPath, $imageName);
                
                if ($moved) {
                    // Save to database
                    $setting = SiteSetting::set($key, 'images/banners/' . $imageName, 'image');
                    
                    \Log::info('Banner uploaded successfully', [
                        'type' => $bannerType,
                        'file' => $imageName,
                        'path' => 'images/banners/' . $imageName
                    ]);
                }
            }

            $displayName = ucfirst(str_replace('_', ' ', $bannerType));
            return redirect()->route('admin.home')->with('success', $displayName . ' updated successfully!');
            
            
        } catch (\Exception $e) {
            \Log::error('Banner update error: ' . $e->getMessage());
            return redirect()->route('admin.home')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function updateSocialLinks(Request $request)
    {
        $request->validate([
            'social_twitter' => 'nullable|url',
            'social_facebook' => 'nullable|url',
            'social_instagram' => 'nullable|url',
            'social_tiktok' => 'nullable|url',
        ]);

        SiteSetting::set('social_twitter', $request->social_twitter ?? '#');
        SiteSetting::set('social_facebook', $request->social_facebook ?? '#');
        SiteSetting::set('social_instagram', $request->social_instagram ?? '#');
        SiteSetting::set('social_tiktok', $request->social_tiktok ?? '#');

        return redirect()->back()->with('success', 'Social media links updated successfully.');
    }

    public function updateSeo(Request $request)
    {
        try {
            $request->validate([
                'page' => 'required|in:home,category',
                'seo_title' => 'required|string|max:255',
                'seo_description' => 'required|string|max:500'
            ]);

            $page = $request->page;
            SiteSetting::set($page . '_seo_title', $request->seo_title);
            SiteSetting::set($page . '_seo_description', $request->seo_description);

            $route = $page == 'home' ? 'admin.home' : 'admin.categories';
            return redirect()->route($route)->with('success', ucfirst($page) . ' SEO settings updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function categories()
    {
        $seoTitle = SiteSetting::get('category_seo_title', 'Shop by Category | Kidz Wear');
        $seoDescription = SiteSetting::get('category_seo_description', 'Browse all kids clothing categories at Kidz Wear – Boys, Girls, Baby, Party Wear and more.');

        $categories = Category::with('products')->orderBy('order', 'asc')->get();

        return view('admin.categories', [
            'pageTitle' => 'Category Management',
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription,
            'categories' => $categories
        ]);
    }

    public function products()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products', [
            'pageTitle' => 'Product Management',
            'products' => $products
        ]);
    }

    public function addProduct()
    {
        $categories = Category::where('status', 'active')->orderBy('order', 'asc')->orderBy('name', 'asc')->get();
        return view('admin.add-product', [
            'pageTitle' => 'Add New Product',
            'categories' => $categories,
            'productTypes' => $this->getProductTypes()
        ]);
    }

    public function storeProduct(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|string',
                'product_type' => 'nullable|string|max:255',
                'product_type_custom' => 'nullable|string|max:255',
                'age_group' => 'required|string',
                'price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'stock_quantity' => 'required|integer|min:0',
                'status' => 'required|in:active,inactive,out-of-stock',
                'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'color' => 'nullable|string|max:255',
                'size' => 'nullable|string|max:255',
                'review_count' => 'nullable|integer|min:0'
            ]);

            $productType = $this->resolveProductType($request);
            $images = [];
            if ($request->hasFile('product_images')) {
                $uploadPath = public_path('images/products');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                foreach ($request->file('product_images') as $image) {
                    $imageName = 'product-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $imageName);
                    $images[] = 'images/products/' . $imageName;
                }
            }

            $displaySections = $request->display_sections ?? [];

            // If new product has shop_by_category selected, clear it from other products in the same category
            if (in_array('shop_by_category', $displaySections)) {
                $otherProducts = Product::where('category', $request->category)
                    ->whereJsonContains('display_sections', 'shop_by_category')
                    ->get();
                foreach ($otherProducts as $op) {
                    $sections = array_diff($op->display_sections ?? [], ['shop_by_category']);
                    $op->update(['display_sections' => array_values($sections)]);
                }
            }

            // If new product has shop_by_age selected, clear it from other products in the same age group
            if (in_array('shop_by_age', $displaySections)) {
                $otherProducts = Product::where('age_group', $request->age_group)
                    ->whereJsonContains('display_sections', 'shop_by_age')
                    ->get();
                foreach ($otherProducts as $op) {
                    $sections = array_diff($op->display_sections ?? [], ['shop_by_age']);
                    $op->update(['display_sections' => array_values($sections)]);
                }
            }

            $product = Product::create([
                'name' => $request->name,
                'category' => $request->category,
                'product_type' => $productType,
                'age_group' => $request->age_group,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'description' => $request->description,
                'images' => $images,
                'stock_quantity' => $request->stock_quantity,
                'status' => $request->status,
                'display_sections' => $displaySections,
                'related_products' => is_array($request->related_products) ? array_map('intval', $request->related_products) : [],
                'color' => $request->color,
                'size' => $request->size,
                'review_count' => $request->review_count ?? 0
            ]);

            return redirect()->route('admin.products')->with('success', 'Product added successfully!');

        } catch (\Exception $e) {
            \Log::error('Product creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('status', 'active')->orderBy('order', 'asc')->orderBy('name', 'asc')->get();
        return view('admin.edit-product', [
            'pageTitle' => 'Edit Product',
            'product' => $product,
            'categories' => $categories,
            'productTypes' => $this->getProductTypes()
        ]);
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'category' => 'required|string',
                'product_type' => 'nullable|string|max:255',
                'product_type_custom' => 'nullable|string|max:255',
                'age_group' => 'required|string',
                'price' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0',
                'description' => 'nullable|string',
                'stock_quantity' => 'required|integer|min:0',
                'status' => 'required|in:active,inactive,out-of-stock',
                'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'color' => 'nullable|string|max:255',
                'size' => 'nullable|string|max:255',
                'review_count' => 'nullable|integer|min:0'
            ]);

            $productType = $this->resolveProductType($request);
            $images = $product->images ?? [];

            // Handle removed images
            if ($request->has('removed_images') && is_array($request->removed_images)) {
                foreach ($request->removed_images as $removedImage) {
                    if (($key = array_search($removedImage, $images)) !== false) {
                        unset($images[$key]);
                    }
                    
                    $filePath = public_path($removedImage);
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }
                $images = array_values($images);
            }
            
            if ($request->hasFile('product_images')) {
                $uploadPath = public_path('images/products');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                foreach ($request->file('product_images') as $image) {
                    $imageName = 'product-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $imageName);
                    $images[] = 'images/products/' . $imageName;
                }
            }

            $displaySections = $request->display_sections ?? [];

            // If updated product has shop_by_category selected, clear it from other products in the same category
            if (in_array('shop_by_category', $displaySections)) {
                $otherProducts = Product::where('id', '!=', $id)
                    ->where('category', $request->category)
                    ->whereJsonContains('display_sections', 'shop_by_category')
                    ->get();
                foreach ($otherProducts as $op) {
                    $sections = array_diff($op->display_sections ?? [], ['shop_by_category']);
                    $op->update(['display_sections' => array_values($sections)]);
                }
            }

            // If updated product has shop_by_age selected, clear it from other products in the same age group
            if (in_array('shop_by_age', $displaySections)) {
                $otherProducts = Product::where('id', '!=', $id)
                    ->where('age_group', $request->age_group)
                    ->whereJsonContains('display_sections', 'shop_by_age')
                    ->get();
                foreach ($otherProducts as $op) {
                    $sections = array_diff($op->display_sections ?? [], ['shop_by_age']);
                    $op->update(['display_sections' => array_values($sections)]);
                }
            }

            $product->update([
                'name' => $request->name,
                'category' => $request->category,
                'product_type' => $productType,
                'age_group' => $request->age_group,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'description' => $request->description,
                'images' => $images,
                'stock_quantity' => $request->stock_quantity,
                'status' => $request->status,
                'display_sections' => $displaySections,
                'related_products' => is_array($request->related_products) ? array_map('intval', $request->related_products) : [],
                'color' => $request->color,
                'size' => $request->size,
                'review_count' => $request->review_count ?? 0
            ]);

            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Product update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function deleteProduct($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Delete product images from storage
            if ($product->images && is_array($product->images)) {
                foreach ($product->images as $image) {
                    $imagePath = public_path($image);
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
            }
            
            $product->delete();
            
            return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Product deletion error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function blogs()
    {
        return view('admin.blogs', ['pageTitle' => 'Blog Management']);
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.users', [
            'pageTitle' => 'User Management',
            'users' => $users
        ]);
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', [
            'pageTitle' => 'Edit User',
            'user' => $user
        ]);
    }

    public function userOrderHistory($id)
    {
        $user = User::with(['orders' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('admin.user-orders', [
            'pageTitle' => $user->name . ' Order History',
            'user' => $user,
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $id,
                'address' => 'nullable|string|max:500',
                'province' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'postal_code' => 'nullable|string|max:50',
                'phone' => 'nullable|string|max:50',
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'province' => $request->province,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'phone' => $request->phone,
            ]);

            return redirect()->route('admin.users')->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function settings()
    {
        return view('admin.settings', ['pageTitle' => 'Site Settings']);
    }

    public function password()
    {
        return view('admin.password', ['pageTitle' => 'Change Password']);
    }

    // ============================================
    // Category Management Functions
    // ============================================

    public function categoryList()
    {
        $seoTitle = \App\Models\SiteSetting::get('category_seo_title', 'Shop by Category | Kidz Wear');
        $seoDescription = \App\Models\SiteSetting::get('category_seo_description', 'Browse all kids clothing categories at Kidz Wear – Boys, Girls, Baby, Party Wear and more.');

        $categories = Category::orderBy('order', 'asc')->orderBy('name', 'asc')->get();
        return view('admin.categories', [
            'pageTitle' => 'Category Management',
            'categories' => $categories,
            'seoTitle' => $seoTitle,
            'seoDescription' => $seoDescription
        ]);
    }

    public function addCategory()
    {
        return view('admin.add-category', ['pageTitle' => 'Add New Category']);
    }

    public function storeCategory(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:categories,slug',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'description' => 'nullable|string',
                'status' => 'required|in:active,inactive',
                'order' => 'nullable|integer|min:0'
            ]);

            // Auto-generate slug if not provided
            $slug = $request->slug ?: Str::slug($request->name);

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = 'category-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                $uploadPath = public_path('images/categories');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $image->move($uploadPath, $imageName);
                $imagePath = 'images/categories/' . $imageName;
            }

            Category::create([
                'name' => $request->name,
                'slug' => $slug,
                'image' => $imagePath,
                'description' => $request->description,
                'status' => $request->status,
                'order' => $request->order ?? 0
            ]);

            return redirect()->route('admin.category')->with('success', 'Category added successfully!');

        } catch (\Exception $e) {
            \Log::error('Category creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.edit-category', [
            'pageTitle' => 'Edit Category',
            'category' => $category
        ]);
    }

    public function updateCategory(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'nullable|string|max:255|unique:categories,slug,' . $id,
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'description' => 'nullable|string',
                'status' => 'required|in:active,inactive',
                'order' => 'nullable|integer|min:0'
            ]);

            // Auto-generate slug if not provided
            $slug = $request->slug ?: Str::slug($request->name);

            // Handle image upload
            $imagePath = $category->image;
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image));
                }

                $image = $request->file('image');
                $imageName = 'category-' . time() . '-' . uniqid() . '.' . $image->getClientOriginalExtension();
                
                $uploadPath = public_path('images/categories');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                
                $image->move($uploadPath, $imageName);
                $imagePath = 'images/categories/' . $imageName;
            }

            $category->update([
                'name' => $request->name,
                'slug' => $slug,
                'image' => $imagePath,
                'description' => $request->description,
                'status' => $request->status,
                'order' => $request->order ?? 0
            ]);

            return redirect()->route('admin.category')->with('success', 'Category updated successfully!');

        } catch (\Exception $e) {
            \Log::error('Category update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function deleteCategory($id)
    {
        try {
            $category = Category::findOrFail($id);
            
            // Delete category image if exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            
            $category->delete();
            
            return redirect()->route('admin.category')->with('success', 'Category deleted successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Category deletion error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    // ============================================
    // Order Management Functions
    // ============================================

    public function orderList()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('admin.orders', [
            'pageTitle' => 'Order Management',
            'orders' => $orders
        ]);
    }

    public function viewOrder($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.view-order', [
            'pageTitle' => 'Order Details - ' . $order->order_number,
            'order' => $order
        ]);
    }

    public function editOrder($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('admin.edit-order', [
            'pageTitle' => 'Edit Order - ' . $order->order_number,
            'order' => $order,
        ]);
    }

    public function updateOrder(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'payment_method' => 'required|in:cod,online',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        try {
            $order = DB::transaction(function () use ($request, $id) {
                $order = Order::with('items')->lockForUpdate()->findOrFail($id);
                $couponCode = strtoupper(trim((string) $request->coupon_code));
                $coupon = null;

                if ($couponCode !== '') {
                    $coupon = Coupon::where('code', $couponCode)->where('is_active', true)->lockForUpdate()->first();
                    if (!$coupon) {
                        throw new \RuntimeException('This coupon code is invalid or inactive.');
                    }

                    if ($coupon->single_use_per_user && $order->user_id) {
                        $alreadyUsed = CouponUsage::where('coupon_id', $coupon->id)
                            ->where('user_id', $order->user_id)
                            ->where('order_id', '!=', $order->id)
                            ->exists();

                        if ($alreadyUsed) {
                            throw new \RuntimeException('This 10% coupon has already been used with this customer email.');
                        }
                    }
                }

                $subtotal = $order->items->sum(function ($item) {
                    return $item->price * $item->quantity;
                });
                $discountPercent = $request->payment_method === 'online' ? 5 : 0;
                if ($coupon) {
                    $discountPercent += $coupon->discount_percent;
                }
                $discountAmount = round($subtotal * ($discountPercent / 100), 2);

                // Remove any previous one-time coupon usage recorded for this order.
                CouponUsage::where('order_id', $order->id)->delete();

                $order->update(array_merge($request->only([
                    'first_name', 'last_name', 'address', 'city', 'phone', 'payment_method', 'status',
                ]), [
                    'coupon_code' => $coupon ? $coupon->code : null,
                    'discount_amount' => $discountAmount,
                    'total_amount' => $subtotal - $discountAmount,
                ]));

                if ($coupon && $coupon->single_use_per_user && $order->user_id) {
                    CouponUsage::create([
                        'coupon_id' => $coupon->id,
                        'user_id' => $order->user_id,
                        'order_id' => $order->id,
                    ]);
                }

                return $order;
            });
        } catch (\RuntimeException $exception) {
            return back()->withInput()->withErrors(['coupon_code' => $exception->getMessage()]);
        }

        return redirect()->route('admin.orders.view', $order->id)->with('success', 'Order updated successfully.');
    }

    public function deleteOrder($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();
            return redirect()->route('admin.orders')->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function updateOrderStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled'
            ]);

            $order = Order::findOrFail($id);
            $order->update(['status' => $request->status]);

            return redirect()->back()->with('success', 'Order status updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    private function resolveProductType(Request $request)
    {
        $customType = trim((string) $request->input('product_type_custom'));

        if ($customType !== '') {
            return $customType;
        }

        $selectedType = $request->input('product_type');

        return $selectedType === '__custom' ? null : $selectedType;
    }

    private function getProductTypes()
    {
        $defaultTypes = collect([
            'Casual Shirts',
            'T-Shirts',
            'Trousers',
            'Shorts',
            'Frocks',
            'Dresses',
            'Shalwar Kameez',
            'Jogger Sets',
            'Jackets',
            'Sweaters',
        ]);

        $assignedTypes = Product::pluck('product_type')
            ->filter(function ($type) {
                return trim((string) $type) !== '';
            });

        return $defaultTypes->merge($assignedTypes)->unique()->values();
    }
}
