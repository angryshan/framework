<?php
namespace config\lib\update;
class lssUpload
{

    /**
     * 构建上传文件信息
     */
    public function buildInfo()
    {
        if (!$_FILES) {
            return;
        }
        $i = 0;
        foreach ($_FILES as $v) {
            #单文件上传
            if (is_string($v['name'])) {
                $files[$i] = $v;
                $i++;
            } else {#多文件上传
                foreach ($v['name'] as $key => $val) {
                    $files[$i]['name'] = $val;
                    $files[$i]['size'] = $v['size'][$key];
                    $files[$i]['tmp_name'] = $v['tmp_name'][$key];
                    $files[$i]['error'] = $v['error'][$key];
                    $files[$i]['type'] = $v['type'][$key];
                    $i++;
                }
            }
        }
        return $files;
    }

    /**
     * 上传文件
     * @param string $path @路径
     * @param array $allowExt @允许后缀
     * @param int $maxSize @文件大小，默认20971520
     * @param bool $imgFlag
     */
    public function uploadFile($path = "uploads", $allowExt = array('gif', 'jpeg', 'png', 'jpg', "wbmp", 'ppt', 'pptx', 'doc', 'docx', 'zip'), $maxSize = 20971520, $imgFlag = true)
    {
        if (!file_exists($path . '/' . date('Ym'))) {
            mkdir($path . '/' . date('Ym'), '0777', true);
        }
        $i = 0;
        $files = $this->buildInfo();
        $uploadFiles = '';
        if (!($files && is_array($files))) {
            return false;
        }
        foreach ($files as $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $ext = $this->getExt($file['name']);#获取字段后缀名
                if (!in_array($ext, $allowExt)) {#检测文件扩展名
                    exit('非法文件类型');
                }
                if ($file['size'] > $maxSize) {#校验文件大小
                    exit('上传文件过大');
                }
                if (!is_uploaded_file($file['tmp_name'])) {#检验上传路径
                    exit('不是通过http post方式传过来的文件');
                }
                $filename = $this->getUniName() . '.' . $ext;
                $destination = $path . '/' . date('Ym') . "/" . $filename;
                if (move_uploaded_file($file['tmp_name'], $destination)) {#将上传的文件移动到新位置
                    $file['name'] = $filename;
                    unset($file['tmp_name'], $file['size'], $file['type']);
                    $uploadFiles[$i] = $file;
                    $i++;
                }
            } else {
                switch ($file['error']) {
                    case 1:
                        $msg = "超过了配置文件上传文件的大小";//UPLOAD_ERR_INI_SIZE
                        break;
                    case 2:
                        $msg = "超过了表单设置上传文件的大小";            //UPLOAD_ERR_FORM_SIZE
                        break;
                    case 3:
                        $msg = "文件部分被上传";//UPLOAD_ERR_PARTIAL
                        break;
                    case 4:
                        $msg = "没有文件被上传!!!";//UPLOAD_ERR_NO_FILE
                        break;
                    case 6:
                        $msg = "没有找到临时目录";//UPLOAD_ERR_NO_TMP_DIR
                        break;
                    case 7:
                        $msg = "文件不可写";//UPLOAD_ERR_CANT_WRITE;
                        break;
                    case 8:
                        $msg = "由于PHP的扩展程序中断了文件上传";//UPLOAD_ERR_EXTENSION
                        break;
                }
                echo $msg;
            }
        }
        return $uploadFiles;
    }

    /**
     * 获取文件的后缀名
     * @param $filename @文件名
     * @return string
     */
    public function getExt($filename)
    {
        $a = explode(".", $filename);
        return strtolower(end($a));
    }

    /**
     * 生成唯一的字符串
     * @return string
     */
    public function getUniName(){
        return md5(uniqid(microtime(true), true));
    }
}