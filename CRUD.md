# Note: This project has been moved to [zfdatagrid on GitHub](https://github.com/zfdatagrid/). #

#summary How CRUD operations works



<font color='red'><b>IMPORTANT:</b> Form elements are only built after passing your form instance to the grid with: <b>$grid->setForm(Bvb_Grid_Form $form)</b>. Only after this you can manage your form elements with <b>$grid->getForm(1)->getElement('element')->something()</b></font>

# How it works? #

By default the form is built based on table definition.

All data validation is auto added and forms fields are built based also on fields definition.

Bvb\_Grid\_Form is just a proxy for Zend\_Form or any other class that extends Zend\_Form.

You can define you form like this:

```
    $form = new Bvb_Grid_Form($class='Zend_Form', $options  =array()); //If you use your custom form class, change Zend_Form for your class. 
    //Remember that it needs to be an instance of Zend_From. The second argument is the options that will be passed to the class constructor().
```

You can define which operations are available for users:
```
    $form->setAdd(true|false);
    $form->setEdit(true|false);
    $form->setDelete(true|false);
```


You can optional add a _add_ button to the top of form by doing this:
```
    $form->setAddButton(true|false);
```


One interesting  thing is that you may use Zend\_Form just to validating your data and then do something else with it then saving it to a database.
You can do that by defining this:

```
    $form->setIsPerformCrudAllowed(false);//Won't insert any data to the source when performing any operation
    $form->setIsPerformCrudAllowedForAddition(true|false); //Won't insert any data when adding new data
    $form->setIsPerformCrudAllowedForEdition(true|false); //Won't update any data when editing
    $form->setIsPerformCrudAllowedForDeletion(false); //Won't delete any data when deleting a record
```

Data recording is inside a try{}catch{} block, so you can throw an exception within your callbacks (see below) to make the validation fail.

What if you don't want a specific field?

You can include or exclude fields from the form by setting this:
```
    $form->setAllowedFields(array('times','next'));//Only this fields will appear in the form
    $form->setDisallowedFields(array('time','next'));//This fields won't appear in the form
    $form->setFieldsBasedOnQuery(true|false); //Only the fields from the query will be in the form
```


And then we need to add the form to our grid
```
    $grid->setForm($form);
```


After adding the form you can get it by doing:
```
    $grid->getForm(1); 
```

And do whatever you want with it.
```
    $grid->getForm(1)->getElement('my_field')->setValue('value');
```

_Why the number 1 when getting the form instance?_

Because ZFDatagrid now supports bulk actions. every record is now a subForm.

You can achieve the same result of

```
    $grid->getForm()->getSubForm(1);
```

Forms are numbered starting in one.


## Bulk Actions ##
Setting up bulk actions it's incredible easy. All you have to do is:

```
    $form = new Bvb_Grid_Form();
    $form->setBulkAdd(2)->setBulkDelete(true)->setBulkEdit(true)->setAdd(true)->setEdit(true)->setDelete(true)->setAddButton(true);
    $grid->setForm($form);
    //Replace the number _2_ for the number of forms you want to display. 
```


## Different Table ##
If you want to manually override the table where values will be inserted, use:
```
    $form->setTable(string $table);
```

## Special Features ##
There are a few special methods that may be very, very useful to a lot o us.

Imagine that you have an ACL based system and that a record with the id 14 can only be removed by an admin.

But I have an id to be removed in the URL. So what stops me to rename the id? Nothing.

We can't prevent this behavior but we can make it useless by forcing some values to be added to the condition.
```
$form->setOn(Delete|Edit)AddCondition(array('user'=>'12'));
//This will execute the query:
//DELETE FROM table where id = '14' AND user='12';
```

Other thing we may need is to force some fields to be filled by values that cannot be set by the user.
The most common example is the user id.
We can do achieve that by doing:
```
$form->setOn(Add|Edit)Force(array('user_id'=>1));
```

The above code will add another field to the data being submitted.

### Disable CSRF ###
This method won't create a hash element to valid form input. Please use this method wisely.
```
$form->setUseCSRF(false);
```

### Disable Columns for CRUD operations ###
You may want to remove those extra columns auto created when defining crud operations.

Use to remove the columns and button:

```
$form->setEditColumn(false);
$form->setDeleteColumn(false);
$form->setaddButton(false);
```

and then you can use this tags in your decorators

{{addUrl}}
{{editUrl}}
{{deleteUrl}}

### Define input type ###
You can change de input type created by default by ZFDG using the $form->setInputsType() method

```
$form->setInputsType('bug_description'=>'textarea','user_password'=>'passowrd'); 
```

# Default Decorators #
To speed things up, default decorators are used and use the table>tr>td layout.

```
    groupDecorator = array('FormElements', array('HtmlTag', array('tag' => 'td', 'colspan' => '2', 'class' => 'buttons')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    subformGroupDecorator = array('FormElements', array('HtmlTag', array('tag' => 'td', 'colspan' => '90', 'class' => 'buttons')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    elementDecorator = array('ViewHelper', 'Description', 'Errors', array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')), array(array('label' => 'Label'), array('tag' => 'td')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    subformElementDecorator = array('ViewHelper', 'Description', 'Errors', array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')), array(array('label' => 'Label'), array('tag' => 'td','class'=>'elementTitle')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    subformElementTitle = array(array('Label', array('tag' => 'th')));

    subformElementDecoratorVertical = array('ViewHelper', 'Description', 'Errors', array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')));

    fileDecorator = array('File', 'Description', 'Errors', array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')), array(array('label' => 'Label'), array('tag' => 'td')), array(array('row' => 'HtmlTag'), array('tag' => 'tr')));

    buttonHiddenDecorator = array('ViewHelper');

    formDecorator = array('FormElements', array('HtmlTag', array('tag' => 'table', 'style' => 'width:99%')), 'Form');

    subFormDecorator = array('FormElements', array('HtmlTag',array('tag' => 'table', 'style' => 'margin-bottom:5px; width:100%', 'class' => 'borders')));

    subFormDecoratorVertical = array('FormElements', array('HtmlTag', array('tag' => 'tr')));

```

## Change Decorators ##

If you want to change your decorators use the following methods.
_**NOTE:**_ You must change the decorators before adding the form to the grid,
```
$form->(set|get)groupDecorator();
$form->(set|get)elementDecorator();
$form->(set|get)buttonHiddenDecorator();
$form->(set|get)formDecorator();
```


# Callbacks #

Callbacks will be performed before and after any action in the source.

The callback function will receive two arguments, first the data that will be inserted and second the source instance
```
$form->setCallbackBeforeDelete ($callback)
$form->setCallbackBeforeUpdate ($callback)
$form->setCallbackBeforeInsert ($callback)
$form->setCallbackAfterDelete ($callback)
$form->setCallbackAfterUpdate ($callback)
$form->setCallbackAfterInsert ($callback)
```