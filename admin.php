<?php
/**
 * Sync media and page data into a git repository
 *
 * @author Herberth Amaral
 */

if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once DOKU_PLUGIN.'action.php';

class action_plugin_gitsync_gitsync extends DokuWiki_Action_Plugin
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
        print_r($_POST);
    }

    function _git_init(&$event,$param)
    {

    }

    function _git_pull_origin_master(&$event,$param)
    {

    }

    function _git_push_origin_master(&$event,$param)
    {

    }
}

?>
