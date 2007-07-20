<?php

require_once 'Crtx/PEAR/Channel/Frontend.php';
require_once 'Domain51/Template.php';

class Domain51_PEAR_Channel_Frontend extends Crtx_PEAR_Channel_Frontend
{
    private $_template_path = '';
    private $_custom_template_path = '';
    private $_config = array();
    
    /**
     * Intercept some values from Crtx_PEAR_Channel_Frontend since they're private
     */
    public function __construct($channel, $options)
    {
        parent::__construct($channel, $options);
        
        $this->_config['index'] = isset($options['index']) ? $options['index'] : 'index.php';
        $this->_config['channel'] = $channel;
        
        $this->_template_path = dirname(__FILE__) . '/templates';
    }
    
    public function __set($key, $value)
    {
        if ($key == 'template_path') {
            $this->_custom_template_path = $value;
        } else {
            $this->$key = $value;
        }
    }
    
    /**
     * Show a Packages page
     *
     * @return void
     */
    public function showPackage()
    {
        $pkg = $this->packageInfo($_GET['package']);
        $subpkg = DB_DataObject::factory('packages');
        $subpkg->channel = $this->_channel;
        $subpkg->parent = $_GET['package'];

        $has_sub = $subpkg->find(false);

        if (!$pkg) {
            echo '<strong>No Package to display</strong>';
            return;
        }
        
        $view = $this->_newView('package');
        $view->index = $this->_config['index'];
        $view->channel = $this->_config['channel'];
        $view->package = $pkg['package'];
        $view->package_extras = $this->_generatePackageExtras();
        
        
        if (isset($_REQUEST['downloads'])) {
            $view->downloads = $this->generateDownloads();
        } else {
            $view->description = $pkg['description'];
            $view->summary = $pkg['summary'];
            $view->license_uri = $pkg['licenseuri'];
            $view->license = $pkg['license'];
            
            $view->releases = $this->_getPackageLatestReleases($pkg['package']);
            $view->devs = $this->listPackageMaintainers($_GET['package']);
            
            if ($has_sub) {
                $view->subpackage = $subpkg;
            }
        }
        
        echo $view;
    }
    
    /**
     * Temporary fix
     */
    public function generateDownloads()
    {
        ob_start();
        $this->showPackageDownloads();
        $buffer = ob_get_clean();
        return $buffer . "</table>";
    }
    
    protected function _generatePackageExtras()
    {
        $package = DB_DataObject::factory('package_extras');
        $package->package = $_GET['package'];
        if (!$package->find(true)) {
            return;
        }
        
        $view = $this->_newView('_package_extras');
        $view->docs_uri = $package->docs_uri;
        $view->bugs_uri = $package->bugs_uri;
        $view->source_control_uri = $package->cvs_uri;
        
        return (string)$view;
    }
    
    
    /**
     * Duplicates {@link Crtx_PEAR_Channel_Frontend::getPackageLatestReleases()} since it's scope
     * is private.
     */
    protected function _getPackageLatestReleases($pkg)
    {
        $release = array();
        $package = DB_DataObject::factory('releases');
        $escaped_package = $package->escape($pkg);
        
        $query = "
            SELECT
                state,
                version,
                DATE_FORMAT(releasedate, '%M %D %Y') AS date
            FROM
                releases
                INNER JOIN (
                    SELECT
                        version
                    FROM
                        releases
                    WHERE
                        package = '{$escaped_package}'
                    ORDER BY
                        releasedate
                    LIMIT 1
                ) AS derived USING(version)
            WHERE
                package = '{$escaped_package}'
        ";
        $package->query($query);
        
        
        $latest_releases = array();
        while ($package->fetch()) {
            $latest_releases[$package->state] = $package->toArray();
        }
        return $latest_releases;
    }
    
    protected function _newView($template)
    {
        if (file_exists("{$this->_custom_template_path}/{$template}.tpl.php")) {
            return new Domain51_Template("{$this->_custom_template_path}/{$template}.tpl.php");
        } else {
            return new Domain51_Template("{$this->_template_path}/{$template}.tpl.php");
        }
    }
}