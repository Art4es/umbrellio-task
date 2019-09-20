Installation: "composer require art4es/finder"

Works perfect with absolute paths and paths relative to usage location.  

Usage: 
```php
$file = new File('path/to/file.txt');
$strategy = new SubstringSearchingStrategy('searchingWord');
$validatorsProvider = new YamlValidatorsProvider('path/to/config.yaml'); //if you need validate file
$finder = new Finder($file, $strategy, $validatorsProvider);
```

config.yaml example: 
```yaml
mime_types:
  - 'text/plain'
  - 'application/json'
extension:
  - 'bmp'
  - 'jpeg'
file_size:
  min: 10
  max: 60
```

Position of validators in the config file affects to the order of validation.

There are 3 configurable Validators out-of-the-box:
- ExtensionValidator
- FileSizeValidator
- MimeTypeValidator