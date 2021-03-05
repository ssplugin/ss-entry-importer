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
use craft\helpers\UrlHelper;

/**
 * Feed Controller
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
class FeedController extends Controller
{
    // Public Methods
    // =========================================================================

    /**
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/ss-entry-importer/feed
     *
     * @return mixed
     */
    public function actionUpload()
    {
        if( UrlHelper::cpUrl() != '' ) {
            $cpUrl = UrlHelper::cpUrl();
        } else {
            $cpUrl = trim( Craft::getAlias('@web') );
        }
        $settings = craft::$app->plugins->getPlugin('ss-entry-importer')->getSettings();
        if( $settings->section ) {
            if( isset( $_FILES['file'] ) ) {
               
                $file_name = $_FILES['file']['name'];
                $file_size = $_FILES['file']['size'];
                $file_tmp  = $_FILES['file']['tmp_name'];
                $file_type = $_FILES['file']['type'];
                $ext       = pathinfo($file_name, PATHINFO_EXTENSION);
                if( $ext == 'csv' ) {
                    $str = fopen($file_tmp, 'r');
                    $header = NULL;
                    $data = [];
                    while ( ( $row = fgetcsv( $str, 1000, ',' ) ) !== FALSE)
                    {
                       
                        if( !$header ) {
                            $header = $row;
                        } else {
                            $data[] = array_combine($header, $row);
                        }
                    }
                    fclose($str);        

                    $plugin = ssentryimporter::getInstance();                        
                    $settings = ['response_data'  => $data, 'response_header' => $header];
                    Craft::$app->getPlugins()->savePluginSettings( $plugin, $settings );            
                    
                    return $this->redirect($cpUrl.'/ss-entry-importer/elementmap');               
                } else {
                    Craft::$app->session->setError('please choose a CSV file..');
                }                              
            }
        } else {
            Craft::$app->session->setError('please add section and entry type.');
        }        
    }

    public function actionAddsection()
    {
        if( UrlHelper::cpUrl() != '' ) {
            $cpUrl = UrlHelper::cpUrl();
        } else {
            $cpUrl = trim( Craft::getAlias('@web') );
        }
        $section      = Craft::$app->getRequest()->getParam('section');
        $entry_type   = Craft::$app->getRequest()->getParam('entry_type');
        $entry_status = Craft::$app->getRequest()->getParam('entry_status');
        $plugin       = ssentryimporter::getInstance();                        
        $settings     = ['section'  => $section, 'entry_type' => $entry_type, 'entry_status' => $entry_status];
                      
        Craft::$app->getPlugins()->savePluginSettings($plugin, $settings);

        return $this->redirect($cpUrl.'/ss-entry-importer');        
    }

    public function actionImport()
    {        
        $this->requirePostRequest();
        $request  = Craft::$app->getRequest();        
        $getParam = $request->bodyParams;
        
        SsEntryImporter::$plugin->ssEntryImporterService->Import( $getParam );        
    }

    public function actionGetenrty( $sec )
    {
        if( $sec != '' ) {
            $section  = Craft::$app->sections->getSectionById($sec);
            $settings = craft::$app->plugins->getPlugin('ss-entry-importer')->getSettings();
            if( $section ) {
                $entryType = $section->getEntryTypes();
                $html = '';
                foreach ($entryType as $value) {
                    $html .= '<option value="'.$value->id.'">'.$value->handle.'</option>';
                }
                return json_encode($html);
            }
            return false;  
        }
    }
}
