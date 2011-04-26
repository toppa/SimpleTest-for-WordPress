<?php

class WpFacade {
    public function __construct() {

    }

    // Managing settings: http://www.presscoders.com/wordpress-settings-api-explained/
    public function getSetting($setting) {
        return get_option($setting);
    }

    public function setSetting($setting, $value) {
        // true if value was changed, false otherwise
        return update_option($setting, $value);
    }

    public function deleteSetting($setting) {
        // true if successful, false if not
        return delete_option($setting);
    }

    public function getTableNamePrefix() {
        global $wpdb;
        return $wpdb->prefix;
    }

    public function createTable($tableName, $refData) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $sql_end = "";
        $sql = "CREATE TABLE $tableName (\n";

        foreach ($refData as $k=>$v) {
            $sql .= $k . " " . $v['col_params']['type'];

            if (strlen($v['col_params']['length'])) {
                $sql .= "(" . $v['col_params']['length'];

                if (strlen($v['col_params']['precision'])) {
                    $sql .= "," . $v['col_params']['precision'];
                }

                $sql .= ")";
            }

            if ($v['col_params']['not_null']) {
                $sql .= " NOT NULL";
            }

            // dbDelta requires 2 spaces in front of primary key declaration
            if ($v['col_params']['primary_key']) {
                $sql .= "  PRIMARY KEY";
            }

            if (strlen($v['col_params']['other'])) {
                $sql .= " " . $v['col_params']['other'];
            }

            $sql .= ",\n";

            // dbDelta requires unique indexes declared at the end, using KEY
            if ($v['col_params']['unique_key']) {
                $sql_end .= "UNIQUE KEY $k ($k),\n";
            }
        }

        $sql = $sql . $sql_end;
        // strip trailing comma and linebreak
        $sql = substr($sql, 0, -2);
        $sql .= "\n)\nDEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;";

        // dbDelta returns an array of strings - won't tell you if there
        // was an error
        return dbDelta($sql, true);
    }

    public function verifyTableExists($tableName, $refData) {
        global $wpdb;
        $described = $wpdb->get_results("DESCRIBE $tableName;", ARRAY_A);

        if ($described[0]['Field'] == key($refData)) {
            return true;
        }

        return false;
    }

    public function dropTable($tableName) {
        global $wpdb;
        $sql = "drop table if exists $tableName;";
        return $wpdb->query($sql); // always returns 0
    }

    public function getUrlForCustomizableFile($fileName, $baseFile, $relativePath = null) {
        if (file_exists(get_stylesheet_directory() . '/' . $fileName)) {
            $url = get_bloginfo('stylesheet_directory') . '/' . $fileName;
        }

        else {
            $url = $this->getPluginsUrl($relativePath . $fileName, $baseFile);
        }

        return $url;
    }

    public function getPluginsUrl($relativePath, $baseFile) {
        return plugins_url($relativePath, $baseFile);
    }

    public function getPluginsPath() {
        return WP_PLUGIN_DIR;
    }

    public function hookEnqueueStylesheet($label, $url, $version) {
        return wp_enqueue_style($label, $url, false, $version);
    }

    public function hookHandleShortcode($shortcodeName, $callback) {
        return add_shortcode($shortcodeName, $callback);
    }
}
