# [MageVision](https://www.magevision.com/) Mass Email Customers for Magento 2

## Overview
The Mass Email Customers extension gives you the ability to send an email to all or selected registered and guest customers. Send a mass email with one click from the admin sales order grid and the admin customer grid. Email template customization like Magento's default email templates. An easy way to contact your customers and keep them up-to-date with your news, events and updates.
## Key Features
	* Send mass email to all or selected customers
    * Send mass email with one click from the admin sales order grid and admin customer grid
	* Easy email template customization like Magento's default email templates
	* Custom email variables for customer and order data
	
## Other Features
	* Developed by a Magento Certified Developer
	* Meets Magento standard development practices
	* Simple installation
	* 100% open source

## Compatibility
Magento Community Edition 2.4

## Installing the Extension using an archive and FTP
	* Backup your web directory and store database
	* Download the extension
		1. Sign in to your account
		2. Navigate to menu My Account → My Downloads
		3. Find the extension and click to download it
	* Extract the downloaded ZIP file in a temporary directory
	* Upload the extracted folders and files of the extension to base (root) Magento directory. Do not replace the whole folders, but merge them.  If you have downloaded the extension from Magento Marketplace, then create the following folder path app/code/MageVision/MassEmailCustomers and upload there the extracted folders and files.
        * Connect via SSH to your Magento server as, or switch to, the Magento file system owner and run the following commands from the (root) Magento directory:
              1. cd path_to_the_magento_root_directory 
              2. php bin/magento maintenance:enable
              3. php bin/magento module:enable MageVision_MassEmailCustomers --clear-static-content
              4. php bin/magento setup:upgrade
              5. php bin/magento setup:di:compile
              6. php bin/magento setup:static-content:deploy
              7. php bin/magento maintenance:disable
        * Log out from Magento admin and log in again

## Installing the Extension via composer
	* Backup your web directory and store database
    * Connect via SSH to your Magento server as, or switch to, the Magento file system owner and run the following commands from the (root) Magento directory:
        1. cd path_to_the_magento_root_directory 
        2. php bin/magento maintenance:enable
        3. composer require magevision/module-mass-email-customers
        4. php bin/magento module:enable MageVision_MassEmailCustomers --clear-static-content
        5. php bin/magento setup:upgrade
        6. php bin/magento setup:di:compile
        7. php bin/magento setup:static-content:deploy
        8. php bin/magento maintenance:disable

## How to Use

Navigate to Magento Admin under Stores → Configuration → MageVision Extensions → Mass Email Customers to  configure the Sender email and the Mass Email Template. 
The default email template that the extension uses, includes just a simple example message. So you will need to customize it and add your message. Navigate to Magento Admin under Marketing → Email Templates and add a new template. Load as default template the “Mass Email Template“ and see the template's information. You can customize the template subject and content. Except from the default Magento's variables, you can also use some custom variables that you can use to add customer and order data to your email content. 

Variables:
“customer_name“ : Customer Name
“customer_email“ : Customer Email Address
“increment_id“  : Order Id (only for sending email from the admin sales order grid)

Give a name to your custom template and save it. Afterwards navigate again to Magento Admin under Stores → Configuration → MageVision Extensions → Mass Email Customers and configure the extension to use your new custom email template.

## Support
If you need support or have any questions directly related to a [MageVision](https://www.magevision.com/) extension, please contact us at [support@magevision.com](mailto:support@magevision.com)
