# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary Templates



# Introduction #

The ability to customize table designs is a very common feature request.

Fortunately, ZFDatagrid has support for templates.

## Who uses templates? ##
At this moment templates are supported by

  * Tables
  * PDF
  * Print
  * Word
  * Word 2007
  * Open Document Text
  * Open Document Spreadsheet

## How do they work? ##

### First Step ###
Your template must extend the related `Bvb_Grid_Template_*` base template.

If you are creating a new template for a table you must declare your class like this:
```
class My_Template_Table extends Bvb_Grid_Template_Table{}
```

### Second Step ###
Register you template in the grid.

```
$grid->addTemplateDir('My/Template','My_Template','table') 
1. The dir location
2. The class name
3. Template type
```

#### Templates Types: ####
  * table
  * print
  * pdf
  * ods
  * odt
  * word
  * wordx

### Third Step ###
Define the template:
This can be as simple as:

```
$grid->setTemplate($templateName,$TemplateType(table, print, pdf));
```


### Passing Params to the template ###
Templates are classes without inheritance.

User defined information can be passed to the template via the following calls:

```
$grid->addTemplateParam('name','value');
```

```
$grid->addTemplateParams(array);
```

```
$grid->setTemplateParams(array);
```

<font color='red'>Attention</font>:**Using the set method, all previous params will be removed.**

### Getting Params from the Template ###
After setting the params you can access them within your template in the options property.

```
$myParams = $this->options['userDefined'];
```