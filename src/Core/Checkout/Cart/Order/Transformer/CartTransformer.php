<?php declare(strict_types=1);

namespace Shopware\Core\Checkout\Cart\Order\Transformer;

use Shopware\Core\Checkout\Cart\Cart;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\DataAbstractionLayer\FieldSerializer\JsonFieldSerializer;
use Shopware\Core\Framework\Feature;
use Shopware\Core\Framework\Util\Random;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

class CartTransformer
{
    public static function transform(Cart $cart, SalesChannelContext $context, string $stateId): array
    {
        $currency = $context->getCurrency();

        $data = [
            'orderDateTime' => (new \DateTimeImmutable())->format(Defaults::STORAGE_DATE_TIME_FORMAT),
            'price' => $cart->getPrice(),
            'shippingCosts' => $cart->getShippingCosts(),
            'stateId' => $stateId,
            'currencyId' => $currency->getId(),
            'currencyFactor' => $currency->getFactor(),
            'salesChannelId' => $context->getSalesChannel()->getId(),
            'lineItems' => [],
            'deliveries' => [],
            'deepLinkCode' => Random::getBase64UrlString(32),
            'customerComment' => $cart->getCustomerComment(),
            'affiliateCode' => $cart->getAffiliateCode(),
            'campaignCode' => $cart->getCampaignCode(),
        ];

        if (Feature::isActive('FEATURE_NEXT_6059')) {
            $data['itemRounding'] = json_decode(JsonFieldSerializer::encodeJson($context->getItemRounding()), true);
            $data['totalRounding'] = json_decode(JsonFieldSerializer::encodeJson($context->getTotalRounding()), true);
        }

        return $data;
    }
}
