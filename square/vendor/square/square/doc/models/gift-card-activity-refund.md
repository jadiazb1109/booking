
# Gift Card Activity Refund

Represents details about a `REFUND` [gift card activity type](../../doc/models/gift-card-activity-type.md).

## Structure

`GiftCardActivityRefund`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `redeemActivityId` | `?string` | Optional | The ID of the refunded `REDEEM` gift card activity. Square populates this field if the<br>`payment_id` in the corresponding [RefundPayment](../../doc/apis/refunds.md#refund-payment) request<br>represents a redemption made by the same gift card. Note that you must use `RefundPayment` when refunding a<br>gift card payment made using the Payments API, Square Point of Sale, or the Seller Dashboard to the same gift card.<br><br>Applications that use a custom payment processing system can use this field in a<br>[CreateGiftCardActivity](../../doc/apis/gift-card-activities.md#create-gift-card-activity)<br>request to link a refund with a `REDEEM` activity for the same gift card. | getRedeemActivityId(): ?string | setRedeemActivityId(?string redeemActivityId): void |
| `amountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getAmountMoney(): ?Money | setAmountMoney(?Money amountMoney): void |
| `referenceId` | `?string` | Optional | A client-specified ID that associates the gift card activity with an order, payment, or other entity.<br><br>This field can be used to track information related to Square entities or entities in another system. | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `paymentId` | `?string` | Optional | The ID of the refunded payment. Square populates this field if the refund is for a<br>payment processed by Square and one of the following conditions is true:<br><br>- The Refunds API is used to refund a gift card payment to the same gift card.<br>- A seller initiated the refund from Square Point of Sale or the Seller Dashboard. The payment source can be the<br>  same gift card or a cross-tender payment from a credit card or a different gift card. | getPaymentId(): ?string | setPaymentId(?string paymentId): void |

## Example (as JSON)

```json
{
  "redeem_activity_id": null,
  "amount_money": null,
  "reference_id": null,
  "payment_id": null
}
```

