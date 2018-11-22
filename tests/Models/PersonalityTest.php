<?php namespace Tests\Models;

use App\Models\Personality;
use Tests\TestCase;

class PersonalityTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Personality $personality */
        $personality = new Personality();
        $this->assertNotNull($personality);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Personality $personality */
        $personalityModel = new Personality();

        $personalityData = factory(Personality::class)->make();
        foreach( $personalityData->toArray() as $key => $value ) {
            $personalityModel->$key = $value;
        }
        $personalityModel->save();

        $this->assertNotNull(Personality::find($personalityModel->id));
    }

}
