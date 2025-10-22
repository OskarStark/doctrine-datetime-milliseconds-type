# doctrine-datetime-milliseconds-type

| Branch    | PHP                                         |
|-----------|---------------------------------------------|
| `master`  | [![PHP][build-status-master-php]][actions]  |

## Usage

### Installation

```bash
composer require oskarstark/doctrine-datetime-milliseconds-type
```



### Setup
```yaml
# config/packages/doctrine.yaml

doctrine:
    dbal:
        types:
            # We want to store DateTime objects with milliseconds
            # The solution is built on https://github.com/doctrine/dbal/issues/2873#issuecomment-701052412
            # but instead of using microseconds we use milliseconds
            datetime: OskarStark\Doctrine\Type\Doctrine\DBAL\Types\Type\DateTimeMillisecondsType
```

[build-status-master-php]: https://github.com/oskarstark/doctrine-datetime-milliseconds-type/actions/workflows/ci.yaml/badge.svg?branch=master

[actions]: https://github.com/oskarstark/doctrine-datetime-milliseconds-type/actions
