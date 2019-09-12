# Melis CMS Twig

Extends Twig's functionalities to offer an alternative rendering strategy.
This module is based on [ZendFramework's ZfcTwig](https://github.com/ZF-Commons/ZfcTwig).

## Getting started

These instructions will get you a copy of the project up and running on your machine.

### Installation
Run the composer command:
```
composer require melisplatform/melis-cms-twig
```

## Guides
### Basic usage inside Melis Platform
By default, Melis CMS Twig can be used to render a page inside Melis CMS by performing the following:
##### 1. Base Template creation
   - Create a  with a `twig` file extension. This base template will be extended by a child layout
   
     Example: `your-base-template.twig` or `defaultLayout.twig`

     This template must be registered in your site module's configuration:
       ```php
       // Example inside module.config.php
       return [
           'view_manager' => [
               'template_map' => [
                   'MyDemoSiteName/defaultTwigLayout' => __DIR__ . '/../view/layout/defaultLayout.twig',   
               ]
           ]
       ];
       ```


##### 2. Child Template creation   
   - Inside Melis Platform, go to `MelisCms` > `Site Tools` > `Template manager`, and add a new template.
   - Set the `Template type` to `Twig`
   - Set the `Layout` to `defaultTwigLayout`
   
     - Note: `Layout` is your base template's name as registered in your module configuration. In other words, _~~MyDemoSiteName/~~**defaultTwigLayout**_ 

   
##### 3. Twig a page   
- Inside Melis Platform, go to `MelisCms` > `Site tree view`. Create a new page or open an existing one.
- Set the page's `Template` to your child template from the previous step. Save or `Draft` to reload the Page.

### Using View Helpers 
Inside your twig templates, Melis CMS Twig provides you access to various View Helpers:
 - **Zend View Helpers** (_Layout,_ _Doctype,_ etc.)
 ```twig
{# Generating Styles & JS in the <head> #}
{{ headLink() }}
{{ headScript() }}

{# Using a layout variable #}
{{ layout().myVar }}
```

 - **Melis custom helpers** (_MelisTag,_ _MelisDragDropZone_, etc.)
 ```twig
{# Displaying an editable text area (editable in back office only) #}
{{ MelisTag(myPageId, "my-footer-title", "textarea", "My Cool Default Title") }}

{# Setting a form's action via MelisLink, with configuration from Melis' SiteConfig helper #}
...
<form action="{{ MelisLink(SiteConfig('search_result_page_id'), false) }}" method="get">
...
```
 
 - **Melis module plugins** (_MelisCmsNewsListPlugin_, _MelisCmsNewsLatestPlugin, & more)
 ```twig
{# Displaying a news list from MelisCmsNews, with parameters passed from controller #}
{{ MelisCmsNewsListPlugin(listNewsParameters) }}
```
 
 
## Authors
* **Melis Technology** - [www.melistechnology.com](https://www.melistechnology.com/)

See also the list of [contributors](https://github.com/melisplatform/melis-cms-comments/contributors) who participated in this project.

## License
This project is licensed under the Melis Technology premium versions end user license agreement (EULA) - see the [LICENSE.md](LICENSE.md) file for details
