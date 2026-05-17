# Dynamic Banner Management

## Overview
The home page banners (Hero Banner and CTA Banner) can now be updated dynamically through the admin panel.

## Features
- Upload new hero banner image
- Upload new CTA banner (Summer Sale) image
- Preview current banners before updating
- Automatic image storage and management

## How to Use

### Access Admin Panel
1. Navigate to: `http://your-domain.com/admin/home`
2. You'll see two sections:
   - **Hero Banner** (Main banner at top of homepage)
   - **CTA Banner** (Summer Sale banner)

### Update a Banner
1. Click "Choose File" under the banner you want to update
2. Select an image from your computer
3. Click "Update Hero Banner" or "Update CTA Banner"
4. The new image will be uploaded and displayed on the homepage

### Image Requirements
- **Hero Banner**: Recommended size 1920x600px
- **CTA Banner**: Recommended size 1920x400px
- **Formats**: JPG, PNG, GIF
- **Max Size**: 2MB

## Technical Details

### Database
- Table: `site_settings`
- Keys: `hero_banner`, `cta_banner`
- Values: Image paths

### File Storage
- Uploaded images are stored in: `public/images/banners/`
- Format: `{type}-{timestamp}.{extension}`
- Example: `hero-1715698234.jpg`

### Default Images
If no custom banner is uploaded, the system uses:
- Hero: `images/img-home/hero-banner.jpg`
- CTA: `images/img-home/home-cta.jpg`

## Routes
- Admin Page: `GET /admin/home`
- Update Banner: `POST /admin/home/update-banner`

## Models
- `App\Models\SiteSetting` - Manages site settings

## Controllers
- `App\Http\Controllers\AdminController` - Admin panel management
- `App\Http\Controllers\HomeController` - Homepage display
