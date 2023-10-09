<?php

class HomePageCest
{
    public function tryToTest(AcceptanceTester $I) : void
    {
        $I->amOnPage('/');
        $I->see('Gestão de PDFs');
    }
}
