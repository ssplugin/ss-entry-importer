<?php
/**
 * SS Entry Importer plugin for Craft CMS 3.x
 *
 * The plugin will be used for an importing an entries from a CSV file.(Supported field type: Plain Text, Email, Radio Buttons, Dropdown, URL.)
 *
 * @link      http://www.systemseeders.com/
 * @copyright Copyright (c) 2019 SystemSeeders
 */

namespace ssplugin\ssentryimporter\controllers;

use ssplugin\ssentryimporter\SsEntryImporter;

use Craft;
use craft\web\Controller;

/**
 * Tab Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    SystemSeeders
 * @package   SsEntryImporter
 * @since     1.0.0
 */
class TabController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index', 'do-something'];

    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/ss-entry-importer/tab
     *
     * @return mixed
     */
    public function actionImport()
    {
        $settings = craft::$app->plugins->getPlugin('ss-entry-importer')->getSettings();        
        $this->renderTemplate( 'ss-entry-importer/tabs/import', array( 
            'setting' => $settings,        
        ));
    }

    public function actionSettings()
    {
        $settings = craft::$app->plugins->getPlugin('ss-entry-importer')->getSettings();        
        $this->renderTemplate( 'ss-entry-importer/tabs/settings', array( 
            'setting' => $settings,        
        ));
    }

    public function actionElementmap()
    {
        $settings = craft::$app->plugins->getPlugin('ss-entry-importer')->getSettings();        
        $this->renderTemplate( 'ss-entry-importer/tabs/elementmap', array( 
            'setting' => $settings,        
        ));
    }   
}
