Use this package to simplify the process of data displaying.

## Upgrade ##
Check this page for [Info](Upgrade.md)


### **Important:** ###
> If you are using code from SVN please follow this twitter account [zfdatagrid](http://twitter.com/zfdatagrid) . New methods and changes that may affect your current code will be posted there.


---


|<font color='red'><strong>Demos</strong></font>|Contributors|
|:----------------------------------------------|:-----------|
|[Live demos](http://zfdatagrid.com/grid/) [Controller source code](http://zfdatagrid.com/grid/default/site/code)|[Check this page](Contributors.md)|





### Data Sources ###
|[Zend\_Db\_Select](Bvb_Grid_Source.md)|[Zend\_Db\_Table](Bvb_Grid_Source.md)|[Doctrine](Bvb_Grid_Source.md)|[Array](Bvb_Grid_Source.md)|[XML](Bvb_Grid_Source.md)|[Csv](Bvb_Grid_Source.md)|[Json](Bvb_Grid_Source.md)|
|:-------------------------------------|:------------------------------------|:-----------------------------|:--------------------------|:------------------------|:------------------------|:-------------------------|


### Renders ###
|[Table](Bvb_Grid_Deploy.md)|[Print](Bvb_Grid_Deploy.md)|[jqGrid](Bvb_Grid_Deploy_JqGrid.md)|[PDF](Bvb_Grid_Deploy.md)|[Word](Bvb_Grid_Deploy.md)|[Word 2007](Bvb_Grid_Deploy.md)|
|:--------------------------|:--------------------------|:----------------------------------|:------------------------|:-------------------------|:------------------------------|
|[Excel](Bvb_Grid_Deploy.md)|[Json](Bvb_Grid_Deploy.md) |[XML](Bvb_Grid_Deploy.md)          |[Open Flash Chart](Bvb_Grid_Deploy.md)|[ODF Text](Bvb_Grid_Deploy.md)|[ODF Spreadsheet](Bvb_Grid_Deploy.md)|

### Featuring... ###
|[Zend\_Config Support](Zend_Config_Support.md)|[CRUD Operations && Bulk actions auto-build](CRUD.md)|
|:---------------------------------------------|:----------------------------------------------------|
|[Custom && External Filters](Custom_Filters.md) |[Mass Actions](Mass_Actions.md)                      |
|[Template Based System](Templates.md)         |[Support for Extra Columns](Extra_Columns.md)        |
|[Support for Extra Rows](Extra_Rows.md)       |[Auto Pagination](Pagination.md)                     |
|[SQL aggregation expressions](SqlExpressions.md)|[Cache Support](Cache.md)                            |
|[Plugins for content format](Plugins.md)      |[Decorators](Decorators.md)                          |
|[Auto && Advanced filtering system](Filters.md)|[Fields sorting](Fields_Sorting.md)                  |
|[Conditional Fields Presentation](Bvb_Grid_Deploy_Table.md)|[Option for detailed view](Detailed_View.md)         |
|[PRG Form processing](PRG_Form.md)            |[Render specific parts separately (filters, titles, pagination, etc...)](Part_Render.md)|
|[Internationalization support](Internationalization.md)|[Configurable field titles](GridOptions#Title.md)    |
|[Column Grouping](GridOptions#hRow.md)        |[Ajax](Bvb_Grid_Deploy_Table.md)                     |
|[Conditional Fields Rendering](Conditional_Fields_Rendering.md)|[Multiple Instances per page (no conflicts at all...)](Multiple_Instances.md)|

##### Features Matrix #####
Please check the [Features Matrix](Features_Matrix.md) to know which options are available for each render class

#### Example ####
```
    function simpleAction()
    {

        //Grid Initialization
        $grid = Bvb_Grid::factory('Table');
        
        //Setting grid source
        $grid->setSource(new Bvb_Grid_Source_Zend_Table(new Bugs()));
        
        //Pass it to the view
        $this->view->grid = $grid; 
    }
```

## Options ##
Click here for a list of options that any field accepts [GridOptions](GridOptions.md)