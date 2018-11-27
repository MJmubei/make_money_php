<?php
/**
 * SVN 外部命令 类
 * @author pan.liang
 * @todo comment need addslashes for svn commit
 */
class SvnUtils
{

    /**
     * svn 账号
     */
    const SVN_USERNAME = "robot";
    /**
     * svn 密码
     */
    const SVN_PASSWORD = "robot2013";
    /**
     * 配置文件目录 (任意指定一个临时目录,解决svn: warning: Can't open file '/root/.subversion/servers': Permission denied)
     */
    const SVN_CONFIG_DIR = "/var/tmp/";

    /**
     * svn list
     *
     * @param $repository string            
     * @return boolean
     *
     */
    public static function ls($repository)
    {
        $command = "sudo svn ls " . $repository;
        $output = self::runCmd($command);
        $output = implode("<br />", $output);
        if (strpos($output, 'non-existent in that revision')) {
            return false;
        }
        return "<br />" . $command . "<br />" . $output;
    }

    /**
     * svn copy
     *
     * @param $src string            
     * @param $dst string            
     * @param $comment string            
     * @return boolean
     *
     */
    public static function copy($src, $dst, $comment)
    {
        $command = "sudo svn cp $src $dst -m '$comment'";
        $output = self::runCmd($command);
        $output = implode("<br />", $output);
        if (strpos($output, 'Committed revision')) {
            return true;
        }
        return "<br />" . $command . "<br />" . $output;
    }

    /**
     * svn delete
     *
     * @param $url string            
     * @param $comment string            
     * @return boolean
     *
     */
    public static function delete($url, $comment)
    {
        $command = "sudo svn del $url -m '$comment'";
        $output = self::runCmd($command);
        $output = implode('<br />', $output);
        if (strpos($output, 'Committed revision')) {
            return true;
        }
        return "<br />" . $command . "<br />" . $output;
    }

    /**
     * svn move
     *
     * @param $src string            
     * @param $dst string            
     * @param $comment string            
     * @return boolean
     */
    public static function move($src, $dst, $comment)
    {
        $command = "sudo svn mv $src $dst -m '$comment'";
        $output = self::runCmd($command);
        $output = implode('<br />', $output);
        if (strpos($output, 'Committed revision')) {
            return true;
        }
        return "<br />" . $command . "<br />" . $output;
    }

    /**
     * svn mkdir
     *
     * @param $url string            
     * @param $comment string            
     * @return boolean
     */
    public static function mkdir($url, $comment)
    {
        $command = "sudo svn mkdir $url -m '$comment'";
        $output = self::runCmd($command);
        $output = implode('<br />', $output);
        if (strpos($output, 'Committed revision')) {
            return true;
        }
        return "<br />" . $command . "<br />" . $output;
    }

    /**
     * svn diff
     * 
     * @param $pathA string            
     * @param $pathB string            
     * @return string
     */
    public static function diff($pathA, $pathB)
    {
        $output = self::runCmd("sudo svn diff $pathA $pathB");
        return implode('<br />', $output);
    }

    /**
     * svn checkout
     * 
     * @param $url string            
     * @param $dir string            
     * @return boolean
     */
    public static function checkout($url, $dir)
    {
        $command = "cd $dir && sudo svn co $url";
        $output = self::runCmd($command);
        $output = implode('<br />', $output);
        if (strstr($output, 'Checked out revision')) {
            return true;
        }
        return "<br />" . $command . "<br />" . $output;
    }

    /**
     * svn update
     * 
     * @param $path string            
     */
    public static function update($path)
    {
        $command = "cd $path && sudo svn up";
        $output = self::runCmd($command);
        $output = implode('<br />', $output);
        preg_match_all("/[0-9]+/", $output, $ret);
        if (! $ret[0][0]) {
            return "<br />" . $command . "<br />" . $output;
        }
        return $ret[0][0];
    }

    /**
     * svn merge
     *
     * @param $revision string            
     * @param $url string            
     * @param $dir string            
     *
     * @return boolean
     */
    public static function merge($revision, $url, $dir)
    {
        $command = "cd $dir && sudo svn merge -r1:$revision $url";
        $output = implode('<br />', self::runCmd($command));
        if (strstr($output, 'Text conflicts')) {
            return 'Command: ' . $command . '<br />' . $output;
        }
        return true;
    }

    /**
     * svn commit
     *
     * @param $dir string            
     * @param $comment string            
     *
     * @return boolean
     */
    public static function commit($dir, $comment)
    {
        $command = "cd $dir && sudo svn commit -m'$comment'";
        $output = implode('<br />', self::runCmd($command));
        if (strpos($output, 'Committed revision') || empty($output)) {
            return true;
        }
        return $output;
    }

    /**
     * svn status （输出WC中文件和目录的状态）
     *
     * @param $dir string            
     */
    public static function getStatus($dir)
    {
        $command = "cd $dir && sudo svn st";
        return self::runCmd($command);
    }

    /**
     * svn 冲突
     *
     * @param $dir string            
     * @return boolean
     */
    public static function hasConflict($dir)
    {
        $output = self::getStatus($dir);
        foreach ($output as $line) {
            if (substr(trim($line), 0, 1) == 'C' || (substr(trim($line), 0, 1) == '!')) {
                return true;
            }
        }
        return false;
    }

    /**
     * svn log
     *
     * @param $path string            
     * @return string
     *
     */
    public static function getLog($path)
    {
        $command = "sudo svn log $path --xml";
        $output = self::runCmd($command);
        return implode('', $output);
    }

    /**
     * svn info
     * 
     * @param $path string            
     */
    public static function getPathRevision($path)
    {
        $command = "sudo svn info $path --xml";
        $output = self::runCmd($command);
        $string = implode('', $output);
        $xml = new SimpleXMLElement($string);
        foreach ($xml->entry[0]->attributes() as $key => $value) {
            if ($key == 'revision') {
                return $value;
            }
        }
    }

    /**
     * 获取最新版本号
     * 
     * @param $path string            
     */
    public static function getHeadRevision($path)
    {
        $command = "cd $path && sudo svn up";
        $output = self::runCmd($command);
        $output = implode('<br />', $output);
        preg_match_all("/[0-9]+/", $output, $ret);
        if (! $ret[0][0]) {
            return "<br />" . $command . "<br />" . $output;
        }
        return $ret[0][0];
    }

    /**
     * 获取某文件最早版本号
     *
     * @param $filePath string            
     *
     */
    public static function getFileFirstVersion($filePath)
    {
        $command = "sudo svn log {$filePath}";
        $output = self::runCmd($command, "|grep -i ^r[0-9]* |awk  '{print $1}'");
        if (empty($output)) {
            return false;
        }
        return str_replace("r", '', $output[count($output) - 1]);
    }

    /**
     * 获取两个版本间修改的文件信息列表
     *
     * @param $fromVersion int            
     * @param $headRevision int            
     * @param $$path string            
     *
     * @return array
     */
    public static function getChangedFiles($path, $fromVersion, $headRevision)
    {
        $files = array();
        $pipe = "|grep -i ^Index:|awk -F : '{print $2}'";
        $command = "svn diff -r {$fromVersion}:{$headRevision} $path";
        $output = self::runCmd($command, $pipe);
        $files = array_merge($files, $output);
        $command = "svn diff -r {$headRevision}:{$fromVersion} $path"; // 文件删除可用逆向对比
        $output = self::runCmd($command, $pipe);
        $files = array_merge($files, $output);
        return array_unique($files);
    }

    /**
     * 获取两个版本间某文件修改 的内容
     *
     * @param $filePath string            
     * @param $fromVersion int            
     * @param $headRevision int            
     *
     * @return array
     */
    public static function getChangedInfo($filePath, $fromVersion, $headRevision)
    {
        $command = "sudo svn diff -r {$fromVersion}:{$headRevision} $filePath";
        $output = self::runCmd($command);
        return $output;
    }

    /**
     * 查看文件内容
     *
     * @param $filePath string            
     * @param $version int            
     *
     * @return array
     */
    public static function getFileContent($filePath, $version)
    {
        $command = "sudo svn cat -r {$version} $filePath";
        $output = self::runCmd($command);
        return $output;
    }

    /**
     * Run a cmd and return result
     * 
     * @param $command string            
     * @param $pipe string
     *            (可以增加管道对返回数据进行预筛选)
     * @return array
     */
    protected static function runCmd($command, $pipe = "")
    {
        $authCommand = ' --username ' . self::SVN_USERNAME . ' --password ' . self::SVN_PASSWORD . ' --no-auth-cache --non-interactive --config-dir ' . self::SVN_CONFIG_DIR . '.subversion';
        exec($command . $authCommand . " 2>&1" . $pipe, $output);
        return $output;
    }
}