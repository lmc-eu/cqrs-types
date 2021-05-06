<?php declare(strict_types=1);

namespace Lmc\Cqrs\Types\Formatter;

use Lmc\Cqrs\Types\ValueObject\FormattedValue;
use Lmc\Cqrs\Types\ValueObject\ProfilerItem;

class JsonProfilerFormatter implements ProfilerFormatterInterface
{
    public function formatItem(ProfilerItem $item): ProfilerItem
    {
        if (is_string($item->getResponse())) {
            if ($decodedJson = $this->formatJson($item->getResponse())) {
                $item->setResponse($decodedJson);
            }
        }

        if ($item->getResponse() instanceof FormattedValue && is_string($item->getResponse()->getFormatted())) {
            if ($decodedJson = $this->formatJson($item->getResponse()->getFormatted())) {
                $item->setResponse(
                    new FormattedValue(
                        $item->getResponse()->getOriginal(),
                        $decodedJson->getFormatted()
                    )
                );
            }
        }

        foreach ($item->getAdditionalData() as $key => $value) {
            if (is_string($value)) {
                if ($decodedJson = $this->formatJson($value)) {
                    $item->setAdditionalData($key, $decodedJson);
                }
            }

            if ($value instanceof FormattedValue && is_string($value->getFormatted())) {
                if ($decodedJson = $this->formatJson($value->getFormatted())) {
                    $item->setAdditionalData(
                        $key,
                        new FormattedValue($value->getOriginal(), $decodedJson->getFormatted())
                    );
                }
            }
        }

        return $item;
    }

    /** @phpstan-return ?FormattedValue<string, array> */
    private function formatJson(string $value): ?FormattedValue
    {
        return is_array($decoded = json_decode($value, true))
            ? new FormattedValue($value, $decoded)
            : null;
    }
}
