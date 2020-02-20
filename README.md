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

- Unomi Tab on Individual overview

![Screenshot](/images/tab.png)

## Known Issues

(* FIXME *)

## Useful links

- https://civicrm.stackexchange.com/questions/20316/within-an-extension-how-can-load-a-custom-civi-name-spaced-class
- http://unomi.apache.org/manual/latest/index.html#_useful_apache_unomi_urls
