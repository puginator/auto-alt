# Auto Alt

## Description

Auto Alt is a Drupal module that automatically generates alt text for images using the ChatGPT API. This module enhances the accessibility and SEO of your Drupal site by providing meaningful alternative text for images without manual input.

## Features

- Automatically generates alt text for images upon upload
- Provides a button to regenerate alt text for existing images
- Integrates seamlessly with Drupal's media management system
- Configurable API settings for ChatGPT integration

## Requirements

- Drupal 10.x
- PHP 8.1 or higher
- ChatGPT API key

## Installation

1. Install the module via Composer:
   ```
   composer require your-vendor-name/auto-alt
   ```
   Replace `your-vendor-name` with the actual vendor name used in your `composer.json`.

2. Enable the module through the Drupal admin interface or using Drush:
   ```
   drush en auto_alt
   ```

## Configuration

1. Navigate to Configuration > Media > Auto Alt Settings (`/admin/config/media/auto_alt`).
2. Enter your ChatGPT API key.
3. Configure other settings as needed:
   - API Endpoint
   - Model to use
   - Whether to generate alt text automatically on upload

## Usage

### Automatic Generation

If enabled in the settings, alt text will be automatically generated when an image is uploaded to your Drupal site.

### Manual Generation/Regeneration

1. Edit any media entity of type 'Image'.
2. You will see a "Regenerate Alt Text" button near the image field.
3. Click this button to generate or regenerate alt text for the image.

### Bulk Generation

1. Go to the Media overview page (`/admin/content/media`).
2. Select the images you want to generate alt text for.
3. Choose the "Generate Alt Text for Selected Images" action from the dropdown.
4. Apply to generate alt text for all selected images.

## Troubleshooting

If you encounter issues:

1. Check the Recent Log Messages (`/admin/reports/dblog`) for any error messages.
2. Verify your ChatGPT API key and settings.
3. Ensure your server can make outgoing HTTP requests to the ChatGPT API.

## Contributing

Contributions to the Auto Alt module are welcome! Please submit issues and pull requests on our GitHub repository.

## License

This project is licensed under the GPL-2.0-or-later license. See the LICENSE file for details.