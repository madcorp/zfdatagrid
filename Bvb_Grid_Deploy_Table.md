# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Methods only available for Table render



# Table #
```
$grid->setAjax();
$grid->setImagesUrl();
```

## Ajax ##
Ajax is easy and simple to setup.
All you have to do is:
```
$grid->ajax('id');//A div with this id will be created
```

If you want to disable ajax use:
```
$grid->ajax(false);
```

_Note:_ Ajax is off by default

## Conditional Fields Presentation ##
Let's imagine you are presenting a report. And as any report it will have a range of values. Some positives and, how knows, some negatives.

ZFDatagrid provides two methods for altering CSS classes based on conditions.

### Per Row ###

Lets imagine you want to add a CSS class on every row in which population value is less greater than 20000.

```
$grid->setClassRowCondition("{{Population}} > 20000","green");
```

The first argument is the condition. As noticed use the {{}} to get fields values.


**NOTE:** When comparing strings please remember to include the '' around the field name, so PHP can treat that as a string and not a number.

You can add a third argument, that is also a class that will be applied if the condition is not true.

```
$grid->setClassRowCondition("{{Population}} > 20000","green","orange");
```

### Per Column ###

Is the same behavior as for a Row, but you need to specify the column that the condition will be applied.

```
$grid->addClassCellCondition('Population',"{{Population}} > 200000","red");
```

As expected, you can also add a third argument in case the condition is not true

```
$grid->addClassCellCondition('Population',"{{Population}} > 200000","red","green");
```

## Default Classes ##
You can set the default CSS classes to be applied to even and odd rows

```
$grid->setRowAltClasses('odd','even');
```

<font color='red'><b>ATTENTION</b></font> This only applies to Tables.

## Don't Show Order Images ##
You can ommit order arrows, and make them appear only when a columns is sorted.

```
$grid->setAlwaysShowOrderArrows(false);
```

## Never Show Order Images ##
Using this method no images will appear, even when a field is sorted.
```
$grid->setShowOrderImages(false);
```

## Disable Order ##
```
$grid->setNoOrder(true);
```

## Disable FIlters ##
```
$grid->setNoFilters(true);
```

## Change records per page ##
You can let a user choose how many records are showned per page

```
$grid->setPaginationInterval(array(10 => 10, 20 => 20, 50 => 50, 100 => 100));
```

## Config Options ##
For the options this class accepts from a Config File check this  [Page](Zend_Config_Support.md)