# A2bizz AAMC
A2bizz Advanced Module Creator

## Description  
A2bizz Advanced module creator (AAMC) is a Magento2 Extension to create custom modules in quick manner with basic requirments of a module.
Developers can make changes in a generated module as per requirement. 
The benifit of this magento2 module creater is that you can create modules directly to the <strong>app/code</strong> section of a project, so <strong>no need to download or copy paste generated module</strong>.
the module generated will appears, or you can find your module in <strong>app/code/{namespace}/{module} folder, directly</strong>.
To make this newly generated module, you just only have to run upgrade command to configure it with magento 2 project.
<strong>You like the work the developer has done and it saved you a lot o time and money, consider <a href="https://www.paypal.me/amitgame2002/10">donating</a>. Any amount is welcomed. Just change 10 from the previous URL.</strong>

## Requirements
PHP version 8.0.0 or higher. Some PHP extensions may be needed. See composer.json for more details.

## Supported platforms
 - Magento 2.4.6+ 
 - Magento 2.4.*

## Installation
 - clone this repo: `https://github.com/gitamitgit/magento2-module-creator.git .`
 - Simply upload it from Root folder of your project
 - the Module Creator extension will be added
 - Now run below commands to proper start of a Module Creator Extension.
 - bin/magento setup:upgrade
 - bin/magento setup:static-contnt:deploy
 - bin/magento setup:di:compile
 
## How to use  
 - Login to your admin
 - You will see <strong>A2bizz</strong> Section is added on Main Menu
 - Navigate it and click on Add New
 - A desired form will be opened, provide a Namespace and a Module Name
 - Click on create button
 - it will create a custom module inside <strong>app/code/{Namespace}/{Module}/</strong>
 - Till this module is not updated with the Magento2 Project, so you can make your desired changes into the custom module like - adding Fields, modifying code etc
 - After all the changes run below commands to attach the new created module with project
 - bin/magento setup:upgrade
 - bin/magento setup:static-contnt:deploy
 - bin/magento setup:di:compile
 
## FAQs  
 - <strong>Do I can edit a module?</strong>
 - No, you cannot edit module from the given interface. It just provide to create module and to delete it.
                        
## Coding Standards  
The generated extensions follow the PSR1, PSR2, PSR12 coding standards.

## Contributing to the AAMC    
 - If you find a bug, report it <a href="https://github.com/gitamitgit/magento2-module-creator/issues">here</a>  
 - you have a cool idea for improving it but you don't want to implement it, post it <a href="https://github.com/gitamitgit/magento2-module-creator/issues">here</a>. There are no guarantees that it will get implemeted though.  
 - you have a cool idea for improving it and you can implement it, feel free to make a PR. But before doing so, make sure that the new code you create it is covered with unit tests and the existing unit tests still pass.  

  
