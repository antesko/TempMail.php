TempMail.php
===========

TempMail provides a disposable, temporary mailbox for receiving emails.
Generate random or custom email address with available domains, and receive email messages.
Uses temp-mail.org's API [https://temp-mail.org/en/api](https://temp-mail.org/en/api).


### Install ###

Just include ```dist/TempMail.php``` file and you're ready to go.


### Usage ###

**Generate new random mailbox**

```php
$tempMail = new TempMail();
```


**Generate custom/existing mailbox**

```php
$tempMail = new TempMail('john.doe', '@leeching.net');
```

*NOTE: Second parameter must begin with '@' sign, and it has to be inside available domains list*


**Get list of available domains**

```php
$domainsList = $tempMail::getDomains();
```

*NOTE: getDomains() method can receive an optional format parameter ('xml', 'json', 'php', 'html'). Default is json.*


**Available variables**

```php
// Get email name
echo $tempMail->name;

// Get email domain
echo $tempMail->domain;

// Get full email address
echo $tempMail->address;
```

**Check and get a list of emails for a mailbox**

```php
$emails = $tempMail->getEmails();       // PHP array
$emails = $tempMail->getEmails('raw');  // raw (default: json)
```

**Check and get a list of sources for a mailbox**

```php
$emails = $tempMail->getSources();       // PHP array
$emails = $tempMail->getSources('raw');  // raw (default: json)
```

**Delete a message by it's ID**

```php
$del = $tempMail->deleteMessage('messageID');
```


### NOTES ###

* temp-mail's API doesn't handle too much requests very well. So don't push it with more than 1 request every few seconds.
* All incoming emails are removed within approximately 10 minutes after admission.