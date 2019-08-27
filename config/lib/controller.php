<?php
namespace config\lib;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/17 0017
 * Time: 上午 11:36
 */
class controller{
#1.模板引擎类-成员属性
    private $templateDir;#存储模板引擎源文件的所在目录
    private $compileDir;#存储编译之后文件的存放目录
    private $leftTag = '{#';#模板需要替换的变量,做标记
    private $rightTag = '#}';
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