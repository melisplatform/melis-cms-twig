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

##### I. Base Template creation

This base template will be extended by a child layout.

1.  Inside your site's layout view folder, create a view file with a `twig` file extension:

    `..\view\layout\defaultTwigLayout.twig`

    This template must be registered in your site module's configuration:

    ```php
    // inside module.config.php
    return [
        'view_manager' => [
          'template_map' => [
              'MyDemoSiteName/defaultTwigLayout' => __DIR__ . '/../view/layout/defaultLayout.twig',
          ]
        ]
    ];
    ```

    Possible contents of a base template can be seen in this sample: [defaultTwigLayout.twig](./etc/examples/defaultTwigLayout.twig)

##### II. Child Template creation

For this example, we will be creating a _"Home"_ page.

1.  Inside your site's view folder, create a new file:

    `..\view\my-demo-site-name\home\my-index.twig`

    Sample child templates: [index.twig](./etc/examples/index.twig) or [news-list.twig](./etc/examples/news-list.twig)

2.  Inside Melis Platform, go to `MelisCms` > `Site Tools` > `Template manager`, and add a `New template`.

    - **Site:** My Demo Site Name
    - **Template type:** `Twig`
    - **Layout:** `defaultTwigLayout`
    - **Controller:** Home
    - **Action:** `myIndex`

    **Layout** shall be the base template's name as registered in your module configuration. In other words, _~~MyDemoSiteName/~~**defaultTwigLayout**_.

    **Action** shall be the child template's comma-separated filename, transformed into Camel Case.

    Inside _Home Controller_, implement a method named `myIndexAction(...)`.

##### III. Twig a page

1. Inside Melis Platform, go to `MelisCms` > `Site tree view`. Create a new page.
2. Set the page's `Template` to your child template from the previous step. Select `Draft` to save & reload the Page.

   Note: To enable Twig rendering in front, enable Melis CMS Twig in in your site's `module.load.php`.

   ```php
   return [
       ...
       'MelisCmsTwig',
       ...
   ];
   ```

### Using View Helpers

Inside your twig templates, Melis CMS Twig provides access to various [View Helpers](https://docs.zendframework.com/zend-view/helpers/intro/):

- **Laminas View Helpers** (_Layout, Doctype, etc._)

  ```twig
  {# Generating Styles & JS in the <head> #}
  {{ headLink() }}
  {{ headScript() }}

  {# Using a layout variable #}
  {{ layout().myVar }}
  ```

- **Melis Helpers** (_MelisTag, MelisDragDropZone, etc._)

  ```twig
  {# Displaying an editable text area (editable in back office only) #}
  {{ MelisTag(myPageId, "my-footer-title", "textarea", "My Cool Default Title") }}

  {# Setting a form's action via MelisLink, with configuration from Melis' SiteConfig helper #}
  ...
  <form action="{{ MelisLink(SiteConfig('search_result_page_id'), false) }}" method="get">
  ...
  ```

- **Melis Plugins** (_MelisCmsNewsListPlugin, MelisCmsNewsLatestPlugin, & more_)

  ```twig
  {# Displaying a news list from MelisCmsNews, with parameters passed from controller #}
  {{ MelisCmsNewsListPlugin(listNewsParameters) }}
  ```

### Converting a Melis Plugin

To make use of Melis Plugins inside Twig templates, convert them as view helpers.

#### I. Helper creation

1. Create/Copy the helper class that extends Laminas's `AbstractHelper`.

2. Implement the `__invoke` method that it calls your plugin: `ServiceManager->get('ControllerPluginManager')->get('YourPlugin')`.

3. `return` the result of `ViewRenderer->render(YourPlugin)`.

#### II. Helper Factory creation

1. Create/Copy the helper factory class that implements Laminas's `FactoryInterface`

2. Implement the `createService` method that it instantiates the Helper from the previous step, passing all the needed parameters.

   ```php
   return new YourPluginHelper($serviceManager, $var1, $var2);
   ```

#### III. Helper Registration

The conversion process actually creates a [Twig function](https://twig.symfony.com/doc/2.x/advanced.html#id2) injected inside [Melis CMS Twig's Environment](./src/Factory/EnvironmentFactory.php) via ZF2's View Helper Manager.
This is the reason why you need to register your plugin under the `view_helpers` key.

1. Under your site's configuration (`my-demo-site-name\config\module.config.php`), register your plugin's helper:

   ```php
   ...
   'view_helpers' => [
       'factories' => [
           'YourPlugin' => 'MelisYourModule\View\Helper\Factory\YourPluginHelperFactory',
       ],
   ],
   'view_manager' => [...],
   ...
   ```

## References

These documentations mainly helped in understanding & implementing the module:

- [Twig for Developers](https://twig.symfony.com/doc/2.x/api.html)
- [The MvcEvent](https://docs.zendframework.com/zend-mvc/mvc-event/)
- [The PhpRenderer](https://docs.zendframework.com/zend-view/php-renderer/)

## Authors

- **Melis Technology** - [www.melistechnology.com](https://www.melistechnology.com/)

See also the list of [contributors](https://github.com/melisplatform/melis-cms-comments/contributors) who participated in this project.

## License

This project is licensed under the Melis Technology premium versions end user license agreement (EULA) - see the [LICENSE.md](LICENSE.md) file for details
