<?php
namespace config;

use config\lib\conf;

class lss {
    #用于判断类是否存在，节约性能
    public static $classMap = array();

    private $templateDir;#存储模板引擎源文件的所在目录
    private $compileDir;#存储编译之后文件的存放目录
    private $template = array();#模板需要替换的变量,做标记
    private $leftTag;#模板需要替换的变量,做标记
    private $rightTag;
    private $viewCss;
    private $currentTemp = '';#存储当前正在编译的模板文件
    private $outputHtml;#存放当前正在编译中的html代码
    private $assign = array();#把模板中需要用到的变量放到改模板中使用

    public function __construct($leftTag=null,$rightTag=null){
        $this->templateDir = APP.'/views/';
        $this->compileDir = _PUBLIC.'/views/';

        $this->template = conf::get('template','config');
        $this->leftTag = !empty($leftTag) ? $leftTag : $this->template['leftTag'];
        $this->rightTag = !empty($rightTag) ? $rightTag : $this->template['rightTag'];
        $this->viewCss = $this->template['viewCss'];
        session_start();
    }

    /**
     * 自动加载类
     * @param $class
     * @return bool
     */
    static public function load($class){
        if (isset($classMap[$class])){
            return true;
        }else{
            $class = str_replace('\\','/',$class);
            $file = LSS.'/'.$class.'.php';

            if (is_file($file)){
                include $file;
                self::$classMap[$class] = $class;
            }else{
                return false;
            }
        }
    }

    /**
     * 运行控制器和方法
     * @throws \Exception
     */
    static public function run(){
        \config\lib\log::init();//确定日志存储方式

        $route =new \config\lib\route();
        $ctrlClass = $route->ctrl;
        $action = $route->action;
        $ctrlFile = APP.'/controller/'.$ctrlClass.'.php';#控制器文件
        $ctrlClass1 = '\\'.MODULE.'\controller\\'.$ctrlClass;
        if (is_file($ctrlFile)){
            include $ctrlFile;
            $ctrl = new $ctrlClass1();
            echo $ctrl->$action();
            \config\lib\log::log('ctrl:'.$ctrlClass.'  '.'action:'.$action);//写日志
        }else{
            throw new \Exception('找不到控制器'.$ctrlClass);
        }
    }

    #3. 模板引擎类-写入和获取数据
    public function assign($name,$value){
        $this->assign[$name] = $value;#把模板中需要的变量都放到这
    }

    /**
     * 获取数据
     * @param $tag
     * @return array
     */
    public function getAssign($tag){
        return $this->assign[$tag];
    }

    #4. 模板引擎类-获取模板源文件
    /**
     * 获取模板的源文件
     */
    public function getTemplate($templateName,$ext = '.html'){
        $this->currentTemp = $templateName;
        $sourceFilename = $this->templateDir.$this->currentTemp.$ext;
        $this->outputHtml = file_get_contents($sourceFilename);
    }

    #5. 模板引擎类-模板编译
    /**
     * 对源文件进行编译
     */
    public function compileTemplate($templateName = null,$ext = '.html'){
        $templateName = empty($templateName) ? $this->currentTemp : $templateName;
        //核心代码，正则替换
        $pattern = '/'.preg_quote($this->leftTag);
        $pattern .= ' *\$([a-zA-Z_]\w*) *';#满足php变量的命名规则
        $pattern .= preg_quote($this->rightTag).'/';
        $this->outputHtml = preg_replace($pattern,'<?php echo $this->getAssign(\'$1\'); ?>',$this->outputHtml);

        //css,js正则替换
        $path = '/'.preg_quote($this->viewCss).'/';
        $this->outputHtml = preg_replace($path,'<?php echo \'http://\'.$_SERVER[\'SERVER_NAME\'].$this->template[\'viewCssCon\']$1; ?>',$this->outputHtml);

        $compileFilename = $this->compileDir.md5($templateName).$ext;
        file_put_contents($compileFilename,$this->outputHtml);
    }

    #6.模板引擎类-显示模板
    public function display($templateName = null, $ext = '.html'){
        if (empty($templateName)){
            $templateName = empty($templateName) ? $this->currentTemp : $templateName;
            include_once $this->compileDir.md5($templateName).$ext;
        }else{
            $this->getTemplate($templateName);
            $this->compileTemplate();
            $this->display();
        }
    }

}