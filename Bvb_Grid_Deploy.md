# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Global Methods



# Methods #

## View ##
Alters the view used by the ZFDatagrid. The view is used for form elements rendering.

```
$grid->setView(Zend_View_Interface $view);
$grid->getView();
```

## Char Encoding ##
Defines the encoding to be used:

Defaults to utf8

```
$grid->setCharEncoding('encoding');
$grid->getCharEncoding();
```


## Params ##
Returns/sets/Removes params to the ZFdatagrid. Usually needed to change URL params
```
$grid->setParam('name','value');
$grid->setParams(array $params);

$grid->getParam('paramName');
$grid->getParams(array);

$grid->removeParam('param');
$grid->removeAllParams();
```

## Field(s) ##
Returns information about a field or fields

```
$grid->getField('field');
$grid->getFields($returnOptions = false);//Set to true to return all fields with options, and not only fields names.
```


## gridId ##
Method to retrieve grid's id defined in the constructor
_Note:_ You can't set a new id after grid initialization
```
$grid->getGridId();
```

## KeyEvents ##
Use this if you want filters to fire eith event "onChange"
```
$grid->setUseKeyEventsOnFilters(true);
```

## Filters In Export ##
You can want to show which filters where applied to get the current document (pdf only atm).
```
$grid->setShowFiltersInExport(true);
```

You can also add custom text to be printed by passing an array

```
$grid->setShowFiltersInExport(array('User'=>'Portugal'));
```

## Default Filters Values ##
Use this method to pre-filter results. Please note that user can remove this filters

```
$grid->setDefaultFiltersValues(array('filed'=>'value'))
```


## Save Params in Session ##
With this option set, grid will preserve filters, order, page and records per page.

```
$grid->saveParamsInSession(true);
```

The id is based on grid id. If not set the key action\_controller\_module will be used.

## Source ##
Returns the Source Object in use
```
$grid->getSource();
$grid->setSource(Bvb_Grid_Source_Interface $source);
```

## Primary Key(s) ##
This method returns a key=>pair array containing fields names and values that are primary key(s). Useful for use in decorators...

```
$grid->getPrimaryKeyFromUrl();//returns array
```


## Version ##
Returns the current ZFDatagrid version. If using SVN it will return the latest revision.

```
$grid->getVersion();
```


## Total Records ##
Returns the record number. This method can only be called after $grid->deploy();

```
$grid->getTotalRecords();
```


## Url ##
Returns the current url. Receives an option argument (string|array) with the elements to remove

```
#assuming url= http:///zfdatagrid.com/grid/basic/order/Name_Asc/start/15
$grid->getUrl();//Retuns /grid/basic/order/Name_Asc/start/15
$grid->getUrl('start');// Returns /grid/basic/order/Name_Asc
$grid->getUrl(array('start','order'));//Returns /grid/basic/
```


## Reset Column(s) ##
Use this method to reset all previous options defined for any field.

```
$grid->resetColumn('field');
$grid->resetColumns(array $fields);
```


## Update Column ##
Sets options for a column.
```
$grid->updateColumn('field',array('title'=>'Some title'));
```

**INFO:** Check this page for a list of all available options [Field Options](GridOptions.md)


## Escape Function ##
Sets the escape function to be applied to fields values.

```
$grid->setDefaultEscapeFunction('htmlentities');
$grid->setDefaultEscapeFunction(array('custom','function'));
```

## Export ##
Sets the available export options for the grid.

```
$grid->setExport(array('xml','odt','pdf','...'));
$grid->getExport();
```

## Default Filters ##
Defines the default filters to be applied to the grid. Please note the user can remove this filters
```
$grid-SetDefautFiltersValues(array('field'=>'pre-filter','field2'=>'another'));
```


## Pagination ##
Defines the number of records to be showed per page
```
$grid->setNumberRecordsPerPage(20);
```

## Will Show ##
This method will return an array with what will be shown.
```
$grid->willShow();//returns: form|form|form&grid
```

# No custom methods #

This list shows the deploy classes that don't accept any particularly method, apart from the construct() options. Check the available options [at the Zend\_Config page](Zend_Config_Support.md)

  * Print
  * PDF
  * Word
  * Wordx
  * Excel
  * OFC (Open Flash Chart)
  * ODT (Open Document Format Text)
  * ODS (Open Document Format Spreadsheet)
  * Json
  * XML

# With Custom Methods #
  * [Table](Bvb_Grid_Deploy_Table.md)
  * [OFC](Bvb_Grid_Deploy_OFC.md)
  * [jqGrid](Bvb_Grid_Deploy_JqGrid.md)

# About Exporting #
> Please note that if you are exporting for .docx, .odt or .ods formats and you library folder is not named _library_ you and you don't have defined the _APPLICATION\_PATH_ you must set the correct name using the
```
 $grid->setLibraryDir('/path/to/library');
```