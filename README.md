# doctrine-datetime-milliseconds-type

| Branch    | PHP                                         | Code Coverage                                        |
|-----------|---------------------------------------------|------------------------------------------------------|
| `master`  | [![PHP][build-status-master-php]][actions]  | [![Code Coverage][coverage-status-master]][codecov]  |

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
            datetime: Datana\Doctrine\Type\Doctrine\DBAL\Types\Type\DateTimeMillisecondsType
```

[build-status-master-php]: https://github.com/oskarstark/doctrine-datetime-milliseconds-type/workflows/PHP/badge.svg?branch=master
[coverage-status-master]: https://codecov.io/gh/oskarstark/doctrine-datetime-milliseconds-type/branch/master/graph/badge.svg

[actions]: https://github.com/oskarstark/doctrine-datetime-milliseconds-type/actions
[codecov]: https://codecov.io/gh/oskarstark/doctrine-datetime-milliseconds-type
