# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary FAQ on usage of ZFDatagrid



# FAQ #

## Search ##

### Supported search operators ###
| Search field | SQL expression | Example | Match |
|:-------------|:---------------|:--------|:------|
| (default) starts `like` | `LIKE '%value%'` | `*`art`*` | art, star, start|
| starts `llike` | `LIKE '%value'` | `*`art  | art, smart, start|
| starts rlike | `LIKE 'value%'` | art`*`  | artifact, art|
| starts `equal`, `=` | `= value`      | =art    | art   |
| starts `>=`  | `>= value`     | >=12    | 12, 45, 57675|
| starts `>`   | `>` value      | >12     | 13, 235,456|
| starts `!=`, `<>` | `!=value`      | <>12    | 11, 13, 345|
| starts `<=`  | `<=value`      |<=12     | 1, 2,7,12|
| starts `<`   | `<value`       | <12     | 1, 4, 7, 11|
| contains `<>` | `BETWEEN value_left AND value_rigt` | 12<>25  | 13, 17, 19|
| contains `,` | `IN (value1,value2,value3)` | 1,45,67 | 1, 45, 67|

### How to disable search on particular field ###
```
$grid->updateColumn('_action', array(
    'search'=>false, // this will disable search
    'title'=>'Action',
    'width'=>100,
    'class'=>'bvb_action bvb_first',
    'callback'=>array(
        'function'=>array($this,'g1ActionBar'),
        'params'=>array('{{ID}}')
    ),
    'jqg'=>array('fixed'=>true)
));
```

### How to disable search? ###
```
$grid->setNoFilters(true);
```

## General ##
### How use callbacks ###
Eval functionality was removed in 0.6, use callback instead.

```
public function g1ActionBar($id) {
    $helper = new Zend_View_Helper_Url();
    $actions = array(
        array('href'=>$helper->url(array('action'=>'do', 'what'=>'view', 'id'=>$id)), 'caption'=>'View', 'class'=>'{view}'),
        array('href'=>$helper->url(array('action'=>'do', 'what'=>'edit', 'id'=>$id)), 'caption'=>'Edit', 'class'=>'{edit} fixedClass'),
        array('href'=>$helper->url(array('action'=>'do', 'what'=>'delete', 'id'=>$id)), 'caption'=>'Delete', 'class'=>'{delete}'),
        array('onclick'=>new Zend_Json_Expr('alert("this is js alert");'), 'caption'=>'Alert Me')
    );
    return Bvb_Grid_Deploy_JqGrid::formatterActionBar($actions);
}

...
// use callback
$grid->updateColumn('_action', array(
    //'order'=>1,
    'title'=>'Action',
    'width'=>100,
    'class'=>'bvb_action bvb_first',
    'callback'=>array(
        'function'=>array($this,'g1ActionBar'),
        'params'=>array('{{ID}}')
    ),
    'jqg'=>array('fixed'=>true)
));
// use anonymouse function 
$grid->updateColumn('District', array(
    'title'=>'District (ucase)',
    'callback'=>array(
        'function'=>create_function('$text', 'return strtoupper($text);'),
        'params'=>array('{{District}}')
    ),
));
```

### How to see executed DB queries ###
  * install [FirePHP](http://www.firephp.org/)
  * enable `Zend_Db_Profiler_Firebug` in your application, for example in application.ini
```
resources.db.params.profiler.enabled = true
resources.db.params.profiler.class = Zend_Db_Profiler_Firebug
```

How you should see `Zend_Db_Profiler_Firebug` message and if you click on it all executed queries. If you don't see the selects for first request, click on **Reload Grid** (you have set `bvbFirstDataAsLocal=false`).

### How to support export ###
You may handle export in a way that you handle the request. See [SiteController.php](http://code.google.com/p/zfdatagrid/source/browse/trunk/application/controllers/SiteController.php) example.

There is also another way to deal with exports. The main idea is to use **object factory pattern**. The factory will intercept exports and handle them.

Sometimes there is a need to customize columns based on export class (e.g. boolean formated to Yes/No) that is achieved by callback functions. This functionality should not be used to customize the SQL select based on export classes although it is possible.

The full example is in [JqgridController.php](http://code.google.com/p/zfdatagrid/source/browse/trunk/application/controllers/JqgridController.php).

```
function listAction()
{
    // construct JqGrid and let it configure
    $grid1 = Bvb_Grid_DataGrid::factory(
        'Bvb_Grid_Deploy_JqGrid', // this is the defualt grid class used to render on page
        array(
            'csv'=>array($this, 'configG1PostCsv') // do post config for Csv export
        )
    );
    $this->configG1($grid1, $this->_getParam('onlyFromPolynesia', 'false')==='true');
    // make sure that export to CSV is enabled
    $grid1->export = array(
        // define parameters for csv export, see Bvb_Grid_DataGrid::getExports
        'csv'=>array('caption'=>'Csv')
    );
    // pass grids to view and deploy() them there
    $this->view->g1 = $grid1->deploy();

    $this->render('index');
}
/**
 * This will run if we will export to Csv before deploy() and ajax() functions
 */
public function configG1PostCsv($grid)
{
    // we don't want this column in export
    $grid->updateColumn('_action', array('hide'=>true));
    // define output file name if needed
    $grid->setTitle('myExport');
}
/**
 * Main grid configuration function
 */
public function configG1($grid)
{
...
}
```

### Adding Javascript event does not work ###
Make sure you are using Zend\_Json\_Expr:

```
...
    'onclick'=>new Zend_Json_Expr('alert("you clicked on ID: "+jQuery(this).closest("tr").attr("id"));')
```

## Fields ##
### How to Disable order? ###

```
$grid->setNoOrder(true);
```