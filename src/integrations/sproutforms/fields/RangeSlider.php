<?php

namespace barrelstrength\sproutformsrangeslider\integrations\sproutforms\fields;

use Craft;
use craft\helpers\Template as TemplateHelper;
use craft\base\ElementInterface;
use craft\base\PreviewableFieldInterface;

use barrelstrength\sproutforms\base\FormField;
use Twig_Error_Loader;
use Twig_Markup as Twig_MarkupAlias;
use yii\base\Exception;

/**
 * Class RangeSlider
 *
 * @package Craft
 *
 * @property mixed $settingsHtml
 */
class RangeSlider extends FormField implements PreviewableFieldInterface
{
    /**
     * @var string
     */
    public $cssClasses;

    /**
     * @var int|null
     */
    public $min;

    /**
     * @var int|null
     */
    public $max;

    /**
     * @var int|null
     */
    public $defaultValue;

    /**
     * @var string|null
     */
    public $titleText;

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('sprout-forms-range-slider', 'Range Slider');
    }

    /**
     * @return string
     */
    public function getSvgIconPath(): string
    {
        return '@sproutformsrangeslidericons/slider.svg';
    }

    /**
     * @inheritdoc
     *
     * @throws Twig_Error_Loader
     * @throws Exception
     */
    public function getSettingsHtml()
    {
        $rendered = Craft::$app->getView()->renderTemplate(
            'sprout-forms-range-slider/_integrations/sproutforms/formtemplates/fields/rangeslider/settings',
            [
                'field' => $this
            ]
        );

        return $rendered;
    }

    /**
     * @@inheritdoc
     *
     * @throws Twig_Error_Loader
     * @throws Exception
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        return Craft::$app->getView()->renderTemplate('sprout-forms-range-slider/_integrations/sproutforms/formtemplates/fields/rangeslider/cpinput',
            [
                'name' => $this->handle,
                'value' => $value ?? $this->defaultValue,
                'field' => $this
            ]
        );
    }

    /**
     * @inheritdoc
     *
     * @throws Twig_Error_Loader
     * @throws Exception
     */
    public function getExampleInputHtml(): string
    {
        return Craft::$app->getView()->renderTemplate('sprout-forms-range-slider/_integrations/sproutforms/formtemplates/fields/rangeslider/example',
            [
                'field' => $this
            ]
        );
    }

    /**
     * @inheritdoc
     *
     * @throws Twig_Error_Loader
     * @throws Exception
     */
    public function getFrontEndInputHtml($value, array $renderingOptions = null): Twig_MarkupAlias
    {
        $rendered = Craft::$app->getView()->renderTemplate(
            'rangeslider/input',
            [
                'name' => $this->handle,
                'value' => $value ?? $this->defaultValue,
                'field' => $this,
                'renderingOptions' => $renderingOptions
            ]
        );

        return TemplateHelper::raw($rendered);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['min', 'max', 'defaultValue'], 'number'];
        $rules[] = [
            ['max'],
            'compare',
            'compareAttribute' => 'min',
            'operator' => '>='
        ];

        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function getTemplatesPath(): string
    {
        return Craft::getAlias('@barrelstrength/sproutformsrangeslider/templates/_integrations/sproutforms/formtemplates/fields/');
    }
}
