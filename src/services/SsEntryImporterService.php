<?php
/**
 * SS Entry Importer plugin for Craft CMS 3.x
 *
 * The plugin will be used for an importing an entries from a CSV file.(Supported field type: Plain Text, Email, Radio Buttons, Dropdown, URL.)
 *
 * @link      http://www.systemseeders.com/
 * @copyright Copyright (c) 2019 SystemSeeders
 */

namespace ssplugin\ssentryimporter\services;

use ssplugin\ssentryimporter\SsEntryImporter;

use Craft;
use craft\base\Component;
use craft\web\Controller;
use craft\base\Element;
use craft\base\ElementAction;
use craft\base\ElementActionInterface;
use craft\base\ElementInterface;
use craft\elements\Asset;
use craft\elements\Category;
use craft\elements\db\ElementQuery;
use craft\elements\Entry;

/**
 * SsEntryImporterService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    SystemSeeders
 * @package   SsEntryImporter
 * @since     1.0.0
 */
class SsEntryImporterService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     SsEntryImporter::$plugin->ssEntryImporterService->exampleService()
     *
     * @return mixed
     */
    public function Import( $getParam )
    {
        $settings = craft::$app->plugins->getPlugin('ss-entry-importer')->getSettings();
        foreach ( $settings->response_data as $key => $value ) {
            $this->RunImport($value, $getParam);
        }
    }

    public function RunImport( array $import_data, array $getParam )
    {
        $settings = craft::$app->plugins->getPlugin('ss-entry-importer')->getSettings();
        $secName = $settings->section;
        $section = Craft::$app->sections->getSectionById( $secName );
        $fields = [];
        
        foreach ( $getParam['setting'] as $key => $value ) {
            if( $value != 'NULL' ) {
                $fields[$key] = $import_data[$value];
            }
        }
        $author = Craft::$app->getUser()->getIdentity();

        if( $settings->entry_type != '') {
            if( $getParam['title'] != 'NULL' ) {
                if( !empty( $fields ) ) {
                    $entry = new Entry();
                    $entry->sectionId = $section->id;
                    $entry->typeId = isset( $settings->entry_type ) ? $settings->entry_type : 1;
                    $entry->authorId = isset( $author->id ) ? $author->id : 1;
                    if( $settings->entry_status == 'false' ) {
                        $entry->enabled  = false;
                    } else {
                        $entry->enabled  = true;
                    }
                    
                    $entry->title    = $import_data[ $getParam['title'] ];
                    $entry->setFieldValues( $fields );
                    
                    $success = Craft::$app->elements->saveElement( $entry );                                      
                    if ( !$success ) {                
                        Craft::$app->session->setNotice("Couldn’t save the entry..");                    
                    } else {                
                        Craft::$app->session->setNotice("Entry saved successfully.");                
                    } 
                } else {
                    Craft::$app->session->setError("Please select atleast one field mapping option.");
                }
            } else{
                Craft::$app->session->setError("Please select title field mapping option.");
            }

        } else {
            Craft::$app->session->setError("Please select enrty type.");
        }       
    }
}
