<?php

require_once 'Crtx/PEAR/Channel/Frontend.php';
require_once 'Domain51/Template.php';
require_once 'Domain51/PEAR/Channel/Package.php';

class Domain51_PEAR_Channel_Frontend extends Crtx_PEAR_Channel_Frontend
{
    private $_template_path = '';
    private $_custom_template_path = '';
    private $_config = array();
    private $_config_object = null;
    
    /**
     * Intercept some values from Crtx_PEAR_Channel_Frontend since they're private
     */
    public function __construct($channel, $options)
    {
        parent::__construct($channel, $options);
        
        $this->_config['index'] = isset($options['index']) ? $options['index'] : 'index.php';
        $this->_config['channel'] = $channel;
        
        $this->_template_path = dirname(__FILE__) . '/templates';
        $this->_config_object = new Domain51_PEAR_Channel_Config(array(
            'pdo' => $this->_dbFactory($options['database']),
            'channel' => $channel,
        ));
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
     * @internal This method is currently all pseudo code.  There are still chunks
     *           of code to be implemented.
     * @return void
     */
    public function showPackage()
    {
        try {
            $pkg = new Domain51_PEAR_Channel_Package($this->_config_object, $_GET['package']);
            $pkg->autoRegister();
            
            $view = $this->_newView('package');
            $view->index = $this->_config['index'];
            $view->package = $pkg;
            $view->show_downloads = isset($_REQUEST['downloads']);
            echo $view;
            return;
        } catch (Domain51_PEAR_Channel_Package_NotFoundException $e) {
            // @todo: use template
            echo "<strong>No package available</strong>";
            return;
        } catch (Domain51_PEAR_Channel_Package_UnrecoverableException $e) {
            // @todo: use template
            echo "<strong>Unrecoverable exception thrown, please contact channel administrator</strong>";
            return;
        }
    }
    
    protected function _newView($template)
    {
        if (file_exists("{$this->_custom_template_path}/{$template}.tpl.php")) {
            return new Domain51_Template("{$this->_custom_template_path}/{$template}.tpl.php");
        } else {
            return new Domain51_Template("{$this->_template_path}/{$template}.tpl.php");
        }
    }
    
    /**
     * @todo refactor into separate, tested package
     * @todo allow unix_socket connections?
     */
    private function _dbFactory($dsn)
    {
        $config = DB::parseDSN($dsn);
        $real_dsn = "{$config['phptype']}:host={$config['hostspec']};";
        if ($config['port'] !== false) {
            $real_dsn .= "port={$config['port']};";
        }
        $real_dsn .= "dbname={$config['database']}";
        
        return new PDO($real_dsn, $config['username'], $config['password']);
    }
}