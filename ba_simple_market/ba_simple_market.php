<?php

/*
  Plugin Name: BA Simple Market
  Plugin URI: http://www.b4after.pl/ba-simple-market-wordpress-plugin
  Description: Simple eCommerce solution for small and medium websites
  Version: 1.0.0
  Author: BEFORE AFTER agency <agencja@b4after.pl>
  Author URI: http://www.b4after.pl
  License: GPLv2
 */

/*
  Copyright (C) 2016 Kamil Winiszewski (BEFORE AFTER agency) <agencja@b4after.pl>

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

class BA_simple_market {

    private $version = '1.0.0';

    public function __construct() {

        $this->setup_constans();
        $this->get_dependencies();
    }

    private function setup_constans() {
        define('BA_SM_DIR', plugin_dir_path(__FILE__));
    }
    
    private function get_dependencies()
    {
        
    }

}

function init_market() {
    $ba_simple_market = new BA_simple_market();
}

add_action('after_plugins_loaded', 'init_market');
