# CHANGELOG

## [1.2.5] - (2022-06-09)

### Update
- Add `UIIGateway\Castle\Utility\BinUuidConverter` utility
- Add `UIIGateway\Castle\Facades\Auth` facades

## [1.2.4] - (2022-06-07)

### Update
- Update exception handling

## [1.2.3] - (2022-06-02)

### Update
- Separate publishes to several group
- Add `ArrayUnique` rule
- Add castle validation translation
- Port laravel foundation bus utility
- Make some provider deffered
- Add `kafka:view-topic-records` and `vendor:publish` commands

### Bug fixing
- Don't throw exception when invalid locale

## [1.2.2] - (2022-05-26)

### Update
- Add Collection `pick` macro
- Add `UIIGateway\Castle\Utility\NameFormatter` utility
- Add `UIIGateway\Castle\Exceptions\EntityNotFoundException::withMessage()`

### Bug fixing
- Change `UIIGateway\Castle\Exceptions\EntityNotFoundException` status code to `400`

## [1.2.1] - (2022-04-21)

### Update
- Add helpers

## [1.2.0] - (2022-04-20)

### Update
- Set topic to the producer when Publishing
- Use classess from original Kafka package

### Bug fixing
- Set restricted property for non-static property in reflection helper

## [1.1.0] - (2022-04-16)

### Update
- Add testing mixins
- Use Publishing terms instead of broadcasting
- Extend events dispatcher to handle publishing

## [1.0.0] - (2022-03-30)

### Info
- First release

[1.2.1]: https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/tags/1.2.1
[1.2.0]: https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/tags/1.2.0
[1.1.0]: https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/tags/1.1.0
[1.0.0]: https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/tags/1.0.0
