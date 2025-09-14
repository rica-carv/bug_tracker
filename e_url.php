<?php
/*
 * e107 Bootstrap CMS
 * URL config for Bug Tracker plugin
 */

if (!defined('e107_INIT')) { exit; }

// v2.x Standard - Simple mod-rewrite module.

class bug_tracker_url // plugin-folder + '_url'
{
    public $alias = 'bugtracker';   // aparece em {alias}

    function config()
    {
        $config = array();

        // Página principal (lista de bugs, dashboard, etc.)
        $config['index'] = array(
            'regex'     => '^{alias}/?(.*)$',
            'sef'       => '{alias}',
            'redirect'  => '{e_PLUGIN}bug_tracker/bugs.php$1',
        );

        // Ver bug específico
        $config['bug'] = array(
            'regex'     => '^{alias}/bug/([\d]*)/?(.*)$',
            'sef'       => '{alias}/bug/{id}',
            'redirect'  => '{e_PLUGIN}bug_tracker/bugs.php?mode=view&id=$1',
        );

        // Listar bugs por categoria
        $config['category'] = array(
            'regex'     => '^{alias}/category/([\d]*)/(.*)$',
            'sef'       => '{alias}/category/{id}',
            'redirect'  => '{e_PLUGIN}bug_tracker/bugs.php?cat=$1',
        );

        return $config;
    }
}
