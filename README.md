# core-bundle

this README is currently in progress. Thank you for your understanding...

A simple bundle to handle other Dywee bundles. Add interesting functionnalities such as 
- ParentController to rule them all
- Js form collection type handling
- Data Preload for remote modal 
- The awesome Admin LTE template

##Installing

just run
```bash
$ composer require dywee/core-bundle
```

add the bundle to the kernel
```php
new Dywee\CoreBundle\DyweeCoreBundle(),
```

no more configuration needed

## Using the admin template

This bundle provides the famous Admin LTE template for you to easily design your symfony application.
Just extend the 'DyweeCoreBundle:Templates:admin.html.twig' template from your twig template and us ethe 'body' block tag.

```twig
{# Dywee\CMSBundle\Resources\views\admin.html.twig #}

{% extends "DyweeCoreBundle::admin.html.twig" %}

{% block metaTitle %}
    {{ parent() }}
{% endblock %}

{% block body %}
    My awesome body
{% endblock %}
```


## How to customize the administration

You can easily add item to the admin dashboard/navbar/sidebar just by using the Dywee Custom events.

There are 3 custom events:
* DashboardBuilderEvent
* AdminNavbarBuilderEvent
* SidebarBuilderEvent

So, what you have to do, is just to create a listener:

```php
<?php

namespace YourBundle\Listener;

use Dywee\AddressBundle\Service\AdminSidebarHandler;
use Dywee\CoreBundle\DyweeCoreEvent;
use Dywee\CoreBundle\Event\SidebarBuilderEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminSidebarBuilderListener implements EventSubscriberInterface{
    private $adminSidebarHandler;

    public function __construct(AdminSidebarHandler $adminSidebarHandler)
    {
        $this->adminSidebarHandler = $adminSidebarHandler;
    }

    public static function getSubscribedEvents()
    {
        // return the subscribed events, their methods and priorities
        return array(
            DyweeCoreEvent::BUILD_ADMIN_SIDEBAR => array('addElementToSidebar', -10)
        );
    }

    public function addElementToSidebar(SidebarBuilderEvent $adminSidebarBuilderEvent)
    {
        $adminSidebarBuilderEvent->addElement($this->adminSidebarHandler->getSideBarMenuElement());
    }

}
```

And the dedicated SidebarHandler

```php
<?php
namespace YourBundle\Service;

use Symfony\Component\Routing\Router;

class AdminSidebarHandler
{

    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getSideBarMenuElement()
    {
        $menu = array(
            'key' => 'address',
            'icon' => 'fa fa-map-marker',
            'label' => 'address.sidebar.label',
            'children' => array(
                array(
                    'icon' => 'fa fa-list-alt',
                    'label' => 'address.sidebar.table',
                    'route' => $this->router->generate('address_admin_table')
                ),
            )
        );

        return $menu;
    }
}
```

Dont forget to register your 2 classes
 
```yaml
your_bundle.your_custom_sidebar_listener:
    class: YourBundle\Listener\AdminSidebarBuilderListener
    arguments: [ '@your_bundle.your_custom_sidebar_handler' ]
    tags:
        - { name: kernel.event_subscriber }

your_bundle.your_custom_sidebar_handler:
    class: YourBundle\Service\AdminSidebarHandler
    arguments: [ '@router' ]
```

## The CoreBundle and javascript

## Using ParentController

## Using the modal preload

## Js form collection handling

the core bundle is providing 2 ways to handle collections in forms, based on jQuery.

The easiest way to handle a collection is using the dywee_handle_form_collection(collection_container_id) function (without any '#'):

```javascript
<script>
dywee_handle_form_collection('my_collection_id');
</script>
```
and it's all yu have to do.

For more flexibility, we add another method, to customize a little bit what is happening when you handle a form collection.

```javascript
<script>
dywee_handle_form_collection(collection_container_id, personnalConfig);
</script>
```

like this :

```javascript
<script>
var personnalConfig = {
    container_type: 'div',
    label: 'My element',
    allow_add: true,
    allow_delete: true,
    add_btn: {
        target: '.action-add',
        'class': 'btn btn-default',
        icon: '',
        text: 'Add an item'
    },
    remove_btn: {
        'target': '.action-delete',
        'class': 'btn btn-danger',
        icon: 'fa fa-trash',
        text: 'Delete'
    }
};
dywee_handle_form_collection(collection_container_id, personnalConfig);
</script>
```
