<?php

class PostTypeCest
{
    public function submitPDF(AcceptanceTester $I) : void
    {
		$I->loginAsAdmin();
        $I->amOnAdminPage('/post-new.php?post_type=pdf');
        $I->fillField('post_title', 'Um novo PDF');
		$I->attachFile('_issue_pdf', 'dummy.pdf');
		$I->click('Publish');
		$I->waitForElement('.form-table');
		$I->see('Download');
    }
}
