<?php
/**
 * SS Entry Importer plugin for Craft CMS 3.x
 *
 * The plugin will be used for an importing an entries from a CSV file.(Supported field type: Plain Text, Email, Radio Buttons, Dropdown, URL.)
 *
 * @link      http://www.systemseeders.com/
 * @copyright Copyright (c) 2019 SystemSeeders
 */

namespace ssplugin\ssentryimporter\models;

use ssplugin\ssentryimporter\SsEntryImporter;

use Craft;
use craft\base\Model;

/**
 * Settings Model
 *
 * Models are containers for data. Just about every time information is passed
 * between services, controllers, and templates in Craft, it’s passed via a model.
 *
 * https://craftcms.com/docs/plugins/models
 *
 * @author    SystemSeeders
 * @package   SsEntryImporter
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * Some model attribute
     *
     * @var string
     */
    public string $section = '';
    public string $entry_type  = '';
    public string $entry_status  = '';
    public array $response_data = [];
    public array $response_header = [];

    // Public Methods
    // =========================================================================

    /**
     * Returns the validation rules for attributes.
     *
     * Validation rules are used by [[validate()]] to check if attribute values are valid.
     * Child classes may override this method to declare different validation rules.
     *
     * More info: http://www.yiiframework.com/doc-2.0/guide-input-validation.html
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            ['section', 'string'],            
            ['entry_type', 'string'],
        ];
    }
}
