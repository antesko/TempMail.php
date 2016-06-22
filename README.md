TempMail.php
===========

Generate random or custom temporary email address with available domains, and receive email messages.
Uses temp-mail.org's API [https://temp-mail.org/en/api](https://temp-mail.org/en/api).


### Install ###

Just include ```dist/TempMail.php``` file and you're ready to go.


### Usage ###

**Generate new random email address**

```
$tempMail = new TempMail();
```


**Generate new custom email address**

```
$tempMail = new TempMail('john.doe', '@leeching.net');
```

*NOTE: Second parameter must begin with '@' sign, and it has to be inside available domains list*


**Get list of available domains**

```
$domainsList = $tempMail::getDomains();
```

*NOTE: getDomains() method can receive an optional format parameter ('xml', 'json', 'php', 'html'). Default is json.*


**Available variables**

```
// Get email name
echo $tempMail->name;

// Get email domain
echo $tempMail->domain;

// Get full email address
echo $tempMail->address;
```