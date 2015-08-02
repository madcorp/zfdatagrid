# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Available Sources



# Introduction #

ZFdatagrid has the ability to read from a variety of sources, and at any moment more can be added, even by you.

At this moment ZFDatagrid can read from this sources
  * Zend\_Db\_Select
  * Zend\_Db\_Table\_Abstract
  * Doctrine
  * CSV
  * XML
  * Array
  * Json
  * Excel Files

And can auto build forms from this sources:

  * Zend\_Db\_Select
  * Zend\_Db\_Table\_Abstract
  * CSV

## Zend\_Db\_Select ##
> The only thing you need to do is pass the object instance to the grid
```
 $grid->setSource(new Bvb_Grid_Source_Zend_Select(Zend_Db_Select $select));
```

> Example:
```
 $select = $this->getDb->select()->from('table'); 
 $grid->setSource(new Bvb_Grid_Source_Zend_Select($select));
```


## Zend\_Db\_Table\_Abstract ##
> The only thing you need to do is pass the model to the grid
> Example:
```
 $grid->setSource(new Bvb_Grid_Source_Zend_Table(Zend_Db_Table $model));
 $grid->setSource(new Bvb_Grid_Source_Zend_Table(new Model()));
```

**Note:** http://code.google.com/p/zfdatagrid/issues/detail?id=507

## Doctrine ##
> The only thing you need to do is pass the Doctrine instance to the grid
> Example:
```
 $select = Doctrine_Query::create()->from('Model')->where('code = ?', $id)
 $grid->setSource($select);
```


## CSV ##
```
$grid->setSource(new Bvb_Grid_Source_Csv($file,$fields,$separator));
```

Where

```
$file //Is the source file
$fields // is NULL or and array specifying the fields. If NULL the first row will be used as fields
$separator //The value separator. Default is _,_ 
```


## XML ##
```
$grid->setSource(new Bvb_Grid_Source_Xml($file, $loop,$columns));
```

Where

```
$file//Is the xml location: http://zfdatagrid.com/feed/
$loop //The node where the data you want to fetch is. In RSS feeds is probably: 'channel,item'
$columns//The fields names. If null the node name will be used
```

## Array ##
```
$grid->setSource(new Bvb_Grid_Source_Array($array));
```
_The array keys will be the fields titles_

**Array format**
```
$array = array(array(1,2,3),array(4,5,6),array(7,8,9));
```

## JSON ##
```
$grid->setSource(new Bvb_Grid_Source_Json($file, $loop, $columns));
```

Where

```
$file//Is the json location: http://zfdatagrid.com/feed/ or string
$loop //The node where the data you want to fetch.
$columns//The fields names. If null the node name will be used
```


## Excel File (xlsx) ##
You need to have the PHPExcel library installed in your system. You can get it from here: http://www.phpexcel.net
```
$grid->setSource(new Bvb_Grid_Source_PHPExcel_Reader_Excel2007($file, $sheet));
```

Where

```
$file//Is the file location
$sheet//The sheet name
```