![PAY.](https://www.pay.nl/uploads/1/brands/main_logo.png)

# PHP SDK  Changelog #
## Release 2.0.0
### Breaking changes
* Removed methods in Result\Transaction:
    - getCurrencyAmount()
    - getPaidCurrencyAmount()
    - getPaidAmount()
    - getPaidCurrency()

* Added methods in Result\Transaction:
    - getAmountOriginal() (previously getCurrencyAmount())
    - getAmountOriginalCurrency
    - getAmountPaidOriginal ( previously getPaidCurrencyAmount() )
    - getAmountPaidOriginalCurrency
    - getAmountPaid (previously getPaidAmount())
    - getAmountPaidCurrency (previously getPaidCurrency())

### Additional changes
* Now returning field refund in the result of Instore::getAllTerminals() 
* Updated Transaction class to use API version 18
* Updated Transaction result class for using version 18
* Updated Instore class to use API version 4
* Updated samples
* Added payment model classes