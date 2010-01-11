<?php
/**
 * ZFDatagrid
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license
 * It is  available through the world-wide-web at this URL:
 * http://www.petala-azul.com/bsd.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to geral@petala-azul.com so we can send you a copy immediately.
 *
 * @package    Bvb_Grid
 * @copyright  Copyright (c) XTmotion Limited (http://www.xtmotion.co.uk/)
 * @license    http://www.petala-azul.com/bsd.txt   New BSD License
 * @version    $Id$
 * @author     k2s (Martin Minka) <martin.minka@gmail.com>
 */

/** Zend_Json */
require_once 'Zend/Json.php';

/** Zend_Controller_Front */
require_once 'Zend/Controller/Front.php';

class Bvb_Grid_Deploy_JqGrid extends Bvb_Grid_DataGrid
{
    /**
     * URL path to place where JqGrid library resides
     *
     * @var string
     */
    public static $defaultJqGridLibPath = "public/scripts/jqgrid";
    /**
     * URL path to place where JqGrid library resides
     *
     * @var string
     */
    public static $defaultActionClasses = array(
        '{edit}'   => 'ui-icon ui-icon-pencil',
        '{delete}' => 'ui-icon ui-icon-trash',
        '{view}'   => 'ui-icon ui-icon-search'
    );

    /**
     * Default options for JqGrid
     *
     * @var array
     */
    protected $_jqgDefaultParams = array(
        'mtype' => 'POST', // GET will not work because of our parsing
        'height' => 'auto',
        'autowidth' => true,
        'rownumbers' => true,
        'gridview' => true,
        'multiselect' => false,
        'viewrecords' => true,
        'imgpath' => "themes/basic/images",
        'caption' => '',
        'loadError' => 'function(xhr,st,err) { if (xhr.status!=200) {alert(xhr.statusText);} }',
    );
    /**
     * Options defined for jqGrid object
     *
     * @see http://www.trirand.com/jqgridwiki/doku.php?id=wiki:options
     *
     * @var array
     */
    private $_jqgParams = array();
    /**
     * Bvb_Grid_Deploy_JqGrid own options to apply
     *
     * @var array
     */
    private $_bvbParams = array();
    /**
     * Options to apply by navGrid
     * // TODO maybe not needed
     * @var array
     */
    private $_navGridParams = array();

    // TODO rename this property ? It is Bvb related
    private $_jqgOnInit = array();

    /**
     * List of commands to execute after the jqGrid object is initiated
     *
     * @var array
     */
    private $_postCommands = array();
    /**
     * List of custon buttons to be shown on navigation bar
     *
     * @var array
     */
    private $_navButtons = array();

    /**
     * Constructor
     *
     * @param array $options configuration options
     */
    function __construct ($options = null)
    {
        $this->initLogger();

        parent::__construct();

        // TODO fix for property with same name in Bvb_Grid_DataGrid
        $this->_view = null;

        // prepare request parameters sent by jqGrid
        $this->ctrlParams = array();
        $this->convertRequestParams();
    }
    /**
     * Call this in controller (before any output) to dispatch Ajax requests.
     *
     * @param string $gridId ID to recognize the request from multiple tables ajax request will be ignored if FALSE
     *
     * @return void
     */
    function ajax($gridId)
    {
        $this->setId($gridId);
        // if request is Ajax we should only return data
        if (false!==$gridId && $this->isAjaxRequest()) {
            // prepare data
            parent::deploy();
            // set data in JSON format
            $response = Zend_Controller_Front::getInstance()->getResponse();
            if (!self::$debug) {
                $response->setHeader('Content-Type', 'application/json');
            }
            $response->setBody($this->renderPartData());
            // send logged messages to FirePHP
            Zend_Wildfire_Channel_HttpHeaders::getInstance()->flush();
            // send the response now and end request processing
            $response->sendResponse();
            exit;
        }
    }
    /**
     * Set jQuery Grid options (merging with old options)
     *
     * @param array $options set JqGrid options (@see http://www.trirand.com/jqgridwiki/doku.php?id=wiki:options)
     *
     * @return Bvb_Grid_Deploy_JqGrid
     *
     */
    public function setJqgParams(array $options)
    {
        // TODO bad name, use the same as in ZendX_Jquery
        // TODO also dangerouse that it will call set functions for general Bvb class
        $this->_jqgParams = array(); //$this->_jqgDefaultParams;

        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'jqgSet' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            } else {
                $this->_jqgParams[$key] = $value;
            }
        }
        return $this;
    }
    /**
     * Set value to one parameter from jqGrid domain
     *
     * @param string $var   name of property to set with value
     * @param mixed  $value value
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    public function setJqgParam($var, $value)
    {
        $this->_jqgParams[$var] = $value;
        return $this;
    }
    /**
     * Return value of parameter from jqGrid domain
     *
     * @param string $var variable name
     * @param mixed  $default value to return if option is not set
     *
     * @return mixed
     */
    public function getJqgParam($var, $default = null)
    {
        return isset($this->_jqgParams[$var]) ? $this->_jqgParams[$var] : $default;
    }
    /**
     * Set Bvb_Grid_Deploy_JqGrid own options (merging with old options)
     *
     * @param array $options set Bvb_Grid_Deploy_JqGrid
     *
     * @return Bvb_Grid_Deploy_JqGrid
     *
     */
    public function setBvbParams(array $options)
    {
        // TODO bad name, use the same as in ZendX_Jquery
        // TODO also dangerouse that it will call set functions for general Bvb class
        $this->_bvbParams = array(); //$this->_jqgDefaultParams;

        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'bvbSet' . ucfirst($key);
            if (in_array($method, $methods)) {
                $this->$method($value);
            } else {
                $this->_bvbParams[$key] = $value;
            }
        }
        return $this;
    }
    /**
     * Set value to one parameter from Bvb_Grid_Deploy_JqGrid domain
     *
     * @param string $var   name of property to set with value
     * @param mixed  $value value
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    public function setBvbParam($var, $value)
    {
        $this->_bvbParams[$var] = $value;
        return $this;
    }
    /**
     * Return value of parameter from Bvb_Grid_Deploy_JqGrid domain
     *
     * @param string $var     variable name
     * @param mixed  $default value to return if option is not set
     *
     * @return mixed
     */
    public function getBvbParam($var, $default = null)
    {
        return isset($this->_bvbParams[$var]) ? $this->_bvbParams[$var] : $default;
    }
    /**
     * Will add passed javascript code inside anonymouse function.
     *
     * Following variables are accessible in that function:
     * this  - jqgrid DOM object
     * grid  - jqGrid object
     *
     * @param string $javaScript javascript will be included into funcion
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    public function bvbSetOnInit($javaScript)
    {
        $this->_jqgOnInit[] = $javaScript;
        return $this;
    }
    /**
     * Removes all javascript code added by calls to setJqgOnInit()
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    public function bvbClearOnInit()
    {
        // TODO __call function in Bvb_Grid_DataGrid should ignore such call
        $this->_jqgOnInit = array();
        return $this;
    }
    /**
     * Add export action buttons to grid
     *
     * @param array $types names of deploy classes
     *
     * @return void
     */
    protected function addExportButtons(array $types)
    {
        // TODO not ok links
        foreach ($types as $export=>$url) {
            $this->jqgAddNavButton(
                array(
                    'caption' => $export,
                    'buttonicon' => "ui-icon-extlink",
                    'onClickButton' => new Zend_Json_Expr(<<<JS
function() {
    newwindow = window.open("$url",'$export Export','');
    if (window.focus) {
        newwindow.focus();
    }
    return false;
}
JS
                    ),
                    'position' => "last"
                )
            );
        }
        return $this;
    }
    /**
     * Build grid. Will output HTML definition for grid and add js/css to view.
     *
     * @return string output this sting to place in view where you want to display the grid
     */
    function deploy()
    {
        // prepare internal Bvb data
        parent::deploy();
        // prepare access to view
        $view = $this->getView();
        // defines ID property of html tags related to this jqGrid
        $id = $this->getId();

        // initialize jQuery
        $this->jqInit();
        // prepare options used to build jqGrid element
        $this->prepareOptions();
        // build definition of columns, which will manipulate _options
        $this->_jqgParams['colModel'] = $this->jqgGetColumnModel();
        // build final JavaScript code and return HTML code to display
        $this->jqAddOnLoad($this->renderPartJavascript());
        return $this->renderPartHtml();
    }
    /**
     * Return javascript part of grid
     *
     * @return string
     */
    public function renderPartJavascript()
    {
        // ! this should be the last commands (it is not chainable anymore)
        foreach ($this->_navButtons as $btn) {
            $this->_postCommands[] = sprintf("navButtonAdd('#%s', %s)", $this->jqgGetIdPager(), self::encodeJson($btn));
        }
        if (!$this->getBvbParam('firstDataAsLocal', true)) {
            // first data will be loaded via ajax call
            $data = array();
            $this->_jqgParams['datatype'] = "json";
        } else {
            // set first data without ajax request
            $data = $this->renderPartData();
            $this->_jqgParams['datatype'] = "local";
            $this->_postCommands[] = 'setGridParam({datatype:"json"})';
            $this->_postCommands[] = 'jqGrid()[0].addJSONData(myData)';
        }
        // combine the post commands into JavaScrip string
        if (count($this->_postCommands)) {
            $postCommands = '.' . implode("\n.", $this->_postCommands);
        }
        // convert options to javascript
        $options = self::encodeJson($this->_jqgParams);
        // build javascript text
        $idtable = $this->jqgGetIdTable();
        $idpager = $this->jqgGetIdPager();
        $js = <<<EOF
var myData = $data;
jQuery("#$idtable").jqGrid(
$options
)
$postCommands
;
EOF;
        // add users javascript code (something like ready event)
        if (count($this->_jqgOnInit)>0) {
            $cmds = implode(PHP_EOL, $this->_jqgOnInit);
            $js .= PHP_EOL . <<<JS
jQuery("#$idtable").each(function () {
    var grid = jQuery(this).jqGrid();
    $cmds
});
JS;
        }
        return $js;
    }
    /**
     * Return html part of grid
     *
     * @return string
     */
    public function renderPartHtml()
    {
        $idtable = $this->jqgGetIdTable();
        $idpager = $this->jqgGetIdPager();
        $html = <<<HTML
<table id="$idtable">
    <tr><td></td></tr>
</table>
<div id="$idpager"></div>
HTML;
        return $html;
    }
    /**
     * Return data in JSON format
     *
     * @return string
     */
    function renderPartData()
    {
        // clarify the values
        $page = $this->ctrlParams ['page']; // get the requested page
        $limit = $this->pagination; // get how many rows we want to have into the grid
        $count =  $this->_totalRecords;
        // decide if we should pass PK as ID to each row
        $passPk = false;
        if (isset($this->_bvbParams['id']) && count($this->_result)>0) {
            $pkName = $this->_bvbParams['id'];
            if (isset($this->_result[0]->$pkName)) {
                // only if that field exists
                $passPk = true;
            } else {
                $this->log(
                    "field '$pkName' defined as jqg>reader>id option does not exists in result set",
                    Zend_Log::WARN
                );
            }
        }
        // build rows
        $data = new stdClass();
        $data->rows = array();
        foreach (parent::buildGrid() as $i=>$row) {
            $dataRow = new stdClass();
            // collect data for cells
            $d = array();
            foreach ( $row as $key=>$val ) {
                $d[] = $val['value'];
            }
            if ($passPk) {
                // set PK to row
                // TODO works only if buildGrid() results are in same order as $this->_result
                $dataRow->id = $this->_result[$i]->$pkName;
            }
            $dataRow->cell = $d;
            $data->rows[] = $dataRow;
        }
        // set some other information
        if ($count >0) {
            $totalPages = ceil($count/$limit);
        } else {
            $totalPages = 0;
        }
        $data->page = $page;
        $data->total = $totalPages;
        $data->records = $count;

        return Zend_Json::encode($data);
    }
    /**
     * Consolidate all settings to know how to render the grid
     *
     * Options are set on grid level by:
     * 1. javascript options passed to jqGrid (?)
     * 2. special Bvb_Grid_Deploy_JqGrid options (jqg array)
     * 3. standard Bvb settings
     *
     * Options are set on column level by:
     * 1. javascript options passed to columns (?)
     * 2. special Bvb_Grid_Deploy_JqGrid options (jqg array)
     * 3. standard Bvb settings
     * 4. formaters (?)
     *
     * @return void
     */
    public function prepareOptions()
    {
        $id = $this->getId();
        // build URL where to receive data from
        $url = $this->getView()->serverUrl(true) . "?q=$id";

        // initialize table with default options
        ////////////////////////////////////////
        $this->_jqgParams += $this->_jqgDefaultParams;
        // prepare navigation
        $this->_postCommands[] = sprintf(
            "navGrid('#%s',{edit:false,add:false,del:false,search:false,view:true})",
            $this->jqgGetIdPager()
        );

        // override with options explicitly set by user
        ///////////////////////////////////////////////

        // override with options defined on Bvb_Grid_DataGrid level
        ///////////////////////////////////////////////////////////
        $this->_jqgParams['url'] = $url;
        $this->_jqgParams['pager'] = new Zend_Json_Expr(sprintf("'#%s'", $this->jqgGetIdPager()));
        $this->_jqgParams['rowNum'] = $this->pagination;

        if (!$this->getInfo('noFilters', false)) {
            // add filter toolbar to grid - if not set $grid->noFilters(1);
            $this->_postCommands[] = 'filterToolbar()';
            $this->jqgAddNavButton(
                array(
                    'caption' => $this->__("Toggle Search"),
                    'title' => $this->__("Toggle Search Toolbar"),
                    'buttonicon' => 'ui-icon-pin-s',
                    'onClickButton' => new Zend_Json_Expr("function(){ jQuery(this)[0].toggleToolbar(); }")
                )
            );
        }

        if ($this->getInfo('noOrder', false)) {
            // dissable sorting on columns - if set $grid->noOrder(1);
            $this->_jqgParams['viewsortcols'] = array(false,'vertical',false);
        }
        // add export buttons
        $this->addExportButtons($this->export);
    }
    /**
     * Encode Json that may include javascript expressions.
     *
     * Take care of using the Zend_Json_Encoder to alleviate problems with the json_encode
     * magic key mechanism as of now.
     *
     * @param mixed $value value to encode
     *
     * @see Zend_Json::encode
     *
     * @return mixed
     */
    public static function encodeJson($value)
    {
        return Zend_Json::encode($value, false, array('enableJsonExprFinder' => true));
    }
    /**
     * Loads jQuery related libraries needed to display jqGrid.
     *
     * ZendX_Jquery is used as default, but this could be overriden.
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    public function jqInit()
    {
        $jqgridLibPath = $this->getJqGridLibPath();
        $this->getView()->jQuery()
            ->enable()
            ->uiEnable()
            ->addStylesheet($jqgridLibPath . "/css/ui.jqgrid.css")
            // TODO locale should be configurable
            ->addJavascriptFile($jqgridLibPath . '/js/i18n/grid.locale-en.js')
            ->addJavascriptFile($jqgridLibPath . '/js/jquery.jqGrid.min.js');
        return $this;
    }
    /**
     * Return URL where jqGrid library is located (it has js and css folders under it).
     *
     * @return string
     */
    public function getJqGridLibPath()
    {
        return self::$defaultJqGridLibPath;
    }
    /**
     * Add JavaScript code to be executed when jQuery ready event
     *
     * ZendX_Jquery is used as default, but this could be overriden.
     *
     * @param string $js javascipt code to add
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    public function jqAddOnLoad($js)
    {
        $this->getView()->jQuery()->addOnLoad($js);
        return $this;
    }
    /////////////////////
    /**
     * Add action button to navigation bar
     *
     * @param array $button options for JqGrid custom button
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    public function jqgAddNavButton($button)
    {
        $this->_navButtons[] = $button;
        return $this;
    }
    /**
     * Return colModel property for jqGrid
     *
     * @return array
     */
    public function jqgGetColumnModel()
    {
        $model = array();

        //BVB grid options
        $skipOptions = array(
            'title',     // handled in parent::buildTitles()
            'hide',      // handled in parent::buildTitles()
            'sqlexp',
            'hRow',
            'eval',
            'callback',
            'searchType',
            'format',
            'jqg' // we handle this separately
        );

        $titles = $this->buildTitles();
        $fields = $this->removeAsFromFields();
        foreach ($titles as $key=>$title) {
            // basic options
            $options = array("name" => $title['name'], "label" => $title['value']);
            // add defined options
            if (isset($fields[$key])) {
                if (isset($fields[$key]['class'])) {
                    // convert Bvb class option to jqGrid classes option
                    // TODO maybe move to prepareOptions()
                    if (!isset($fields[$key]['jqg'])) {
                        $fields[$key]['jqg'] = array();
                    }
                    $fields[$key]['jqg']['classes'] = $fields[$key]['class'];
                    unset($fields[$key]['class']);
                }
                foreach ($fields[$key] as $name=>$value) {
                    if ( in_array($name, $skipOptions)) {
                        continue ;
                    }
                    // TODO hm, this should never happen
                    $this->log("unknown option: ".$name);
                    $options[$name] = $value;
                }
                if (isset($fields[$key]['jqg'])) {
                    // we apply jqg options after all other options
                    // see http://www.trirand.com/jqgridwiki/doku.php?id=wiki:colmodel_options
                    foreach ($fields[$key]['jqg'] as $name=>$value) {
                        $options[$name] = $value;
                    }
                }
            } else {
                $this->log("why there is no key $key in fields ?");
            }
            // add field to model
            $model[] = $options;
        }

        return $model;
    }
    /**
     * Return ID for pager HTML element
     *
     * @return string
     */
    public function jqgGetIdPager()
    {
        return "jqg_pager_" . $this->getId();
    }
    /**
     * Return ID for pager HTML element
     *
     * @return string
     */
    public function jqgGetIdTable()
    {
        return "jqg_" . $this->getId();
    }
    ///////////////////////////////////////////////// Following functions could go to Bvb_Grid_DataGrid
    /////////////////////////////////////////////////
    // @codingStandardsIgnoreStart
    /**
     * Not defined in Bvb_Grid_DataGrid, but used there
     *
     * @var string
     */
    protected $output = 'jqgrid';
    // @codingStandardsIgnoreEnd
    /**
     * @see Bvb_Grid_DataGrid::$export
     */
    public $export = array();
    /**
     * @var Zend_View_Interface
     */
    protected $_view = null;
    /**
     * Ajax ID
     * @var string
     */
    protected $_id = 0;
    /**
     *
     * @var unknown_type
     */
    protected $_logger = null;
    /**
     * Set to true if you want to debug this class
     *
     * @var unknown_type
     */
    public static $debug = false;

    /**
     * Set view object
     *
     * @param Zend_View_Interface $view view object to use
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    public function setView(Zend_View_Interface $view = null)
    {
        $this->_view = $view;
        return $this;
    }

    /**
     * Retrieve view object
     *
     * If none registered, attempts to pull from ViewRenderer.
     *
     * @return Zend_View_Interface|null
     */
    public function getView()
    {
        if (null === $this->_view) {
            include_once 'Zend/Controller/Action/HelperBroker.php';
            $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
            $this->setView($viewRenderer->view);
        }

        return $this->_view;
    }
    /**
     * Use to detect if we should return plain JSON data or full table definition
     *
     * @return boolean
     */
    protected function isAjaxRequest()
    {
        return Zend_Controller_Front::getInstance()->getRequest()->isXmlHttpRequest()
            || isset($this->ctrlParams['_search']);
    }
    /**
     * Return value used to build HTML element ID attributes
     *
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }
    /**
     * Set value used to build HTML element ID attributes
     *
     * @param string $id text to apply as part of jqGrid HTML element IDs
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }
    /**
     * Create Zend_Log object used to debug Bvb classes
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    protected function initLogger()
    {
        if (self::$debug) {
            // send messages to FirePHP
            $writter = new Zend_Log_Writer_Firebug();
        } else {
            // we need to have at least dummy instance of Zend_Log
            $writter = new Zend_Log_Writer_Null();
        }
        $this->_logger = new Zend_Log($writter);
        return $this;
    }
    /**
     * Log message. Per default the message will be sent to FirePHP.
     *
     * @param string $message  message to log
     * @param int    $priority one of Zend_Log constances, Zend_Log::DEBUG is default
     *
     * @return Bvb_Grid_Deploy_JqGrid
     */
    protected function log($message, $priority = 7)
    {
        $this->_logger->log($message, $priority);
        return $this;
    }
    /**
     * Handle parameters send from frontend.
     *
     * They could contain:
     * - number of rows to be shown on page
     * - first row to show on page
     * - sort order
     * - search filters
     *
     * @param array $params parameters to conver, request parameters will be used of not set
     *                      this array should always contain Zend parameters module, controller, action
     *
     * @return void
     */
    protected function convertRequestParams($params=null)
    {
        if (is_null($params)) {
            $params = Zend_Controller_Front::getInstance()->getRequest()->getParams();
        }

        // we try to convert jqGrid request to be Bvb ctrlParms compatible
        //////////////////////////////////////////////////////////////////

        // add Zend parameters
        $this->ctrlParams['module'] = $params['module'];
        $this->ctrlParams['controller'] = $params['controller'];
        $this->ctrlParams['action'] = $params['action'];

        // number of rows to be shown on page, could be changed in jqGrid
        if (isset($params['rows'])) {
            $this->setPagination($params['rows']);
        }

        // first row to display
        if (isset($params['page'])) {
            $page = $params['page'];
        } else {
            $page = 1;
        }
        $this->ctrlParams['page'] = $page;
        $this->ctrlParams['start'] = $this->pagination * ($page-1);

        // sort order
        $sidx = isset($params['sidx']) ? $params['sidx'] : "";
        $sord = isset($params['sord']) ? $params['sord'] : "asc";
        if ($sidx!=="") {
            $this->ctrlParams['order'] = $sidx . '_' . strtoupper($sord);
        }

        // filters
        // TODO it would be great to have some methods to define more complicated filters
        if (isset($params['_search']) && $params['_search']) {
            if (isset($params['filters'])) {
                // TODO Advanced searching
                // see http://www.trirand.com/jqgridwiki/doku.php?id=wiki:advanced_searching&s[]=multiplesearch
                // http://www.ong.agimondo.it/extras/jq/search_adv.php
            } elseif (isset($params['searchField'])) {
                // TODO Single searching format
                // see http://www.trirand.com/jqgridwiki/doku.php?id=wiki:singe_searching&s[]=multiplesearch
            } else {
                // Toolbar Searching
                // see http://www.trirand.com/jqgridwiki/doku.php?id=wiki:toolbar_searching&s[]=searchoptions
                $flts = new stdClass();
                $filteredFields = array_diff_key(
                    $params,
                    array_flip(
                        array('q', 'nd', 'rows', 'page', 'sidx', 'sord', '_search', 'module', 'controller', 'action')
                    )
                );
                foreach ($filteredFields as $filter=>$val) {
                    $flts->$filter = $val;
                }
                $this->ctrlParams['filters'] = urlencode(Zend_Json::encode($flts));
            }
        }
    }
   /**
     * Function to format action links
     *
     * @param mixed $actions definition of links to action
     *                       all parameters will be added as HTML attributes to link except:
     *                       caption: will be placed between <a><span>$caption</span></a>
     *                       class: predefined variables {edit}, {delete}, {view} will be replaced with jQuery UI classes
     *                       img: could be array and will be extracted as HTML attributes to <img> tag
     *
     * @return string
     */
    public static function formatterActionBar($actions)
    {
        // TODO this should be Bvb_Formatter class and it should not be static there
        //$actionClasses = $this->getActionClasses();
        $actionClasses = self::$defaultActionClasses;
        $html = "";
        foreach ($actions as $a) {
            $htmlAtts = array();
            if (isset($a['class'])) {
                // support predefined CSS classes
                $class = trim(str_replace(
                    array_keys($actionClasses),
                    $actionClasses,
                    $a['class']
                ));
                if (!empty($class)) {
                    $a['class'] = $class;
                }
            }

            if (isset($a['caption'])) {
                // handle caption
                $caption = $a['caption'];
                unset($a['caption']);
            }

            if (isset($a['img'])) {
                // TODO if we pass link to image to show instead of text
            } else {
                // will show text or icon if CSS class is styled
                $htmlAtts = array_merge($a, array('style'=>"float:left;"));
                $htmlAtts = self::htmlAttribs($htmlAtts);
                $html .= "<a $htmlAtts><span>$caption</span></a>";
            }
        }
        return $html;
    }
    /**
     * Converts an associative array to a string of tag attributes.
     *
     * This function is clone from Zend_View_Helper_HtmlElement
     *
     * @access public
     *
     * @param array $attribs From this array, each key-value pair is
     * converted to an attribute name and value.
     *
     * @return string The XHTML for the attributes.
     */
    public static function htmlAttribs($attribs)
    {
        $view = new Zend_View();
        $xhtml = '';
        foreach ((array) $attribs as $key => $val) {
            $key = $view->escape($key);

            if (('on' == substr($key, 0, 2)) || ('constraints' == $key)) {
                // Don't escape event attributes; _do_ substitute double quotes with singles
                if (!is_scalar($val)) {
                    // non-scalar data should be cast to JSON first
                    require_once 'Zend/Json.php';
                    $val = self::encodeJson($val);
                }
                $val = preg_replace('/"([^"]*)":/', '$1:', $val);
            } else {
                if (is_array($val)) {
                    $val = implode(' ', $val);
                }
                $val = $view->escape($val);
            }
            /*
            if ('id' == $key) {
                $val = $this->_normalizeId($val);
            }
            */

            if (strpos($val, '"') !== false) {
                $xhtml .= " $key='$val'";
            } else {
                $xhtml .= " $key=\"$val\"";
            }

        }
        return $xhtml;
    }
    /**
     * Configuration magic
     *
     * @param string $var   name of property to set with value
     * @param mixed  $value value
     *
     * @return void
     */
    public function __set($var, $value)
    {
        // check what domain parameter it is
        $domain = substr($var, 0, 3);
        if (strlen($var)>3 && $var[3]===strtoupper($var[3]) && 0===strcmp($domain, strtolower($domain))) {
            // it is valid domain
            $variableName = substr($var, 3);
            $setterName = $domain."Set".$variableName;
            if (method_exists($this, $setterName)) {
                // there is dedicated setter function for this option
                $this->$setterName($value);
                return;
            }

            $variableName[0] = strtolower($variableName[0]);
            $setterName = "set".ucfirst($domain)."Param";
            if (method_exists($this, $setterName)) {
                // there is setter function for this domain
                $this->$setterName($variableName, $value);
                return;
            }
        }
        // not a domain property
        parent::__set($var, $value);
    }
    // TODO __get()
}