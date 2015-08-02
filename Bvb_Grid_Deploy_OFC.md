# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Open Flash Chart Wrapper



# Introduction #

Bvb\_Grid\_deploy\_Ofc is a wrapper for the well-known chart library [Open Flash Chart](http://teethgrinder.co.uk/open-flash-chart/)

In order to work you will need to download the version from this site, instead from the official. The only thing that changes is class naming, to follow the respected from ZF. Download the latest version from the Downloads Tab

## Setting Chart Type ##
```
$grid->setChartType('pie');
```

## Char Types ##
  * Pie
  * Line
  * Bar
  * Bar\_Glass
  * Bar\_3d
  * Bar\_Filled

## Column Labels ##
```
$grid->setXLabels('column');//Any column from the query
```


## Script Location ##
```
$grid->setFilesLocation(array('js'=>'URL','json'=>'URL','flash'=>'URL'))
```

## Chart Dimensions ##
```
$grid->setChartDimensions(X,Y);
```

## Title ##
```
$grid->setTitle('My Title');
```

## Chart Options ##
```
$grid->setChartOptions(array()); //Just a wrapper for original OFC methods.
```

## Values ##
```
$grid->addValues('column',array('options'));
```

<font color='red'><b>NOTE:</b></font>The array options is just a wrapper for the available methods from the Open Flash Chart Class. The only custom value it accepts is
```
chartType
```
to define a cart type different from the previous defined

## Config Options ##
For the options this class accepts from a Config File check this  [Page](Zend_Config_Support.md)

## Examples ##
Check this live example which fetches random values from a table [Click for examples](http://zfdatagrid.com/grid/site/ofc)