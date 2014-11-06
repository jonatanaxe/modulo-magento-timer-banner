<?php

$installer = $this;

$installer->startSetup();

$installer->run("

    -- DROP TABLE IF EXISTS {$this->getTable('lb_timerbanner')};
    CREATE TABLE {$this->getTable('lb_timerbanner')} (
        `id` int(11) unsigned NOT NULL auto_increment,
        `id_show` varchar(20) NOT NULL,
        `title` varchar(255) NOT NULL default '',
        `filename` varchar(255) NOT NULL default '',
        `background_image` varchar(255) NOT NULL default '',
        `background_color` varchar(10) NULL,
        `product_id` int(11) unsigned NOT NULL,
        `product_name` varchar(255) NULL default NULL,
        `template` int(11) unsigned NOT NULL default '1',
        `width` int(11) unsigned NOT NULL default '0',
        `height` int(11) unsigned NOT NULL default '0',
        `end_time_promotion` datetime NULL default NULL,
        `text_time_end` varchar(30) NULL default NULL,
        `url` varchar(500) NOT NULL default '',
        `target` varchar(255) NOT NULL default '',
        `status` smallint(6) NOT NULL default '0',
        `stores` VARCHAR( 255 ) NOT NULL DEFAULT '0',
        `start_time` datetime NULL default NULL,
        `end_time` datetime NULL default NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    -- DROP TABLE IF EXISTS {$this->getTable('lb_timerbanner_report')};
    CREATE TABLE {$this->getTable('lb_timerbanner_report')} (
        `id` int(11) unsigned NOT NULL auto_increment,
        `timerbanner_id` int(11) unsigned NOT NULL,
        `ip` varchar(20) NULL default NULL,
        `date` datetime NULL default NULL,
        FOREIGN KEY (`timerbanner_id`) REFERENCES {$this->getTable('lb_timerbanner')} (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

");

$installer->endSetup(); 