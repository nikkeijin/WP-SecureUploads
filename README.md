# Private File Management for WordPress

## Description

This repository contains code to create a private directory inside the `wp-content/uploads` directory of a WordPress installation. The objective is to restrict access to files within this directory only to logged-in users while ensuring seamless uploading and management of media files.

## Objective

The objective of this setup is to enhance the privacy and security of media files uploaded to a WordPress website by:

- Creating a private directory within `wp-content/uploads`.
- Allowing access to files within this directory only to logged-in users.
- Automatically upload media files to the private directory if the specified post-type matches the post-type you set in your upload.php.

## Installation

1. Clone or download this repository.
2. Create `private` folder in `wp-content/uploads/`, then copy the provided `.htaccess` file to the `wp-content/uploads/private/`.
3. Place the `private.php` file in your theme's directory located at `wp-content/themes/your-theme/`.
4. Copy the provided code from `upload.php` and paste the code into your theme's `functions.php` file.

> Customize the post-type by editing the provided upload.php. Simply search for 'subscriber-blog' and replace with your desired post-type throughout the file.

## Usage

### .htaccess

The `.htaccess` file establishes a rewrite rule, redirecting internal requests for files within the private directory to the private.php script. This mechanism ensures that access to these files is governed by the PHP script.
    
Adjust the directory paths according to the location of your private.php:

```bash
RewriteRule ^(.*) /wp-content/themes/your-theme/functions/private/private.php?f=$1 [L]
```

### private.php

The `private.php` script serves files located within the private directory only to logged-in users. This file verifies user authentication using WordPress functions and delivers the requested file content with appropriate headers.
    
Adjust the directory paths according to the location of your wp-load.php:

```php
require_once(__DIR__. '/../../../../../wp-load.php');
```

### upload.php

The `upload.php` code customizes the upload directory for attachments based on the post-type. If the post-type is `subscriber-blog`, media files are automatically uploaded to the private directory. Additionally, the code in `upload.php` manages attachment actions to ensure seamless management of files within the private directory.

## Security Considerations

- Ensure that proper access controls are in place to restrict access to the `private.php` script and the private directory.
- Regularly audit file permissions and access controls to prevent unauthorized access to sensitive files.
- Test the setup thoroughly to ensure that file uploads and access restrictions are functioning as expected.
