<?php namespace Tests\Models;

use App\Models\TextBook;
use Tests\TestCase;

class TextBookTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\TextBook $textBook */
        $textBook = new TextBook();
        $this->assertNotNull($textBook);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\TextBook $textBook */
        $textBookModel = new TextBook();

        $textBookData = factory(TextBook::class)->make();
        foreach( $textBookData->toFillableArray() as $key => $value ) {
            $textBookModel->$key = $value;
        }
        $textBookModel->save();

        $this->assertNotNull(TextBook::find($textBookModel->id));
    }

}
