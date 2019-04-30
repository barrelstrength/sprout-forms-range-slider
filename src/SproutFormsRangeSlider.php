<?php
/**
 * Sprout Forms RangeSlider plugin for Craft CMS 3.x
 *
 * US rangeslider fields for Sprout Forms
 *
 * @link      https://www.barrelstrengthdesign.com/
 * @copyright Copyright (c) 2018 Barrel Strength
 */

namespace barrelstrength\sproutformsrangeslider;

use barrelstrength\sproutforms\services\Fields;
use barrelstrength\sproutforms\events\RegisterFieldsEvent;
use barrelstrength\sproutformsrangeslider\integrations\sproutforms\fields\RangeSlider;
use Craft;

use craft\base\Plugin;

use yii\base\Event;

class SproutFormsRangeSlider extends Plugin
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Craft::setAlias('@sproutformsrangeslidericons', $this->getBasePath().'/web/icons');

        Event::on(Fields::class, Fields::EVENT_REGISTER_FIELDS, static function(RegisterFieldsEvent $event) {
            $event->fields[] = new RangeSlider();
        });
    }
}
