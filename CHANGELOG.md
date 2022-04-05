# Changelog

<!-- There should always be "Unreleased" section at the beginning. -->

## Unreleased

## 2.3.0 - 2022-04-05
- Add `ImpureResponseDecoderInterface`
- Show detailed type for `DecodedData` value object

## 2.2.0 - 2022-03-31
- Use internal cache for `CacheKey` hashed value

## 2.1.0 - 2021-08-23
- Add `DecodedValueInterface` to allow other implementations than just `DecodedValue`

## 2.0.0 - 2021-08-09
- [**BC**] Add `$initiator` argument to `ResponseDecoderInterface::supports` method

## 1.1.0 - 2021-07-28
- Copy `$response` in `ProfilerItem` not to store a reference to the original object
- Add `OnErrorCallback::ignoreError` named constructor

## 1.0.0 - 2021-05-12
- Initial implementation
