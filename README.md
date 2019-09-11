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
### Basic Usage
By default, Melis CMS Twig can be used to render a page inside Melis CMS by performing the following:
1. Create a *base template* with a `twig` file extension. 
   - Example: `your-base-template.twig` or `defaultLayout.twig`

   :bulb: This template must be registered in your site module's configuration:
   ```php
   // Example inside module.config.php
   return [
       'view_manager' => [
           'template_map' => [
               'MyDemoSite/defaultTwigLayout' => __DIR__ . '/../view/layout/defaultLayout.twig',   
           ]
       ]
   ];
   ```
   
2. Create a child template that `extends` the base template. 
> This base template will be extended by child layout
 
## Authors
* **Melis Technology** - [www.melistechnology.com](https://www.melistechnology.com/)

See also the list of [contributors](https://github.com/melisplatform/melis-cms-comments/contributors) who participated in this project.

## License
This project is licensed under the Melis Technology premium versions end user license agreement (EULA) - see the [LICENSE.md](LICENSE.md) file for details
