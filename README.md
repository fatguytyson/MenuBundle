# FGCMenuBundle
The FGCMenuBundle is a simple yet robust menu renderer for Symfony4.

The biggest change is the decision to remove Annotation Support. The feature made code handling difficult to manage, and
chasing down menu items difficult. So centralising menu creation in configurations, and events.
## Documentation
### Installation
#### 1. Download the bundle
Open a command console, enter your project directory and execute the following command to download the latest
stable version of this bundle:
```bash
$ composer require fgc/menu-bundle
```
This command requires you to have Composer installed globally, as explained in the 
[installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.
#### 2. Enable the Bundle
Then, enable the bundle by adding the following line in the ```app/AppKernel.php``` file of your project:

This is only needed if you don't have symfony/flex.
```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new FGC\MenuBundle\FGCMenuBundle(),
        );

        // ...
    }

    // ...
}
```
#### 3. Configure the bundle
The bundle comes with a sensible default configuration, which is listed below. You can define these options 
if you need to change them:
```yaml
# app/config/config.yml
fgc_menu:
    # The path for the @Menu Annotation to look.
    # This is the default location, and only needs to be added IF you changed the base Bundle
#    directory: AppBundle/Controller
    # The Namespace for the @Menu Annotation to apply.
    # Same as above
#    namespace: AppBundle\Controller
    # Defining of menus that aren't in your main bundle
#    menus:
        # Menu group name and identifier
        # default is also the group given if omitted
    default:
        # Menu Title
        Home Page:
            # each option below is optional
            # route name for the link to generate
            route: homepage
            # route parameters if any. If omitted, an empty array is returned
            routeOptions: 
                option: value
                option2: value
            # icon to be attached to the menu item. Great for dashboards
            icon: dashboard
            # order of the items, so the annotations can be integrated smoothly
            order: 1
            # a single ROLE to show only if is_granted() or none to always show This was previously ROLE, and is a 
            # breaking change.
            granted: IS_ANONYMOUS
            # This is needed if the granted action needs an object to check against. You may need to dynamically add
            # the menu item to add objects rather than strings
            grantedObject: 'User'
            # to make mult-level menus, menu name to place under this item.
            children: user
```

### Add Dynamic Menu Items
Follow the [instructions](https://symfony.com/doc/3.4/components/event_dispatcher.html#using-event-subscribers) to make
an event subscriber and listen for the ``DiscoverMenuEvent::NAME`` event.

Here, you can ``$event->addMenuItem(Menu)`` on the fly.

Make sure to remember to add group names.

And lastly:
 
### Render the menus in your templates.

```twig
{# ... #}
{{ fgc_menu() }}
{# ... #}
```

This renders:

```html
<li>
    <a href="/">
        Home
    </a>
</li>
<li>
    <a href="/admin/">
        Admin Area
    </a>
</li>    
```
And can be modified with additional parameters.
```twig
{{ fgc_menu("Menu Group Name", "template name", (int)depth) }}
```
### Templating the menu
I have a few templates I have needed already.
* default
* bootstrap4
* sb_admin_2

There are more coming, and can easily be overridden by adding them to your app/Resources directory.
```twig
{# app/Resources/FGCMenuBundle/{template_name}.html.twig #}
{% for item in menu %}
    {% if not item.granted or is_granted(item.granted, item.grantedObject) %}
        <li>
            <a href="{{ item.route ? path(item.route, item.routeOptions) : '#' }}">
                {% if item.icon %}<i class="fa fa-{{ item.icon }}" ></i>{% endif %}
                {{ item.name }}
            </a>
            {% if item.children and depth %}
                <ul>
                    {{ fgc_menu(item.children, template, depth) }}
                </ul>
            {% endif %}
        </li>
    {% endif %}
{% endfor %}
```
## Afterword
In v2, cache was attempted to be added, and while it saved the cache correctly, there are too many variables to chase 
down into to generate the cache key. I may try again, but not now.

New Features in development (dev-master) Add Dynamic Menus through event listener 
I hope this handles your needs for a simple yet robust menu rendering solution. 
Please feel free to submit issues so it can be improved.

This is an attempt to move to Symfony4.