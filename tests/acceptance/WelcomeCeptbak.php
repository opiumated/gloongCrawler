<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Check that Bestsellers block is on the homepage');
$I->amOnPage("/");
$I->see("BESTSELLER PRODUCTS");