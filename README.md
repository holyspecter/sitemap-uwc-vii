### Getting started

Simply run `vagrant up`. When setup is finished web application will be available via IP 192.168.56.101.

### Known issue

During development was found some strange behavior of application: exception written below was occurring from time to time.
```
...
[WARNING 1549] failed to load external entity "file:////www/bolt/vendor/symfony/translation/Symfony/Component/Translation/Loader/schema/dic/xliff-core/xml.xsd" (in n/a - line 0, column 0)...
```
Simple `vagrant reload` on host machine fixed it.
