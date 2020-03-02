# be.ctrl.unomi

## Introduction
Everything functionally related to integrating with Unomi in CiviCRM.

## Installation
- You can directly clone to your CiviCRM extension directory using<br>
```$ git clone https://github.com/kewljuice/be.ctrl.unomi.git```

- You can also download a zip file, and extract in your extension directory<br>
```$ git clone https://github.com/kewljuice/be.ctrl.unomi/archive/master.zip```

- The next step is enabling the extension which can be done from<br>
```"Administer -> System Settings -> Manage CiviCRM Extensions".```

## Requirements

- PHP v7.0+
- CiviCRM 5.0

## Configuration

- Manage settings: **yoursite.org/civicrm/unomi/settings**.

![Screenshot](/images/settings.png)

- API url: public endpoint to Unomi, event collector & context fetch with session id.
- API username
- API password

## Usage

### Unomi Tab on Individual overview

Add a valid profile id from Unomi in the individual contact summary, under fieldset 'Unomi'

![Screenshot](/images/tab.png)

### Define CiviCRM fields in Unomi

Define CiviCRM related fields in Unomi via rule, this api call passes all individual contact fields (default + custom) via API to Unomi.

```
$rule = civicrm_api3('Unomi', 'createrule');
```

### Update individual contact

Updates a specific contact with fields from CiviCRM to Unomi via event.

```
$event = civicrm_api3('Unomi', 'createevent', [
  'contact_id' => "",
]);
```

## Known Issues

(* FIXME *)

## Useful links

- https://civicrm.stackexchange.com/questions/20316/within-an-extension-how-can-load-a-custom-civi-name-spaced-class
- http://unomi.apache.org/manual/latest/index.html#_useful_apache_unomi_urls
- https://stackoverflow.com/questions/45511956/remove-a-named-volume-with-docker-compose

