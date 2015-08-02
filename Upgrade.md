# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary How to Upgrade

# 0.7 to trunk (0.8) #

## Cache ##
Cache 'use' param, has been renamed to 'enable'

New
```
$grid->setCache(array('enable' => true|false, 'instance' => $cache, 'tag' => 'grid'));
```

OLD
```
$grid->setCache(array('use' => array('form'=>false,'db'=>false), 'instance' => $cache, 'tag' => 'grid'));
```


## Callbacks/Events ##

Callbacks where removed in favor of events. A list of available events will be available soon. But for crud operations something like this can be done

```
$grid->listenEvent('crud.before_update', $callback);
```

Your callback will receive one arg, a Bvb\_Grid\_Event instance
```
function My_Callback($event)
{
   $params = $event->getParams();
   $param = $event->getParam($param);
   $name = $event->getName();
   $object = $event->getObject();
}
```


Full list for crud operations:
  * crud.before\_insert
  * crud.before\_update
  * crud.before\_delete
  * crud.after\_insert
  * crud.after\_update
  * crud.after\_delete

**These names can change before version release**

## Mass actions ##
They have their own class now. Changes:

OLD:
```
$actions->setMassActions(array(array('url' => $grid->getUrl(), 
                                     'caption' => 'Remove (Nothing will happen)', 
                                     'confirm' => 'Are you sure?'), 
                               array('url' => $grid->getUrl() . '/nothing/happens', 
                                     'caption' => 'Some other action', 
                                     'confirm' => 'Another confirmation message?')));

```

NEW:
```
$actions = new Bvb_Grid_Mass_Actions();
$actions->setMassActions(array(array('url' => $grid->getUrl(), 
                                     'caption' => 'Remove (Nothing will happen)', 
                                     'confirm' => 'Are you sure?'), 
                               array('url' => $grid->getUrl() . '/nothing/happens', 
                                     'caption' => 'Some other action', 
                                     'confirm' => 'Another confirmation message?')));

$grid->setMassActions($actions);
```

# 06.5. to 0.7 #

**Defining  grid columns - Until now when setting grid columns, extra columns where always there. From now on, when defining grid columns you must also specify any extra column you want to see. Use the column name.**

# 0.6 to 0.6.5 #

  * Abstract classes and interfaces where prefixed with the file name. Bvb\_Grid\_Formatter\_Interface => Bvb\_Grid\_Formatter\_FormatterInterface

  * Callbacks in forms are now called using call\_user\_func\_array instead call\_user\_func

  * Forms are now built with subForms. So you will see 1- prefixed in all of your input ids. Input names also changed to arrays. This does not affect any previous PHP code. Just if you are using JS libraries to beautify yours forms.

# 0.5 to 0.6 #

## Factory Pattern ##
Now you don't have to instantiate the deploy class.
Use this:
```
$grid = Bvb_Grid::factory('table',$options = array(),$gridId = '');
```


## Uniformed fields calls ##
Whenever you are, you must cell the field name by it's output and not by name. Tables prefixes are also over.

If your raw query looks like this:

```
SELECT id, username as name, age, status, online FROM users where id='1';
```

You must reference to the field _username_ as _name_.
If you are using joins and you have two fields with the same name on different tables you must give one of them an alias
otherwise the first will be overwritten by the last.

## No direct Access ##
You cannot set class attributes directly. You now must use the set**() method.**

Instead of

```
$grid->cache = array();
```
You now have to do
```
$grid->setCache(array());
```

## CRUD Operations ##

CRUD operations now use Zend\_Form to render the form. No more custom forms.
Please refer to this page for more [information](CRUD.md)

## Data Sources ##
ZFDatagrid now uses a interface to build the grid, so no more calls like this:
```
$grid->setDataFromArray();
$grid->setDataFromXml();
```

you must now use
```
$grid->setSource(new Bvb_Grid_Source_`*`);
```

Check this [page](Bvb_Grid_Source.md) for detailed information

Changes in the query() method.
```
$grid->query($select);//Can be used only for Zend_Db_Select and Zend_Db_Table_Abstract Sources
```

## Renamed ##

  * Bvb\_Grid\_ExtraColumns have been renamed to Bvb\_Grid\_Extra\_Column
