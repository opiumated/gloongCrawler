<?php
namespace Page\Acceptance;

class miniCart
{
    // include url of current page
    public static $miniCartSelector = '.minicart-wrapper';

    public static $productItemSelector = '#mini-cart > li:nth-child(1)';

    public static $incrementQtySel = '#cart-plus';

    public static $decrementQtySel = '#cart-minus';

    public static $deleteItemSel = '#mini-cart > li:nth-child(1) > div > div > div.product.actions > div.secondary > a';

    public static $itemQtyCountSel = '#mini-cart > li:nth-child(1) .cart-number';

    public static $modalSelector = 'body > div.modals-wrapper > aside.modal-popup.confirm._show > div.modal-inner-wrap > div';

    public static $modalOkaySel = 'body > div.modals-wrapper > aside.modal-popup.confirm._show > div.modal-inner-wrap > footer > button.action-primary.action-accept';

    public static $modalContentSel = 'body > div.modals-wrapper > aside.modal-popup.confirm._show > div.modal-inner-wrap > div';
    /**
     * @var \AcceptanceTester;
     */
    protected $acceptanceTester;

    public function __construct(\AcceptanceTester $I)
    {
        $this->acceptanceTester = $I;
    }


    public function IncrementQty()
    {
       $I = $this->acceptanceTester;
       $productId = $I->grabAttributeFrom(self::$productItemSelector." ".self::$incrementQtySel,"product_id");
       codecept_debug($productId);
       $qtySelector = "#product_".$productId."_qty";
       $formerQty = (int)$I->grabTextFrom($qtySelector);
       codecept_debug($formerQty);
       $I->click(self::$incrementQtySel,self::$productItemSelector);
       $I->wait(10);
       $I->dontSee("We can't update the shopping cart",self::$modalContentSel);
       //$I->click(self::$miniCartSelector);
       $I->see($formerQty+1,$qtySelector);

    }

    /**
     * @before IncrementQty
     */
    public function DecrementQty(){

        $I = $this->acceptanceTester;

        $productId = $I->grabAttributeFrom(self::$productItemSelector." ".self::$incrementQtySel,"product_id");
        codecept_debug($productId);
        $qtySelector = "#product_".$productId."_qty";
        $formerQty = (int)$I->grabTextFrom($qtySelector);
        codecept_debug($formerQty);
        $I->click(self::$decrementQtySel,self::$productItemSelector);
        $I->wait(10);
        $I->dontSee("We can't update the shopping cart",self::$modalContentSel);
        //$I->click(self::$miniCartSelector);
        $I->see($formerQty-1,$qtySelector);

    }


    public function DeleteCartItem(){
        $I = $this->acceptanceTester;
        $productIdSel = self::$productItemSelector." ".self::$incrementQtySel;
        $productId = $I->grabAttributeFrom($productIdSel,"product_id");
        codecept_debug($productId);
        $I->click(self::$deleteItemSel,self::$productItemSelector);

            try{
                $I->scrollTo(self::$modalOkaySel);
                $I->click(self::$modalOkaySel);
            }catch(\Exception $e){
                codecept_debug("error took place");

                $I->scrollTo(self::$miniCartSelector);
                $I->click(self::$miniCartSelector) ;
                $I->scrollTo(self::$modalOkaySel);
                $I->click(self::$modalOkaySel);
            }

        $I->wait(10);
        $I->dontSee("We can't remove the item.",self::$modalContentSel);
        $I->dontSeeElement($productIdSel,['product_id'=>$productId]);

    }
}
