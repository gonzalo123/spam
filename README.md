Script to send personalized emails according to csv files.
=========================================================

## Installation
* Run 'composer install' to install vendors.
* Rename app/conf/conf.dist.yml to app/conf/conf.dist.yml and use your own parameters.
* Rename app/mailList.dist.csv to app/mailList.csv and use your own list.
* Rename app/templates/mail.dist.csv to app/templates/mail.csv and use your own email template.

## Run

```
➜  spam  ./app/spam
Console Tool

Usage:
  [options] command [arguments]

Options:
  --help           -h Display this help message.
  --quiet          -q Do not output any message.
  --verbose        -v|vv|vvv Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
  --version        -V Display this application version.
  --ansi              Force ANSI output.
  --no-ansi           Disable ANSI output.
  --no-interaction -n Do not ask any interactive question.

Available commands:
  help       Displays help for a command
  list       Lists commands
spam
  spam:run   Send Emails

```

## Covered things within this project:
* Console script with symfony/console
* Decoupled classes and managed with symfony/dependency-injection
* Parse csv file
* Testing console applications
* Sending mails with swiftmailer
* Twig templating engine to build message body