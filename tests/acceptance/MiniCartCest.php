<?php


class MiniCartCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }


    /**
     * @param AcceptanceTester $I
     * @param \Page\CategoryPage $categoryPage
     *
     *
     * @example ["/home-large-appliances.html"]
     */
    public function addToCart(AcceptanceTester $I,\Page\CategoryPage $categoryPage,\Codeception\Example $example){
        $I->loadSessionSnapshot("cart");
        $I->amOnPage($example[0]);
        $I->saveSessionSnapshot("cart");
    }

    public function miniCartOps(AcceptanceTester $I, \Page\Acceptance\miniCart $miniCart){
        $I->loadSessionSnapshot("cart");
        $I->click($miniCart::$miniCartSelector);

        $I->wantTo("Increment Cart Qty");
        $miniCart->IncrementQty();
        $I->wantTo("Decrement Cart Qty");
        $miniCart->DecrementQty();

        $I->wantTo("delete a cart Item");
        $miniCart->DeleteCartItem();
    }




}
