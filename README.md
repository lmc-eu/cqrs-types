LMC CQRS Types
==============

[![cqrs-types](https://img.shields.io/badge/cqrs-types-purple.svg)](https://github.com/lmc-eu/cqrs-types)
[![Tests and linting](https://github.com/lmc-eu/cqrs-types/actions/workflows/tests.yaml/badge.svg)](https://github.com/lmc-eu/cqrs-types/actions/workflows/tests.yaml)
[![Coverage Status](https://coveralls.io/repos/github/lmc-eu/cqrs-types/badge.svg?branch=main)](https://coveralls.io/github/lmc-eu/cqrs-types?branch=main)

> This library contains types, value objects, interfaces and base implementation for CQRS library.
> So anyone can easily write an extension for it.

## Table of contents
- [Installation](#installation)
- [Interfaces (types)](#interfaces-types)
    - Queries
        - [Quer.githuby](#query-interface)
        - [Query Fetcher](#query-fetcher-interface)
        - [Query Handler](#query-handler-interface)
    - Commands
        - [Command](#command-interface)
        - [Command Sender](#command-sender-interface)
        - [Send Command Handler](#send-command-handler-interface)
    - Common
        - [Response Decoder](#response-decoder-interface)
        - [Profiler Formatter](#profiler-formatter-interface)
    - [Features](#features)
        - [Caching](#cache-interface)
        - [Profiling](#profileable-interface)
- [Base Implementations](#base-implementations)
    - [Handlers](#handlers)
    - [Decoders](#decoders)
- [Other CQRS Libraries](#other-cqrs-libraries)

## Installation
```shell
composer require lmc/cqrs-types
```

## Interfaces (types)
> There are many interfaces and types here, which are implemented in [other CQRS libraries](#other-cqrs-libraries)

### Query Interface
The main interface for all Queries. Query is a request which fetch a data without changing anything.
It is responsible for declaring and creating a request, which will be handled by `QueryHandlerInterface`.
An object implementing Query Interface may implement [feature](#features) and it should be handled by a `QueryFetcher`.

Available features:
- caching
- profiling

### Query Fetcher Interface
An interface for a Query Fetcher (see [Handler/QueryFetcher](https://github.com/lmc-eu/cqrs-handler#query-fetcher)).

It is responsible for
- finding a Query Handler based on Query request type
- handle all Query features
    - caching
        - requires an instance of `Psr\Cache\CacheItemPoolInterface`
    - profiling
        - requires an instance of `Lmc\Cqrs\Handler\ProfilerBag`
- decoding a response from the Query Handler

| Method | Description |
| ---    | ---         |
| `fetch` | It fetches a response from a Query by a handler supporting the Query and decodes it. It uses a continuation pattern - `OnSuccess` and `OnError` callbacks are passed to the method directly and one of them is called with a result or an error. It never throws an exception unless an `OnSuccess` or `OnError` throws it. |
| `fetchFresh` | It works just like a `fetch` but it doesn't use a `GetCachedHandler` so it always fetch a fresh response out of a Query. |
| `fetchAndReturn` | It works just like a `fetch` but it hides a continuation pattern and instead returns a response directly. It may throw an exception, when an error occurs while handling a query. |
| `fetchFreshAndReturn` | It works just like a `fetchAndReturn` but it doesn't use a `GetCachedHandler` so it always fetch a fresh response out of a Query. |
| `addHandler` | Register a QueryHandler with priority. |
| `getHandlers` | Returns a list of all handlers, sorted by priority. |
| `addDecoder` | Register a ResponseDecoder with priority. |
| `getDecoders` | Returns a list of all response decoders, sorted by priority. |
| `enableCache` | Enables cache (requires an instance of `CacheItemPoolInterface` to really use cache) |
| `disableCache` | Disables cache (both storing and retrieving). |
| `isCacheEnabled` | Returns whether a cache is enabled. |
| `invalidateQueryCache` | Invalidates a cache item by given Query (if that query implements a `CacheableInterface` and `CacheItemPoolInterface` is set and item is in cache) |
| `invalidateCacheItem` | Invalidates a cache item by given cache key hash (if `CacheItemPoolInterface` is set and item is in cache) |

### Query Handler Interface
It is responsible for handling a specific Query request and passing a result into `OnSuccess` callback.
It must say which request it supports and it must not be able to handle a different request.
When unsupported request is passed to handle method, it must pass `UnsupportedRequestException` into `OnError` callback.
It must not throw any exception, all exception must be passed into `OnError` callback.

If necessary it may prepare a Query (for example inject a Client) - yet `prepare` method should not change a Query type or its content.
It should prepare only supported queries.
It should not throw any exception either.

---

### Command Interface
The main interface for all Commands. Command is a request which change a data and may return result data.
It is responsible for declaring and creating a request, which will be handled by `SendCommandHandlerInterface`.
An object implementing Command Interface may implement [feature](#features) and it should be handled by a `CommandSender`.

Available features:
- profiling

### Command Sender Interface
An interface for a Command Sender (see [Handler/CommandSender](https://github.com/lmc-eu/cqrs-handler#command-sender)).

It is responsible for
- finding a Send Command Handler based on Command request type
- handle all Command features
    - profiling
        - requires an instance of `Lmc\Cqrs\Handler\ProfilerBag`
- decoding a response from the Send Command Handler

| Method | Description |
| ---    | ---         |
| `send` | It sends a command by a handler supporting the Command and decodes a response. It uses a continuation pattern - `OnSuccess` and `OnError` callbacks are passed to the method directly and one of them is called with a result or an error. It never throws an exception unless an `OnSuccess` or `OnError` throws it. |
| `sendAndReturn` | It works just like a `send` bat it hides a continuation pattern and instead returns a response directly. It may throw an exception, when an error occurs while handling a query. |
| `addHandler` | Register a QueryHandler with priority. |
| `getHandlers` | Returns a list of all handlers, sorted by priority. |
| `addDecoder` | Register a ResponseDecoder with priority. |
| `getDecoders` | Returns a list of all response decoders, sorted by priority. |

### Send Command Handler Interface
It is responsible for handling a specific Command request and passing a result into `OnSuccess` callback.
It must say which request it supports and it must not be able to handle a different request.
When unsupported request is passed to handle method, it must pass `UnsupportedRequestException` into `OnError` callback.
It must not throw any exception, all exception must be passed into `OnError` callback.

If necessary it may prepare a Command (for example inject a Client) - yet `prepare` method should not change a Command type or its content.
It should prepare only supported commands.
It should not throw any exception either.

---

### Response Decoder Interface
It is meant to decode a response (a result of either `QueryHandlerInterface` or a `SendCommandHandlerInterface`).
Decoder itself should be as small as possible and it should only support the one type to decode.
Decoders should (*and are in a default implementation*) be used by a priority one by one.

If you need a decoder to be *final* and no other decoding to be done, you must return a `DecodedValue` object.
- QueryFetcher and CommandSender is responsible not to send a `DecodedValue` to any other decoder

It should be pure.
If an unsupported response is passed to decode method, it should return it untouched.
It must not throw an exception.

There is also one predefined Response Decoder to decode a json string into an array - `JsonResponseDecoder`.

### Profiler Formatter Interface
When a Command or a Query implements `Feature\ProfileableInterface` QueryFetcher/CommandSender will create a `ProfilerItem` with some information.
The `ProfilerItem` contains a raw data about a duration, request type, response, error and more and it is meant to be shown in Symfony Profiler (if you use a [CQRS bundle](https://github.com/lmc-eu/cqrs-bundle)).
Profiler Formatter format those items to provide a better experience than just a raw data, which might be lazy or unreadable without formatting.
It is responsible to format a `ProfilerItem` to the `ProfilerItem` again, so it can get/set all of `ProfilerItem` properties.

There is a `FormattedValue` Value object to help with a formatting, it can be passed to the most of the `ProfilerItem` properties as a value.
It contains both original and formatted value.

Profiler formatter can even further format already `FormattedValue`.
Multiple Formatters should be called by priority on the `ProfilerItem` one by one to create the most readable form of a `ProfilerItem`.

There is also one predefined Profiler Formatter to format (*decode*) a json string into an array - `JsonProfilerFormatter`.

---

## Features

### Cacheable Interface
It allows to store and load an object implementing this interface to `Psr\Cache\CacheItemPoolInterface`.
It uses a `CacheKey` which should be as unique as possible.

**NOTE**: It is also required to set up `Psr\Cache\CacheItemPoolInterface` implementation to `QueryFetcher`.

### Profileable Interface
It allows a profiling the object implementing this interface.
`ProfilerId` is a string, which does not have to be unique.

## Base Implementations
> Base implementations offers a method(s) which will be mostly needed in implementing Handlers etc.

### Handlers
> `AbstractQueryHandler` and `AbstractSendCommandHandler`

Offers a base implementation for asserting a supported Command/Query given to the handle method and base `prepare` method, which does nothing to the query/command (as most of handlers won't need it).

It supposed to be used like follows
```php
class MyQueryHandler extends AbstractQueryHandler
{
    public function supports(QueryInterface $query): bool
    {
        return $query->getRequestType() === ExpectedRequestClass::class;
    }

    public function handle(QueryInterface $query, OnSuccessInterface $onSuccess, OnErrorInterface $onError): void
    {
        if (!$this->assertIsSupported(ExpectedRequestClass::class, $query, $onError)) {
            return;
        }

        try {
            $response = ...;    // handle query/command ...
            $onSuccess($response);
        } catch (\Throwable $e) {
            $onError($e);
        }
    }
}
```

### Decoders

#### CallbackResponseDecoder
If you need a quick way of decoding a response, you can use this Callback Response Decoder, which allows you to pass a function to do decoding.

```php
$decoder = new CallbackResponseDecoder(
    'is_string',
    fn (string $response) => sprintf('decoded:%s', $response),
);
```

#### JsonResponseDecoder
It decodes a string which contains a json into decoded array.

---

## Other CQRS Libraries
- [Handler](https://github.com/lmc-eu/cqrs-handler)
- [Bundle](https://github.com/lmc-eu/cqrs-bundle)
- [HTTP extension](https://github.com/lmc-eu/cqrs-http)
- [SOLR extension](https://github.com/lmc-eu/cqrs-solr)
