<?php

use CRM_ctrl_unomi_ExtensionUtil as E;

/**
 * Form controller class.
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_ctrl_unomi_Form_UnomiSettings extends CRM_Core_Form {

  /**
   * {@inheritdoc}
   */
  public function buildQuickForm() {
    $defaults = CRM_Core_BAO_Setting::getItem('unomi', 'unomi-settings');
    $decode = json_decode(utf8_decode($defaults), TRUE);
    // API Fields.
    $this->add(
      'text',
      'unomi_url',
      'API url',
      ['value' => $decode['unomi_url']]
    );
    $this->add(
      'text',
      'unomi_user',
      'API username',
      ['value' => $decode['unomi_user']]
    );
    $this->add(
      'text',
      'unomi_pass',
      'API password',
      ['value' => $decode['unomi_pass']]
    );
    // Site Fields.
    $this->add(
      'text',
      'site_scope',
      'Site scope',
      ['value' => $decode['site_scope']]
    );
    // Buttons.
    $this->addButtons([
      [
        'type' => 'submit',
        'name' => E::ts('GO!'),
        'isDefault' => TRUE,
      ],
    ]);
    // Export form elements.
    $this->assign('elementNames', $this->getRenderableElementNames());
    parent::buildQuickForm();
  }

  /**
   * {@inheritdoc}
   */
  public function postProcess() {
    $values = $this->controller->exportValues($this->_name);
    $settings['unomi_url'] = $values['unomi_url'];
    $settings['unomi_user'] = $values['unomi_user'];
    $settings['unomi_pass'] = $values['unomi_pass'];
    $settings['site_scope'] = $values['site_scope'];
    $encode = json_encode($settings);
    CRM_Core_BAO_Setting::setItem($encode, 'unomi', 'unomi-settings');
    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = [];
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
