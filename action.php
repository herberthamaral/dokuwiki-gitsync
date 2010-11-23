<?php
/**
 * Sync media and page data into a git repository
 *
 * @author Herberth Amaral
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'action.php';

class action_plugin_gitsync extends DokuWiki_Action_Plugin
{
    function register(&$controller)
    {
       $controller->register_hook('IO_WIKIPAGE_WRITE','BEFORE',$this,'_git_commit'); 
    }
    
    function getInfo()
    {
        return array('author'=> 'Herberth Amaral',
                     'email' => 'herberthamaral@gmail.com',
                     'date'  => '2010-11-22',
                     'name'  => 'GitSync',
                     'desc'  => 'Sync media and page data into a git repository',
                     'url'   => 'http://herberthamaral.com/'

                );
    }

    function _git_commit(&$event,$param)
    {
        $this->_git_init();
        global $conf;
        global $INFO;

        $commit_msg = (isset($_POST['minor']) and empty($_POST['summary']))?"Minor":$_POST['summary'];
        $author = $INFO['userinfo']['name'].' <'.$INFO['userinfo']['mail'].'>';
        
        $dir = $this->getSaveDir();
        print_r($INFO);
        $command = "cd $dir && git add . && git commit -m \"$commit_msg\" --author=\"$author\" "; 
        exec($command);
    }

    function getSaveDir()
    {
        $dir = DOKU_INC;
        global $conf;

        if ($conf['savedir'][0]==".")
            $dir .= substr($conf['savedir'],2);
        else if ($conf['savedir'][0]=='/')
            $dir = $conf['savedir'];
        else
           $dir .= $conf['savedir'];
        
        return $dir;
    }

    function _git_init(&$event,$param)
    {
        $dir = $this->getSaveDir();
        $command = "cd $dir && ls .git"; 
        $status = exec($command); 
        if (empty($status))
        {
            echo('Sem repositório do git... criando um'."\n");
            exec("cd $dir && git init");
            exec("cd $dir && echo \"attic/**\" >> .gitignore");
            exec("cd $dir && echo \"tmp/**\" >> .gitignore");
            exec("cd $dir && echo \"cache/**\" >> .gitignore");
            exec("cd $dir && echo \"index/**\" >> .gitignore");
            exec("cd $dir && echo \"locks/**\" >> .gitignore");
            exec("cd $dir && echo \"meta/**\" >> .gitignore"); 
            exec("cd $dir && echo \"_dummy\" >> .gitignore"); 
        }
    }

    function _git_pull_origin_master(&$event,$param)
    {
        
    }

    function _git_push_origin_master(&$event,$param)
    {

    }
}

?>
