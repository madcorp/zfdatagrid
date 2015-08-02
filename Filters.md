# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Manipulate how filters works...



# Introduction #

By default ZFDatagrid will try to provide the user the best way to filter results. Per example, if you have a _enum_ field in your database, instead a text input, a select menu will be presented to the user.



The field will be searched by the key and the user will see the value.

## CSS ##

### Class ###
```
$filters = new Bvb_Grid_Filters();        
$filters->addFilter('username',array('class'=>'my_class'));
$grid->addFilters($filters);   
```


### Style ###
```
$filters = new Bvb_Grid_Filters();        
$filters->addFilter('username',array('style'=>'margin:0px;'));
$grid->addFilters($filters);   
```


## Auto Filters ##


_Note:_ Place the example below between
```
$filters = new Bvb_Grid_Filters();        
//Examples below here...
$grid->addFilters($filters);   
```


### Distinct ###

One useful feature can be the distinct fields. Once specified the system will select all distinct values for a given field and then present them to the users as a dropdown menu. Making their life much more easy.


```
$filters->addFilter('username'=> array('distinct'=>array( 'field'=>'id' ,  'name'=>'username')));    
```

That will result in a SQL query like this:

```
SELECT id as key, name as value FROM <table> WHERE <previous conditions>
```

You can also define the field orientation

```
$filters->addFilter('username'=> array('distinct'=>array( 'field'=>'id' ,  'name'=>'username','order'=>'name ASC')));    
```


### Secondary Table ###
This will fetch all values from a secondary table and present them.
```
$filters->addFilter('FIELD', array('table' => array('table'=>'TABLE','field' => 'SELECT_VALUE', 'name' => 'SELECT_NAME', 'order' => 'name asc')));
```


### Manually (Array) ###

```
$filters->addFilter('username',array('values'=>array('key'=>'pairs','another'=>'value')));
```

**_Note:_** Order param accepts (field|name) (ASC|DESC). The first option is not the field name but the option key. The above code will order by username ASC.

## Show Filters in export ##
This option will add the curretn filters at the end of the document (PDF Only)
```
$grid->setShowFiltersInExport(true); 
```
Add Your own
```
$grid->setShowFiltersInExport(array('My'=>'Filter')); 
```
A merge with the filters values inserted by user will be made.



## Transform ##
This option is intended to modify the value provided by the user. In most cases it will be useful for date/time transformation, or currency

```
function my_function ($value)
{
   return str_replace("/","-",$value);
}

$filters = new Bvb_Grid_Filters();
$filters->addFilter('date',array('transform'=>'my_function'));
$grid->addFilters($filters);
```

If a user searches for _2010/12/12_ the value passed to your query will be _2010-12-12_

## Render ##
The render option allows you to render a specific type of field. As an example, date or number range selection.

By default you can use date, number, select, text

```
$filters->addFilter('date'=>array('render'=>'date'));
//This will render a date range selection
```

## Custom Filters ##

If you use JS libraries or if you have specific needs, you can build your own render type.

They must implement the Bvb\_Grid\_Filters\_Render\_RenderInterface but for commodity you can use the Bvb\_Grid\_Filters\_Render\_RenderAbstract class that already implements the interface and builds the common operations.

But you also need to define filters render location with the following code.

```
$grid->addFiltersRenderDir('My/Filters/Render/', 'My_Filters_Render');
```


One of the most common use will be to use it with a datePicker implementation.

As an example you can use the following code (assuming you already loaded jquery)

```
class My_Filters_Render_Date extends Bvb_Grid_Filters_Render_Table_Date{


public function render()
{
return '<span>' . $this->__('From:') . "</span>" .
                $this->getView()->datePicker(
                        $this->getFieldName() . '[from]',
                        "",
                        array(
                            'dateFormat' => 'yy-mm-dd',
                            'defaultDate' => $this->getDefaultValue('from'),
                        ),
                        array_merge($this->getAttributes(), array('id' => 'filter_' . $this->getFieldName() . '_from'))
                    ) .
                "<br><span>" . $this->__('To:') . "</span>" .
                $this->getView()->datePicker(
                        $this->getFieldName() . '[to]',
                        "",
                        array(
                            'dateFormat' => 'yy-mm-dd',
                            'defaultDate' => $this->getDefaultValue('to'),
                        ),
                        array_merge($this->getAttributes(), array('id' => 'filter_' . $this->getFieldName() . '_to'))
                );


}

}

```


And then in your filter

And then add your filter

```
$filters->addFilter('my_field', array('render' => 'date'));
```


## Callback ##
Using a callback will greatly improve you ability to enhance your filtering system


```
$filters->addFilter('lastname',array('callback'=>array('function'=>array($this,
'customFilter'),'params'=>array('XXX','YYY'))));
```

Along with the params you defined, 3 more ill be merged.

  * field => The field name
  * value => The field value
  * select => The select Object (Zend\_Db\_Select or other)

<font color='red'><b>ATTENTION:</b></font> Is YOUR responsibility to apply any condition to the select object

<font color='red'><b>ATTENTION2:</b></font> Any field not specified when adding filters will have search disabled.

### Please also check ###
Also check [Supported search operators](Faq#Supported_search_operators.md) and [Search](GridOptions#search.md), [searchType](GridOptions#searchType.md) and [GridOptions#searchTypeFixed](GridOptions#searchTypeFixed.md) options.